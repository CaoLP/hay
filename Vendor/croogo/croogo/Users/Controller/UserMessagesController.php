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

    public function index(){

    }
    public function message($user_id = null){
        $this->layout= 'ajax';
        $messages = $this->UserMessage->find('all',array(
            'conditions'=>array(
                'UserMessage.receive_id' => $user_id,
                'UserMessage.status' => 0,
            ),
            'order'=>array('UserMessage.at'=>'DESC'),
            'limit'=>10
        ));
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
