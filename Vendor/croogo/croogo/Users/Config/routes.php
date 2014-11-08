<?php

CroogoRouter::mapResources('Users.Users', array(
	'prefix' => '/:api/:prefix/',
));

Router::connect('/:api/:prefix/users/lookup', array(
	'plugin' => 'users',
	'controller' => 'users',
	'action' => 'lookup',
), array(
	'routeClass' => 'ApiRoute',
));

// Users
CroogoRouter::connect('/register', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));


// Users
CroogoRouter::connect('/login', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'));



