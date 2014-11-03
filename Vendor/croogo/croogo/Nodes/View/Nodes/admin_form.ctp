<?php

$this->extend('/Common/admin_edit');

$this->Croogo->adminScript('Nodes.admin');

$this->Html
    ->addCrumb('', '/admin', array('icon' => $_icons['home']))
    ->addCrumb(__d('croogo', 'Content'), array('controller' => 'nodes', 'action' => 'index'));

if ($this->request->params['action'] == 'admin_add') {
    $formUrl = array('action' => 'add', $typeAlias);
    $this->Html
        ->addCrumb(__d('croogo', 'Create'), array('controller' => 'nodes', 'action' => 'create'))
        ->addCrumb($type['Type']['title'], '/' . $this->request->url);
}

if ($this->request->params['action'] == 'admin_edit') {
    $formUrl = array('action' => 'edit');
    $this->Html->addCrumb($this->request->data['Node']['title'], '/' . $this->request->url);
}

$lookupUrl = $this->Html->apiUrl(array(
    'plugin' => 'users',
    'controller' => 'users',
    'action' => 'lookup',
));

$parentTitle = isset($parentTitle) ? $parentTitle : null;
$apiUrl = $this->Form->apiUrl(array(
    'controller' => 'nodes',
    'action' => 'lookup',
    '?' => array(
        'type' => $type['Type']['alias'],
    ),
));

$this->append('form-start', $this->Form->create('Node', array(
    'url' => $formUrl,
    'class' => 'protected-form',
)));
$inputDefaults = $this->Form->inputDefaults();
$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
echo $this->Croogo->adminTab(__d('croogo', $type['Type']['title']), '#node-main');
echo $this->Croogo->adminTab(__d('croogo', 'Access'), '#node-access');
echo $this->Croogo->adminTabs();
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('node-main') .
    $this->Form->autocomplete('parent_id', array(
        'label' => __d('croogo', 'Parent'),
        'type' => 'text',
        'autocomplete' => array(
            'default' => $parentTitle,
            'data-displayField' => 'title',
            'data-primaryKey' => 'id',
            'data-queryField' => 'title',
            'data-relatedElement' => '#NodeParentId',
            'data-url' => $apiUrl,
        ),
    )) .
    $this->Form->input('id') .
    $this->Form->input('title', array(
        'label' => __d('croogo', 'Title'),
    )) .
    $this->Form->input('slug', array(
        'class' => trim($inputClass . ' slug'),
        'label' => __d('croogo', 'Slug'),
    )) .
    $this->Form->input('excerpt', array(
        'label' => __d('croogo', 'Excerpt'),
    )) .
    $this->Form->input('body', array(
        'label' => __d('croogo', 'Body'),
        'class' => $inputClass . (!$type['Type']['format_use_wysiwyg'] ? ' no-wysiwyg' : ''),
    ));

echo '<hr>';
echo '<h3>Seo</h3>';
echo '<hr>';
$keyTemp = array();
$keys = array('meta_keywords', 'meta_description', 'meta_robots', 'youtube_clip', 'image');
$seo = array('meta_keywords', 'meta_description', 'meta_robots');
$social = array('youtube_clip', 'image');
if (!empty($this->request->data['Meta'])) {
    $fields = Hash::combine($this->request->data['Meta'], '{n}.key', '{n}.value');
    $fieldsKeyToId = Hash::combine($this->request->data['Meta'], '{n}.key', '{n}.id');
} else {
    $fields = $fieldsKeyToId = array();
}
if (count($fields) > 0) {
    foreach ($fields as $fieldKey => $fieldValue) {
        if (in_array($fieldKey, $seo)) {
            echo $this->Meta->field2($fieldKey, $fieldValue, $fieldsKeyToId[$fieldKey]);
            $keyTemp[] = $fieldKey;
        }
    }
}

foreach ($seo as $idk => $key) {
    if (!in_array($key, array_values($keyTemp))) {
        echo $this->Meta->field2($key, '');
    }
}
echo '<hr>';
echo '<h3>Media</h3>';
echo '<hr>';
if (count($fields) > 0) {
    foreach ($fields as $fieldKey => $fieldValue) {
        if (in_array($fieldKey, $social)) {
            echo $this->Meta->field2($fieldKey, $fieldValue, $fieldsKeyToId[$fieldKey]);
            $keyTemp[] = $fieldKey;
        }
    }
}
foreach ($social as $idk => $key) {
    if (!in_array($key, array_values($keyTemp))) {
        echo $this->Meta->field2($key, '');
    }
}

echo $this->Html->tabEnd();

echo $this->Html->tabStart('node-access') .
    $this->Form->input('Role.Role', array(
        'label' => __d('croogo', 'Role')
    )) .
    $this->Html->tabEnd();

echo $this->Croogo->adminTabs();

$this->end();

$username = isset($this->request->data['User']['username']) ?
    $this->request->data['User']['username'] :
    $this->Session->read('Auth.User.username');

$this->start('panels');
echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
    $this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
    $this->Form->button(__d('croogo', 'Save'), array('button' => 'success')) .
    $this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'cancel btn btn-danger')) .
    $this->Form->input('status', array(
        'legend' => false,
        'type' => 'radio',
        'default' => CroogoStatus::UNPUBLISHED,
        'options' => $this->Croogo->statuses(),
    )) .
    $this->Form->input('promote', array(
        'label' => __d('croogo', 'Promoted to front page'),
    )) .
    $this->Form->autocomplete('user_id', array(
        'type' => 'text',
        'label' => __d('croogo', 'Publish as '),
        'autocomplete' => array(
            'default' => $username,
            'data-displayField' => 'username',
            'data-primaryKey' => 'id',
            'data-queryField' => 'name',
            'data-relatedElement' => '#NodeUserId',
            'data-url' => $lookupUrl,
        ),
    )) .

    $this->Form->input('created', array(
        'type' => 'text',
        'class' => trim($inputClass . ' input-datetime'),
        'label' => __d('croogo', 'Created'),
    )) .

    $this->Html->div('input-daterange',
        $this->Form->input('publish_start', array(
            'label' => __d('croogo', 'Publish Start'),
            'type' => 'text',
        )) .
        $this->Form->input('publish_end', array(
            'label' => __d('croogo', 'Publish End'),
            'type' => 'text',
        ))
    );

echo $this->Html->endBox();

echo $this->Croogo->adminBoxes();
?>
<?php
if (isset($this->data['CustomFields']['image'])) {
    echo $this->Html->beginBox(__d('croogo', 'Image Preview'));
    ?>
    <img src="<?php echo $this->data['CustomFields']['image']; ?>"/>
    <?php
    echo $this->Html->endBox();
}
?>
<?php
echo $this->Html->beginBox(__d('croogo', 'Youtube Image preview'));
?>
    <div id="youtube_img">

    </div>
<?php echo $this->Html->endBox(); ?>

<?php
$this->end();

$this->append('form-end', $this->Form->end());
