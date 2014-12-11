<?php

App::uses('NodesAppController', 'Nodes.Controller');
App::uses('Croogo', 'Lib');

/**
 * Nodes Controller
 *
 * @category Nodes.Controller
 * @package  Croogo.Nodes
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodesController extends NodesAppController
{

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Nodes';

    /**
     * Components
     *
     * @var array
     * @access public
     */
    public $components = array(
        'Croogo.BulkProcess',
        'Croogo.Recaptcha',
        'Search.Prg' => array(
            'presetForm' => array(
                'paramType' => 'querystring',
            ),
            'commonProcess' => array(
                'paramType' => 'querystring',
                'filterEmpty' => true,
            ),
        ),
        'Captcha' => array(
            'field' => 'security_code'
        )
    );

    /**
     * Preset Variable Search
     *
     * @var array
     * @access public
     */
    public $presetVars = true;

    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Nodes.Node',
    );

    /**
     * afterConstruct
     */
    public function afterConstruct()
    {
        parent::afterConstruct();
        $this->_setupAclComponent();
    }

    /**
     * beforeFilter
     *
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();

        if (isset($this->request->params['slug'])) {
            $this->request->params['named']['slug'] = $this->request->params['slug'];
        }
        if (isset($this->request->params['type'])) {
            $this->request->params['named']['type'] = $this->request->params['type'];
        }
        $this->Security->unlockedActions[] = 'admin_toggle';
        $this->Security->unlockedActions[] = 'admin_userpost_toggle';
    }

    /**
     * Toggle Node status
     *
     * @param string $id Node id
     * @param integer $status Current Node status
     * @return void
     */
    public function admin_toggle($id = null, $status = null)
    {
        $this->Croogo->fieldToggle($this->{$this->modelClass}, $id, $status);
    }

    public function admin_userpost_toggle($id = null, $status = null)
    {
        if (isset($this->request->query['receive_id'])) {
            $receive_id = $this->request->query['receive_id'];
            $title = $this->request->query['title'];

            if (empty($id) || $status === null) {
                throw new CakeException(__d('croogo', 'Invalid content'));
            }
            $this->Node->id = $id;
            if($status == 2) $status =0;
            $status = (int)!$status;
            $this->layout = 'ajax';
            if ($this->Node->saveField('status', $status)) {
                $this->loadModel('Users.UserMessage');
                $message = 'Bài <strong>"' . $title . '"</strong> của bạn đã được duyệt';
                if ($status == 0) {
                    $message = 'Bài <strong>"' . $title . '"</strong> của bạn không được duyệt';
                }
                $saveData = array('UserMessage' => array(
                    'user_id' => $this->Session->read('Auth.User.id'),
                    'receive_id' => $receive_id,
                    'message' => $message,
                ));
                $this->UserMessage->save($saveData);

                $this->set(compact('id', 'status', 'receive_id', 'title'));
                $this->render('admin_userpost_toggle');
            } else {
                throw new CakeException(__d('croogo', 'Failed toggling field %s to %s', 'status', $status));
            }
        }
    }

    /**
     * Admin index
     *
     * @return void
     * @access public
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('croogo', 'Content'));
        $this->Prg->commonProcess();

        $Node = $this->{$this->modelClass};
        $Node->recursive = 0;

        $alias = $this->modelClass;
        $this->paginate[$alias]['order'] = $Node->escapeField('created') . ' DESC';
        $this->paginate[$alias]['conditions'] = array(
            'User.role_id' => '1'
        );
        $this->paginate[$alias]['contain'] = array('User');

        $types = $Node->Taxonomy->Vocabulary->Type->find('all');
        $typeAliases = Hash::extract($types, '{n}.Type.alias');
        $this->paginate[$alias]['conditions'][$Node->escapeField('type')] = $typeAliases;

        $criteria = $Node->parseCriteria($this->Prg->parsedParams());
        $nodes = $this->paginate($criteria);
        $nodeTypes = $Node->Taxonomy->Vocabulary->Type->find('list', array(
            'fields' => array('Type.alias', 'Type.title')
        ));
        $this->set(compact('nodes', 'types', 'typeAliases', 'nodeTypes'));

        if (isset($this->request->params['named']['links']) || isset($this->request->query['chooser'])) {
            $this->layout = 'admin_popup';
            $this->render('admin_chooser');
        }
    }

    public function admin_users_posts()
    {
        $this->set('title_for_layout', __d('croogo', 'Content'));
        $this->Prg->commonProcess();

        $Node = $this->{$this->modelClass};
        $Node->recursive = 0;

        $alias = $this->modelClass;
        $this->paginate[$alias]['order'] = $Node->escapeField('created') . ' DESC';
        $this->paginate[$alias]['conditions'] = array(
            'User.role_id <>' => '1'
        );
        $this->paginate[$alias]['contain'] = array('User');

        $types = $Node->Taxonomy->Vocabulary->Type->find('all');
        $typeAliases = Hash::extract($types, '{n}.Type.alias');
        $this->paginate[$alias]['conditions'][$Node->escapeField('type')] = $typeAliases;

        $criteria = $Node->parseCriteria($this->Prg->parsedParams());
        $nodes = $this->paginate($criteria);
        $nodeTypes = $Node->Taxonomy->Vocabulary->Type->find('list', array(
            'fields' => array('Type.alias', 'Type.title')
        ));
        $this->set(compact('nodes', 'types', 'typeAliases', 'nodeTypes'));

        if (isset($this->request->params['named']['links']) || isset($this->request->query['chooser'])) {
            $this->layout = 'admin_popup';
            $this->render('admin_chooser');
        }
    }

    public function hot_clip()
    {
//        $hot_nodes = $this->Node->findHotNodes(10);
        $hot_nodes = $this->Node->findRandomNodes(6, 'clip');
        $this->set(compact('hot_nodes'));
    }

    /**
     * Admin create
     *
     * @return void
     * @access public
     */
    public function admin_create()
    {
        $this->set('title_for_layout', __d('croogo', 'Create content'));

        $types = $this->{$this->modelClass}->Taxonomy->Vocabulary->Type->find('all', array(
            'order' => array(
                'Type.alias' => 'ASC',
            ),
        ));
        $this->set(compact('types'));
    }
    public function admin_approve_post($id=null)
    {
        if($this->request->isAjax()){
            if(isset($this->request->query['image'])){
                $this->loadModel('Meta.Meta');
                $meta = $this->Meta->find('first',array('conditions'=>array(
                    'Meta.model'=>'Node',
                    'Meta.key'=>'image',
                    'Meta.foreign_key'=>$id
                )));
                $saveData = array(
                    'Meta'=>array(
                        'model'=>'Node',
                        'key'=>'image',
                        'foreign_key'=>$id,
                        'value'=>$this->request->query['image'],
                    )
                );
                if(count($meta)>0){
                    $saveData['Meta']['id']=$meta['Meta']['id'];
                }
                if($this->Meta->save($saveData)) echo 1;
                else echo 0;
            }else echo 0;
            die;
        }else{
            $url = '/admin/nodes/nodes/users_posts?status=2';
            if(isset($this->request->query['url'])){
                $url = $this->request->query['url'];
            }
            if (!$id) {
                $this->Session->setFlash(__d('croogo', 'Invalid id for Node'), 'flash', array('class' => 'error'));
                return $this->redirect($url);
            }
            $Node = $this->{$this->modelClass};
            $Node->id = $id;
            $typeAlias = $Node->field('type');
            $saveData = array('Node'=>array(
                'id' => $id,
                'status'=>1,
            ));
            $title = $Node->field('title');
            $receive_id = $Node->field('user_id');
            if($Node->saveNode($saveData, $typeAlias)){
                $this->loadModel('Users.UserMessage');
                $message = 'Bài <strong>"' . $title . '"</strong> của bạn đã được duyệt';
                $saveData = array('UserMessage' => array(
                    'user_id' => $this->Session->read('Auth.User.id'),
                    'receive_id' => $receive_id,
                    'message' => $message,
                ));
                $this->UserMessage->save($saveData);
            };
            return $this->redirect($url);
        }
    }

    /**
     * Admin add
     *
     * @param string $typeAlias
     * @return void
     * @access public
     */
    public function admin_add($typeAlias = 'node')
    {
        $Node = $this->{$this->modelClass};
        $type = $Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
        if (!isset($type['Type']['alias'])) {
            $this->Session->setFlash(__d('croogo', 'Content type does not exist.'));
            return $this->redirect(array('action' => 'create'));
        }

        if (!empty($this->request->data)) {
            if (isset($this->request->data[$Node->alias]['type'])) {
                $typeAlias = $this->request->data[$Node->alias]['type'];
                $Node->type = $typeAlias;
            }
            if ($Node->saveNode($this->request->data, $typeAlias)) {
                Croogo::dispatchEvent('Controller.Nodes.afterAdd', $this, array('data' => $this->request->data));
                $this->Session->setFlash(__d('croogo', '%s has been saved', $type['Type']['title']), 'flash', array('class' => 'success'));
                $this->Croogo->redirect(array('action' => 'edit', $Node->id));
            } else {
                $this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', $type['Type']['title']), 'flash', array('class' => 'error'));
            }
        } else {
            $this->Croogo->setReferer();
            $this->request->data[$Node->alias]['user_id'] = $this->Session->read('Auth.User.id');
        }

        $this->set('title_for_layout', __d('croogo', 'Create content: %s', $type['Type']['title']));
        $Node->type = $type['Type']['alias'];
        $Node->Behaviors->attach('Tree', array(
            'scope' => array(
                $Node->escapeField('type') => $Node->type,
            ),
        ));

        $this->_setCommonVariables($type);
    }

    /**
     * Admin edit
     *
     * @param integer $id
     * @return void
     * @access public
     */
    public function admin_edit($id = null)
    {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('croogo', 'Invalid content'), 'flash', array('class' => 'error'));
            return $this->redirect(array('action' => 'index'));
        }
        $Node = $this->{$this->modelClass};
        $Node->id = $id;
        $typeAlias = $Node->field('type');
        $type = $Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);

        if (!empty($this->request->data)) {
            if ($Node->saveNode($this->request->data, $typeAlias)) {
                Croogo::dispatchEvent('Controller.Nodes.afterEdit', $this, compact('data'));
                $this->Session->setFlash(__d('croogo', '%s has been saved', $type['Type']['title']), 'flash', array('class' => 'success'));
                $this->Croogo->redirect(array('action' => 'edit', $Node->id));
            } else {
                $this->Session->setFlash(__d('croogo', '%s could not be saved. Please, try again.', $type['Type']['title']), 'flash', array('class' => 'error'));
            }
        }
        if (empty($this->request->data)) {
            $this->Croogo->setReferer();
            $data = $Node->read(null, $id);
            $data['Role']['Role'] = $Node->decodeData($data[$Node->alias]['visibility_roles']);
            $this->request->data = $data;
        }

        $this->set('title_for_layout', __d('croogo', 'Edit %s: %s', $type['Type']['title'], $this->request->data[$Node->alias]['title']));
        $this->_setCommonVariables($type);
    }

    /**
     * Admin update paths
     *
     * @return void
     * @access public
     */
    public function admin_update_paths()
    {
        $Node = $this->{$this->modelClass};
        if ($Node->updateAllNodesPaths()) {
            $messageFlash = __d('croogo', 'Paths updated.');
            $class = 'success';
        } else {
            $messageFlash = __d('croogo', 'Something went wrong while updating paths.' . "\n" . 'Please try again');
            $class = 'error';
        }

        $this->Session->setFlash($messageFlash, 'flash', compact('class'));
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * Admin delete
     *
     * @param integer $id
     * @return void
     * @access public
     */
    public function admin_userpost_delete($id = null)
    {
        $Node = $this->{$this->modelClass};
        if ($Node->delete($id)) {
            if (isset($this->request->query['receive_id'])) {
                $receive_id = $this->request->query['receive_id'];
                $title = $this->request->query['title'];
                $this->loadModel('Users.UserMessage');
                $message = 'Bài <strong>"' . $title . '"</strong> của bạn đã bị xoá';

                $saveData = array('UserMessage' => array(
                    'user_id' => $this->Session->read('Auth.User.id'),
                    'receive_id' => $receive_id,
                    'message' => $message,
                ));
                $this->UserMessage->save($saveData);
            }
        }
        return $this->redirect(array('admin'=>true,'plugin'=>'nodes','controller'=>'nodes','action' => 'users_posts','?'=>array('status'=>'2')));
    }

    public function admin_delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__d('croogo', 'Invalid id for Node'), 'flash', array('class' => 'error'));
            return $this->redirect(array('action' => 'index'));
        }
        $Node = $this->{$this->modelClass};
        if ($Node->delete($id)) {
            $this->Session->setFlash(__d('croogo', 'Node deleted'), 'flash', array('class' => 'success'));
            return $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Admin delete meta
     *
     * @param integer $id
     * @return void
     * @access public
     * @deprecated Use MetaController::admin_delete_meta()
     */
    public function admin_delete_meta($id = null)
    {
        $success = false;
        $Node = $this->{$this->modelClass};
        if ($id != null && $Node->Meta->delete($id)) {
            $success = true;
        } else {
            if (!$Node->Meta->exists($id)) {
                $success = true;
            }
        }

        $success = array('success' => $success);
        $this->set(compact('success'));
        $this->set('_serialize', 'success');
    }

    /**
     * Admin add meta
     *
     * @return void
     * @access public
     * @deprecated Use MetaController::admin_add_meta()
     */
    public function admin_add_meta()
    {
        $this->layout = 'ajax';
    }

    /**
     * Admin process
     *
     * @return void
     * @access public
     */
    public function admin_process()
    {
        $Node = $this->{$this->modelClass};
        list($action, $ids) = $this->BulkProcess->getRequestVars($Node->alias);

        $options = array(
            'multiple' => array('copy' => false),
            'messageMap' => array(
                'delete' => __d('croogo', 'Nodes deleted'),
                'publish' => __d('croogo', 'Nodes published'),
                'unpublish' => __d('croogo', 'Nodes unpublished'),
                'promote' => __d('croogo', 'Nodes promoted'),
                'unpromote' => __d('croogo', 'Nodes unpromoted'),
                'copy' => __d('croogo', 'Nodes copied'),
            ),
        );
        return $this->BulkProcess->process($Node, $action, $ids, $options);
    }

    /**
     * Index
     *
     * @return void
     * @access public
     */
    public function index()
    {
        if(isset($this->request->query['random']) && !$this->request->isAjax()){
            $count = $this->Node->find('count',array('conditions'=>array('Node.type'=>'clip','Node.status'=>'1')));
            $new_nodes = $this->Node->findRandomNodes($count, 'clip');
            //title,path,images
            $MONGOLAB_API_KEY = 'm49Rbnq2Rm_QNa_UIHKwOUYgIfdMlB3F';
            $DB = 'haytuyet';
            $COLLECTION = 'data';
            $url = "https://api.mongolab.com/api/1/databases/$DB/collections/$COLLECTION?apiKey=$MONGOLAB_API_KEY";
            $temp = array();
            foreach($new_nodes as $key=>$node){
                $a = array(
                    'title'=>$node['Node']['title'],
                    'path'=>$node['Node']['path'],
                    'image'=>$node['CustomFields']['image'],
                );
                $temp[] = $a;
            }
            echo json_encode($temp);
            die;
        }else{
            if (!isset($this->request->params['named']['type'])) {
                $this->request->params['named']['type'] = 'clip';
            }
            if (!isset($this->request->params['by'])) {
                $this->request->params['by'] = 'created';
            }
            if ($this->request->isAjax()) {
                $this->layout = 'ajax';
                if(isset($this->request->query['random'])){
                    $new_nodes = $this->Node->findRandomNodes(12, 'clip');
                }
                else{
                    $new_nodes = $this->Node->findNewNodes(12, 'clip');
                }
                $this->view = 'new_ajax';
                $this->set(compact('new_nodes'));
            } else {
                $Node = $this->{$this->modelClass};
                $this->paginate[$Node->alias]['order'] = $Node->escapeField($this->request->params['by']) . ' DESC';
                $visibilityRolesField = $Node->escapeField('visibility_roles');
                $this->paginate[$Node->alias]['conditions'] = array(
                    $Node->escapeField('status') => $Node->status(),
                    'OR' => array(
                        $visibilityRolesField => '',
                        $visibilityRolesField . ' LIKE' => '%"' . $this->Croogo->roleId() . '"%',
                    ),
                );

                if (isset($this->request->params['named']['limit'])) {
                    $limit = $this->request->params['named']['limit'];
                } else {
                    $limit = Configure::read('Reading.nodes_per_page');
                }

                $this->paginate[$Node->alias]['contain'] = array(
                    'Meta',
                    'Taxonomy' => array(
                        'Term',
                        'Vocabulary',
                    ),
                    'User',
                );
                if (isset($this->request->params['named']['type'])) {
                    $type = $Node->Taxonomy->Vocabulary->Type->find('first', array(
                        'conditions' => array(
                            'Type.alias' => $this->request->params['named']['type'],
                        ),
                        'cache' => array(
                            'name' => 'type_' . $this->request->params['named']['type'] . '_' . $this->request->params['by'],
                            'config' => 'nodes_index',
                        ),
                    ));
                    if (!isset($type['Type']['id'])) {
                        $this->Session->setFlash(__d('croogo', 'Invalid content type.'), 'flash', array('class' => 'error'));
                        return $this->redirect('/');
                    }
                    if (isset($type['Params']['nodes_per_page']) && empty($this->request->params['named']['limit'])) {
                        $limit = $type['Params']['nodes_per_page'];
                    }
                    $this->paginate[$Node->alias]['conditions']['Node.type'] = $type['Type']['alias'];
                    $this->set('title_for_layout', $type['Type']['title']);
                }

                $this->paginate[$Node->alias]['limit'] = $limit;

                if ($this->usePaginationCache) {
                    $cacheNamePrefix = 'nodes_index_' . $this->Croogo->roleId() . '_' . Configure::read('Config.language');
                    if (isset($type)) {
                        $cacheNamePrefix .= '_' . $type['Type']['alias'] . '_' . $this->request->params['by'];
                    }
                    $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
                    $cacheName = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $this->request->params['by'] . '_' . $this->paginate['page'] . '_' . $limit;
                    $cacheNamePaging = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $this->request->params['by'] . '_' . $this->paginate['page'] . '_' . $limit . '_paging';
                    $cacheConfig = 'nodes_index';
                    $nodes = Cache::read($cacheName, $cacheConfig);
                    if (!$nodes) {
                        $nodes = $this->paginate($Node->alias);
                        Cache::write($cacheName, $nodes, $cacheConfig);
                        Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
                    } else {
                        $paging = Cache::read($cacheNamePaging, $cacheConfig);
                        $this->request->params['paging'] = $paging;
                    }
                } else {
                    $nodes = $this->paginate($Node->alias);
                }

                $this->set(compact('type', 'nodes'));
                $this->Croogo->viewFallback(array(
                    'index_' . $type['Type']['alias'],
                ));
            }
        }

    }

    /**
     * Index
     *
     * @return void
     * @access public
     */
    public function user_posted($user_id = 0)
    {
        if(isset($this->request->named['user_id'])){
            $user_id = $this->request->named['user_id'];
        }
        if (!isset($this->request->params['named']['type'])) {
            $this->request->params['named']['type'] = 'clip';
        }
        if (!isset($this->request->params['named']['by'])) {
            $this->request->params['named']['by'] = 'created';
        }
        $Node = $this->{$this->modelClass};
        $this->paginate[$Node->alias]['order'] = $Node->escapeField($this->request->params['named']['by']) . ' DESC';
        $visibilityRolesField = $Node->escapeField('visibility_roles');
        $this->paginate[$Node->alias]['conditions'] = array(
            $Node->escapeField('status') => $Node->status(),
            'Node.user_id' => $user_id,
            'OR' => array(
                $visibilityRolesField => '',
                $visibilityRolesField . ' LIKE' => '%"' . $this->Croogo->roleId() . '"%',
            ),
        );

        if (isset($this->request->params['named']['limit'])) {
            $limit = $this->request->params['named']['limit'];
        } else {
            $limit = Configure::read('Reading.nodes_per_page');
        }

        $this->paginate[$Node->alias]['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ),
            'User',
        );
        if (isset($this->request->params['named']['type'])) {
            $type = $Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->request->params['named']['type'],
                ),
                'cache' => array(
                    'name' => 'type_' . $this->request->params['named']['type'] . '_' . $user_id,
                    'config' => 'nodes_index',
                ),
            ));
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__d('croogo', 'Invalid content type.'), 'flash', array('class' => 'error'));
                return $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page']) && empty($user_id)) {
                $limit = $type['Params']['nodes_per_page'];
            }
            $this->paginate[$Node->alias]['conditions']['Node.type'] = $type['Type']['alias'];
            $this->set('title_for_layout', $type['Type']['title']);
        }

        $this->paginate[$Node->alias]['limit'] = $limit;

        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_index_' . $this->Croogo->roleId() . '_' . Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix .= '_' . $type['Type']['alias'] . '_' . $user_id;
            }
            $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $user_id . '_' . $this->paginate['page'] . '_' . $limit;
            $cacheNamePaging = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $user_id . '_' . $this->paginate['page'] . '_' . $limit . '_paging';
            $cacheConfig = 'nodes_index';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate($Node->alias);
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->request->params['paging'] = $paging;
            }
        } else {
            $nodes = $this->paginate($Node->alias);
        }

        $this->set('user_id', $user_id);
        $this->set(compact('type', 'nodes'));
        $this->Croogo->viewFallback(array(
            'index_' . $type['Type']['alias'],
        ));
    }

    /**
     * Term
     *
     * @return void
     * @access public
     */
    public function term()
    {
        $Node = $this->{$this->modelClass};
        $term = $Node->Taxonomy->Term->find('first', array(
            'conditions' => array(
                'Term.slug' => $this->request->params['named']['slug'],
            ),
            'cache' => array(
                'name' => 'term_' . $this->request->params['named']['slug'],
                'config' => 'nodes_term',
            ),
        ));
        if (!isset($term['Term']['id'])) {
            $this->Session->setFlash(__d('croogo', 'Invalid Term.'), 'flash', array('class' => 'error'));
            return $this->redirect('/');
        }

        if (!isset($this->request->params['named']['type'])) {
            $this->request->params['named']['type'] = 'node';
        }

        if (isset($this->request->params['named']['limit'])) {
            $limit = $this->request->params['named']['limit'];
        } else {
            $limit = Configure::read('Reading.nodes_per_page');
        }

        $this->paginate[$Node->alias]['order'] = $Node->escapeField('created') . ' DESC';
        $visibilityRolesField = $Node->escapeField('visibility_roles');
        $this->paginate[$Node->alias]['conditions'] = array(
            $Node->escapeField('status') => $Node->status(),
            $Node->escapeField('terms') . ' LIKE' => '%"' . $this->request->params['named']['slug'] . '"%',
            'OR' => array(
                $visibilityRolesField => '',
                $visibilityRolesField . ' LIKE' => '%"' . $this->Croogo->roleId() . '"%',
            ),
        );
        $this->paginate[$Node->alias]['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ),
            'User',
        );
        if (isset($this->request->params['named']['type'])) {
            $type = $Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->request->params['named']['type'],
                ),
                'cache' => array(
                    'name' => 'type_' . $this->request->params['named']['type'],
                    'config' => 'nodes_term',
                ),
            ));
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__d('croogo', 'Invalid content type.'), 'flash', array('class' => 'error'));
                return $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page']) && empty($this->request->params['named']['limit'])) {
                $limit = $type['Params']['nodes_per_page'];
            }
            $this->paginate[$Node->alias]['conditions'][$Node->escapeField('type')] = $type['Type']['alias'];
            $this->set('title_for_layout', $term['Term']['title']);
        }

        $this->paginate[$Node->alias]['limit'] = $limit;

        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_term_' . $this->Croogo->roleId() . '_' . $this->request->params['named']['slug'] . '_' . Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix .= '_' . $type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $limit;
            $cacheNamePaging = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $limit . '_paging';
            $cacheConfig = 'nodes_term';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate($Node->alias);
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->request->params['paging'] = $paging;
            }
        } else {
            $nodes = $this->paginate($Node->alias);
        }

        $this->set(compact('term', 'type', 'nodes'));
        $this->Croogo->viewFallback(array(
            'term_' . $term['Term']['id'],
            'term_' . $term['Term']['slug'],
            'term_' . $type['Type']['alias'] . '_' . $term['Term']['slug'],
            'term_' . $type['Type']['alias'],
        ));
    }

    /**
     * Promoted
     *
     * @return void
     * @access public
     */
    public function promoted()
    {
        $Node = $this->{$this->modelClass};
        $this->set('title_for_layout', __d('croogo', 'Home'));

        $roleId = $this->Croogo->roleId();
        $this->paginate[$Node->alias]['type'] = 'promoted';
        $visibilityRolesField = $Node->escapeField('visibility_roles');
        $this->paginate[$Node->alias]['conditions'] = array(
            'OR' => array(
                $visibilityRolesField => '',
                $visibilityRolesField . ' LIKE' => '%"' . $roleId . '"%',
            ),
        );

        if (isset($this->request->params['named']['limit'])) {
            $limit = $this->request->params['named']['limit'];
        } else {
            $limit = Configure::read('Reading.nodes_per_page');
        }

        if (isset($this->request->params['named']['type'])) {
            $type = $Node->Taxonomy->Vocabulary->Type->findByAlias($this->request->params['named']['type']);
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__d('croogo', 'Invalid content type.'), 'flash', array('class' => 'error'));
                return $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page']) && empty($this->request->params['named']['limit'])) {
                $limit = $type['Params']['nodes_per_page'];
            }
            $this->paginate[$Node->alias]['conditions'][$Node->escapeField('type')] = $type['Type']['alias'];
            $this->set('title_for_layout', $type['Type']['title']);
            $this->set(compact('type'));
        }

        $this->paginate[$Node->alias]['limit'] = $limit;

        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_promoted_' . $this->Croogo->roleId() . '_' . Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix .= '_' . $type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $limit;
            $cacheNamePaging = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $limit . '_paging';
            $cacheConfig = 'nodes_promoted';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate($Node->alias);
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->request->params['paging'] = $paging;
            }
        } else {
            $nodes = $this->paginate($Node->alias);
        }
        $this->set(compact('nodes'));
    }

    /**
     * Search
     *
     * @param string $typeAlias
     * @return void
     * @access public
     */
    public function search($typeAlias = null)
    {
        $this->Prg->commonProcess();

        $Node = $this->{$this->modelClass};

        $this->paginate = array(
            'published',
            'roleId' => $this->Croogo->roleId(),
        );

        $q = null;
        if (isset($this->request->query['q'])) {
            $q = $this->request->query['q'];
            $this->paginate['q'] = $q;
        }

        if ($typeAlias) {
            $type = $Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(__d('croogo', 'Invalid content type.'), 'flash', array('class' => 'error'));
                return $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['typeAlias'] = $typeAlias;
        }

        $criteria = $Node->parseCriteria($this->Prg->parsedParams());
        $nodes = $this->paginate($criteria);
        $this->set(compact('q', 'nodes'));
        if ($typeAlias) {
            $this->Croogo->viewFallback(array(
                'search_' . $typeAlias,
            ));
        }
    }

    /**
     * View
     *
     * @param integer $id
     * @return void
     * @access public
     */
    public function view($id = null)
    {
        $node_id = $id;
        $Node = $this->{$this->modelClass};
        if (isset($this->request->params['named']['slug']) && isset($this->request->params['named']['type'])) {
            $Node->type = $this->request->params['named']['type'];
            $type = $Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $Node->type,
                ),
                'cache' => array(
                    'name' => 'type_' . $Node->type,
                    'config' => 'nodes_view',
                ),
            ));
            $node = $Node->find('viewBySlug', array(
                'slug' => $this->request->params['named']['slug'],
                'type' => $this->request->params['named']['type'],
                'roleId' => $this->Croogo->roleId(),
            ));
            $node_id = $node['Node']['id'];
        } elseif ($id == null) {
            $this->Session->setFlash(__d('croogo', 'Invalid content'), 'flash', array('class' => 'error'));
            return $this->redirect('/');
        } else {
            $node = $Node->find('viewById', array(
                'id' => $id,
                'roleId' => $this->Croogo->roleId,
            ));
            $Node->type = $node[$Node->alias]['type'];
            $type = $Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $Node->type,
                ),
                'cache' => array(
                    'name' => 'type_' . $Node->type,
                    'config' => 'nodes_view',
                ),
            ));
        }

        if (!isset($node[$Node->alias][$Node->primaryKey])) {
            $this->Session->setFlash(__d('croogo', 'Invalid content'), 'flash', array('class' => 'error'));
            return $this->redirect('/');
        }

        $data = $node;
        $event = new CakeEvent('Controller.Nodes.view', $this, compact('data'));
        $this->getEventManager()->dispatch($event);

        $this->set('title_for_layout', $node[$Node->alias]['title']);
        $this->set(compact('node', 'type', 'comments'));
        $this->Croogo->viewFallback(array(
            'view_' . $type['Type']['alias'] . '_' . $node[$Node->alias]['slug'],
            'view_' . $node[$Node->alias][$Node->primaryKey],
            'view_' . $type['Type']['alias'],
        ));
        $this->set('nextNprev', $this->Node->findNextPrev($node_id));
    }

    public function update_view($id = null)
    {
        if($this->request->isAjax()){
//        if($this->Session->read('Auth.User.role_id')!=1){
        if ($id != null) {
            $this->Node->updateAll(
                array('Node.counts' => 'Node.counts+1'),
                array('Node.id' => $id)
            );
        }
        if ($id != null) {
            if (isset($this->request->query['url'])) {
                $url = urldecode($this->request->query['url']);
                $content = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls=' . $url);
//                $content = file_get_contents(
//                    'http://free.sharedcount.com/url?url='
//                    . $url.'&apikey=479dfb502221d2b4c4a0433c600e16ba5dc0df4e');
//                print_r($content);
                $json_content = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);
                if (Cache::read('fb_post' . $id, 'long')) {
                    $old_content = Cache::read('fb_post' . $id, 'long');
                    if ($content != $old_content) {
                        if (isset($json_content[0]['like_count'])) {
                            $this->Node->updateAll(
                                array(
                                    'Node.likes' => $json_content[0]['like_count'],
                                    'Node.comments' => $json_content[0]['commentsbox_count'],
                                    'Node.shares' => $json_content[0]['share_count'],
                                    'Node.comments_fbid' => $json_content[0]['comments_fbid']
                                ),
                                array('Node.id' => $id)
                            );
                        }
                        Cache::write('fb_post' . $id, $content, 'long');
                    } else {

                    }
                } else {
                    if (isset($json_content[0]['like_count'])) {
                        $this->Node->updateAll(
                            array(
                                'Node.likes' => $json_content[0]['like_count'],
                                'Node.comments' => $json_content[0]['commentsbox_count'],
                                'Node.shares' => $json_content[0]['share_count'],
                                'Node.comments_fbid' => $json_content[0]['comments_fbid']
                            ),
                            array('Node.id' => $id)
                        );
                    }
                    Cache::write('fb_post' . $id, $content, 'long');
                }
            }
        }
//        }else echo 1;
        }else{
            echo 'not allow';
        }
        die;
    }

    public function user_post()
    {
        $this->helpers[] = 'Captcha';
        $cont = true;
        if ($this->request->is('post')) {
            $title = $this->request->data['Node']['title'];
            $slug = $this->make_title_furl($this->request->data['Node']['title']);
            //$this->Node->setCaptcha('security_code', $this->Captcha->getCode('Node.security_code'));
            $this->Node->set(array('Node' => array(
                // 'security_code' => $this->request->data['Node']['security_code'],
                'slug' => $slug,
            )));
            if ($this->Node->validates()) {
                $img = '';
                $youtube_clip = '';
                if (isset($this->request->data['Node']['youtube_clip']))
                    $youtube_clip = $this->youtube_id_from_url($this->request->data['Node']['youtube_clip']);
                if (!empty($youtube_clip)) {
                    if (empty($this->request->data['Node']['link_image'])) {
                        if (isset($this->request->data['Node']['image']['name']) && !empty($this->request->data['Node']['image']['name'])) {
                            if ($this->request->data['Node']['image']['size'] < 500000) {
                                $file = $this->request->data['Node']['image']; //put the data into a var for easy use

                                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                                $arr_ext = array('png', 'jpg', 'jpeg', 'gif'); //set allowed extensions

                                //only process if the extension is valid
                                if (in_array($ext, $arr_ext)) {
                                    //do the actual uploading of the file. First arg is the tmp name, second arg is
                                    //where we are putting it
                                    $tempName = uniqid() . '.' . $ext;
                                    move_uploaded_file($file['tmp_name'], WWW_ROOT . '/img/uploads/' . $tempName);
                                    //prepare the filename for database entry
                                    $img = '/img/uploads/' . $tempName;
                                }
                            } else {
                                $this->Session->setFlash(__d('croogo', 'Kích thước ảnh phải nhỏ hơn 500kb'), 'message', array('class' => 'alert-warning'));
                                $cont = false;
                            }
                        }
                    } else {
                        $img = $this->request->data['Node']['link_image'];
                    }
                    if ($cont) {


                        if (empty($img) && !empty($youtube_clip))
                            $img = 'http://img.youtube.com/vi/' . $youtube_clip . '/sddefault.jpg';
                        $temp_data = array(
                            'Node' => array(
                                'title' => $title,
                                'slug' => $slug,
                                'excerpt' => $title,
                                'body' => '',
                                'user_id' => $this->Session->read('Auth.User.id'),
                                'type' => 'clip',
                                'comment_status' => '2',
                                'status' => '2',
                                'promote' => '0',
                            ),
                            'Meta' => array(
                                array(
                                    'key' => 'image',
                                    'value' => $img
                                ),
                                array(
                                    'key' => 'youtube_clip',
                                    'value' => $youtube_clip
                                ),
                            )
                        );
                        $Node = $this->{$this->modelClass};
                        if ($Node->saveNode($temp_data, 'clip')) {
                            Croogo::dispatchEvent('Controller.Nodes.afterAdd', $this, array('data' => $temp_data));
                            $this->Session->setFlash(__d('croogo', 'Bài đã được đăng và đang chờ duyệt'), 'message', array('class' => 'alert-success'));
                            $this->view = 'post_success';
                            $this->request->data = array();
                        } else {
                            $this->Session->setFlash(__d('croogo', 'Không thể lưu bài'), 'message', array('class' => 'alert-warning'));
                        }
                    }
                } else {
                    $this->Session->setFlash(__d('croogo', 'Clip không được bỏ trống'), 'message', array('class' => 'alert-warning'));
                }
            } else {
                $this->Session->setFlash(__d('croogo', 'Mã bảo mật sai hoặc bài này đã có người đăng rồi !!!'), 'message', array('class' => 'alert-warning'));
            }
        }
    }

    function  captcha()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $this->Captcha->create();
    }

    /**
     * View Fallback
     *
     * @param mixed $views
     * @return string
     * @access protected
     * @deprecated Use CroogoComponent::viewFallback()
     */
    protected function _viewFallback($views)
    {
        return $this->Croogo->viewFallback($views);
    }

    /**
     * Set common form variables to views
     * @param array $type Type data
     * @return void
     */
    protected function _setCommonVariables($type)
    {
        if (isset($this->Taxonomies)) {
            $this->Taxonomies->prepareCommonData($type);
        }
        $Node = $this->{$this->modelClass};
        if (!empty($this->request->data[$Node->alias]['parent_id'])) {
            $Node->id = $this->request->data[$Node->alias]['parent_id'];
            $parentTitle = $Node->field('title');
        }
        $roles = $Node->User->Role->find('list');
        $this->set(compact('parentTitle', 'roles'));
    }

    /**
     * get youtube video ID from URL
     *
     * @param string $url
     *
     * @return string Youtube video id or FALSE if none found.
     */
    public function youtube_id_from_url($url)
    {
        $pattern =
            '%^# Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x';
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            if (isset($matches[1]))
                return $matches[1];
            else return false;
        }

        return false;
    }

    public function sitemap()
    {
        $nodes = $this->Node->find('all', array(
            'conditions' => array(
                'Node.type' => 'clip',
                'Node.status <>' => '0'
            )
        ));
        $this->layout = 'xml/default';
        $this->set(compact('nodes'));
        $this->RequestHandler->respondAs('application/xml');
    }

    public function make_title_furl($text)
    {
        $text = preg_replace('/ä|æ|ǽ/', 'ae', $text);
        $text = preg_replace('/ö|œ/', 'oe', $text);
        $text = preg_replace('/ü/', 'ue', $text);
        $text = preg_replace('/Ä/', 'Ae', $text);
        $text = preg_replace('/Ü/', 'Ue', $text);
        $text = preg_replace('/Ö/', 'Oe', $text);
        $text = preg_replace('/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/', 'A', $text);
        $text = preg_replace('/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/', 'a', $text);
        $text = preg_replace('/Ç|Ć|Ĉ|Ċ|Č/', 'C', $text);
        $text = preg_replace('/ç|ć|ĉ|ċ|č/', 'c', $text);
        $text = preg_replace('/Ð|Ď|Đ/', 'D', $text);
        $text = preg_replace('/ð|ď|đ/', 'd', $text);
        $text = preg_replace('/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/', 'E', $text);
        $text = preg_replace('/è|é|ê|ë|ē|ĕ|ė|ę|ě|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/', 'e', $text);
        $text = preg_replace('/Ĝ|Ğ|Ġ|Ģ/', 'G', $text);
        $text = preg_replace('/ĝ|ğ|ġ|ģ/', 'g', $text);
        $text = preg_replace('/Ĥ|Ħ/', 'H', $text);
        $text = preg_replace('/ĥ|ħ/', 'h', $text);
        $text = preg_replace('/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Ì|Í|Ị|Ỉ|Ĩ/', 'I', $text);
        $text = preg_replace('/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|ì|í|ị|ỉ|ĩ/', 'i', $text);
        $text = preg_replace('/Ĵ/', 'J', $text);
        $text = preg_replace('/ĵ/', 'j', $text);
        $text = preg_replace('/Ķ/', 'K', $text);
        $text = preg_replace('/ķ/', 'k', $text);
        $text = preg_replace('/Ĺ|Ļ|Ľ|Ŀ|Ł/', 'L', $text);
        $text = preg_replace('/ĺ|ļ|ľ|ŀ|ł/', 'l', $text);
        $text = preg_replace('/Ñ|Ń|Ņ|Ň/', 'N', $text);
        $text = preg_replace('/ñ|ń|ņ|ň|ŉ/', 'n', $text);
        $text = preg_replace('/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/', 'O', $text);
        $text = preg_replace('/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/', 'o', $text);
        $text = preg_replace('/Ŕ|Ŗ|Ř/', 'R', $text);
        $text = preg_replace('/ŕ|ŗ|ř/', 'r', $text);
        $text = preg_replace('/Ś|Ŝ|Ş|Š/', 'S', $text);
        $text = preg_replace('/ś|ŝ|ş|š|ſ/', 's', $text);
        $text = preg_replace('/Ţ|Ť|Ŧ/', 'T', $text);
        $text = preg_replace('/ţ|ť|ŧ/', 't', $text);
        $text = preg_replace('/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/', 'U', $text);
        $text = preg_replace('/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/', 'u', $text);
        $text = preg_replace('/Ý|Ÿ|Ŷ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/', 'Y', $text);
        $text = preg_replace('/ý|ÿ|ŷ|ỳ|ý|ỵ|ỷ|ỹ/', 'y', $text);
        $text = preg_replace('/Ŵ/', 'W', $text);
        $text = preg_replace('/ŵ/', 'w', $text);
        $text = preg_replace('/Ź|Ż|Ž/', 'Z', $text);
        $text = preg_replace('/ź|ż|ž/', 'z', $text);
        $text = preg_replace('/Æ|Ǽ/', 'AE', $text);
        $text = preg_replace('/ß/', 'ss', $text);
        $text = preg_replace('/Ĳ/', 'IJ', $text);
        $text = preg_replace('/ĳ/', 'ij', $text);
        $text = preg_replace('/Œ/', 'OE', $text);
        $text = preg_replace('/ƒ/', 'f', $text);
        // Cyrillic Letters
        $text = preg_replace('/А/', 'A', $text);
        $text = preg_replace('/Б/', 'B', $text);
        $text = preg_replace('/В/', 'V', $text);
        $text = preg_replace('/Г/', 'G', $text);
        $text = preg_replace('/Д/', 'D', $text);
        $text = preg_replace('/Е/', 'E', $text);
        $text = preg_replace('/Ё/', 'YO', $text);
        $text = preg_replace('/Ж/', 'ZH', $text);
        $text = preg_replace('/З/', 'Z', $text);
        $text = preg_replace('/И/', 'I', $text);
        $text = preg_replace('/Й/', 'Y', $text);
        $text = preg_replace('/К/', 'K', $text);
        $text = preg_replace('/Л/', 'L', $text);
        $text = preg_replace('/М/', 'M', $text);
        $text = preg_replace('/Н/', 'N', $text);
        $text = preg_replace('/О/', 'O', $text);
        $text = preg_replace('/П/', 'P', $text);
        $text = preg_replace('/Р/', 'R', $text);
        $text = preg_replace('/С/', 'S', $text);
        $text = preg_replace('/Т/', 'T', $text);
        $text = preg_replace('/У/', 'U', $text);
        $text = preg_replace('/Ф/', 'F', $text);
        $text = preg_replace('/Х/', 'H', $text);
        $text = preg_replace('/Ц/', 'TS', $text);
        $text = preg_replace('/Ч/', 'CH', $text);
        $text = preg_replace('/Ш/', 'SH', $text);
        $text = preg_replace('/Щ/', 'SH', $text);
        $text = preg_replace('/Ъ/', '', $text);
        $text = preg_replace('/Ы/', 'Y', $text);
        $text = preg_replace('/Ь/', '', $text);
        $text = preg_replace('/Э/', 'E', $text);
        $text = preg_replace('/Ю/', 'YU', $text);
        $text = preg_replace('/Я/', 'YA', $text);
        $text = preg_replace('/а/', 'a', $text);
        $text = preg_replace('/б/', 'b', $text);
        $text = preg_replace('/в/', 'v', $text);
        $text = preg_replace('/г/', 'g', $text);
        $text = preg_replace('/д/', 'd', $text);
        $text = preg_replace('/е/', 'e', $text);
        $text = preg_replace('/ё/', 'yo', $text);
        $text = preg_replace('/ж/', 'zh', $text);
        $text = preg_replace('/з/', 'z', $text);
        $text = preg_replace('/и/', 'i', $text);
        $text = preg_replace('/й/', 'y', $text);
        $text = preg_replace('/к/', 'k', $text);
        $text = preg_replace('/л/', 'l', $text);
        $text = preg_replace('/м/', 'm', $text);
        $text = preg_replace('/н/', 'n', $text);
        $text = preg_replace('/о/', 'o', $text);
        $text = preg_replace('/п/', 'p', $text);
        $text = preg_replace('/р/', 'r', $text);
        $text = preg_replace('/с/', 's', $text);
        $text = preg_replace('/т/', 't', $text);
        $text = preg_replace('/у/', 'u', $text);
        $text = preg_replace('/ф/', 'f', $text);
        $text = preg_replace('/х/', 'h', $text);
        $text = preg_replace('/ц/', 'ts', $text);
        $text = preg_replace('/ч/', 'ch', $text);
        $text = preg_replace('/ш/', 'sh', $text);
        $text = preg_replace('/щ/', 'sh', $text);
        $text = preg_replace('/ъ/', '', $text);
        $text = preg_replace('/ы/', 'y', $text);
        $text = preg_replace('/ь/', '', $text);
        $text = preg_replace('/э/', 'e', $text);
        $text = preg_replace('/ю/', 'yu', $text);
        $text = preg_replace('/я/', 'ya', $text);

        $text = preg_replace('/\s+/', '-', $text);
        $text = preg_replace('/[^a-zA-Z0-9\-]/', '', $text);
        $text = preg_replace('/\-{2,}/', '-', $text);
        $text = preg_replace('/\-$/', '', $text);
        $text = preg_replace('/^\-/', '', $text);
        $text = strtolower($text);

        return $text;
    }

}
