<?php

CroogoNav::add('sidebar', 'content', array(
	'icon' => 'edit',
	'title' => __d('croogo', 'Content'),
	'url' => array(
		'admin' => true,
		'plugin' => 'nodes',
		'controller' => 'nodes',
		'action' => 'index',
	),
	'weight' => 10,
	'children' => array(
		'list' => array(
			'title' => __d('croogo', 'List'),
			'url' => array(
				'admin' => true,
				'plugin' => 'nodes',
				'controller' => 'nodes',
				'action' => 'index',
			),
			'weight' => 10,
		),
        'user_post' => array(
            'title' => __d('croogo', 'Posts of Users'),
            'url' => array(
                'admin' => true,
                'plugin' => 'nodes',
                'controller' => 'nodes',
                'action' => 'users_posts',
                '?' => array(
                    'status'=>2
                ),
            ),
            'weight' => 10,
        ),
		'create' => array(
			'title' => __d('croogo', 'Create'),
			'url' => array(
				'admin' => true,
				'plugin' => 'nodes',
				'controller' => 'nodes',
				'action' => 'create',
			),
			'weight' => 20,
		),
	)
));
