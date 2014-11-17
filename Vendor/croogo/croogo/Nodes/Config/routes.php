<?php

CroogoRouter::mapResources('Nodes.Nodes', array(
	'prefix' => '/:api/:prefix/',
));

Router::connect('/:api/:prefix/nodes/lookup', array(
	'plugin' => 'nodes',
	'controller' => 'nodes',
	'action' => 'lookup',
), array(
	'routeClass' => 'ApiRoute',
));

// Basic
CroogoRouter::connect('/', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'index'
));

CroogoRouter::connect('/promoted/*', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'promoted'
));

CroogoRouter::connect('/search/*', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'search'
));

// Content types
CroogoRouter::contentType('blog');
CroogoRouter::contentType('clip');
CroogoRouter::contentType('node');
if (Configure::read('Croogo.installed')) {
	CroogoRouter::routableContentTypes();
}

// Page
CroogoRouter::connect('/about', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'view',
	'type' => 'page', 'slug' => 'about'
));
CroogoRouter::connect('/page/:slug', array(
	'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'view',
	'type' => 'page'
));
CroogoRouter::connect('/user/:user_id',
    array('plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'user_posted'),
    array(
        'user_id',
        'pass' => array(
            'user_id'
        )
    )
);
CroogoRouter::connect('/sitemap.xml', array(
    'plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'sitemap'
    ));