<?php
App::uses('UsersAppController', 'Users.Controller');

/**
 * Users Controller
 *
 * @category Controller
 * @package  Croogo.Users.Controller
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class UserMessagesController extends UsersAppController {

    public $name = 'UserMessages';

	public $presetVars = true;

	public $uses = array('Users.UserMessage');

    public function index($user_id = null){
        $this->paginate['UserMessage']['conditions'] = array(
            'UserMessage.receive_id' => $user_id,
        );
        $this->paginate['UserMessage']['order'] = 'UserMessage.at DESC';
        $this->paginate['UserMessage']['limit'] = 20;

        $this->set('messages', $this->paginate('UserMessage'));
    }
    public function message($user_id = null){
        $this->layout= 'ajax';
        $messages = $this->UserMessage->find('all',array(
            'conditions'=>array(
                'UserMessage.receive_id' => $user_id,
            ),
            'order'=>array('UserMessage.at'=>'DESC'),
            'limit'=>10
        ));
        $key = Set::combine($messages,'{n}.UserMessage.id','{n}');
        $key = array_keys($key);
        $this->UserMessage->updateAll(
            array('UserMessage.status'=> 1),
            array('UserMessage.id'=> $key)
        );
       $this->set(compact('messages'));
    }
    public function count_message($user_id = null){
        $this->layout= 'ajax';
        $messages = $this->UserMessage->find('count',array(
            'conditions'=>array(
                'UserMessage.receive_id' => $user_id,
                'UserMessage.status' => 0,
            ),
            'order'=>array('UserMessage.at'=>'DESC'),
        ));
        $this->set(compact('messages'));
    }
}
