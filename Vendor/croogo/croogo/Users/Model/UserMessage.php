<?php

App::uses('UsersAppModel', 'Users.Model');

/**
 * Role
 *
 * @category Model
 * @package  Croogo.Users.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class UserMessage extends UsersAppModel {

/**
 * Model name
 *
 * @var string
 * @access public
 */
	public $name = 'UserMessage';

/**
 * Validation
 *
 * @var array
 * @access public
 */
	public $validate = array(
		'message' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'message cannot be empty.',
				'last' => true,
			),
		),
	);

    public $belongsTo = array(
        'User' => array(
            'className' => 'Users.User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Receive' => array(
            'className' => 'Users.User',
            'foreignKey' => 'receive_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
    );
}
