<?php

App::uses('NodesAppModel', 'Nodes.Model');

/**
 * Node
 *
 * @category Nodes.Model
 * @package  Croogo.Nodes.Model
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class Count extends NodesAppModel {

/**
 * Model name
 *
 * @var string
 * @access public
 */
	public $name = 'Count';

/**
 * Model associations: belongsTo
 *
 * @var array
 * @access public
 */
	public $belongsTo = array(
		'Node' => array(
			'className' => 'Nodes.Node',
			'foreignKey' => 'node_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
	);
}
