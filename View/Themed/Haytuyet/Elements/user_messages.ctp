<li><a href="javascript:;" id="msg" data-poload="<?php echo $this->Html->url(array(
        'plugin'=>'users',
        'controller'=>'user_messages',
        'action'=>'message',
        $this->Session->read('Auth.User.id')
    ))?>"><i class="fa fa-globe"></i> (<span id="count-MSG">0</span> tin nhắn)</a></li>
