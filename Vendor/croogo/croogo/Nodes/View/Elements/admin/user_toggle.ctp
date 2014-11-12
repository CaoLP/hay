<?php
$url = array(
	'admin' => isset($admin) ? $admin : true,
	'plugin' => isset($plugin) ? $plugin : $this->request->params['plugin'],
	'controller' => isset($controller) ? $controller : $this->request->params['controller'],
	'action' => isset($action) ? $action : 'toggle',
	$id,
	$status,
	'?'=>array(
        'receive_id'=>$receive_id,
        'title'=>$title,
    )
);
echo $this->Html->status($status, $url);
