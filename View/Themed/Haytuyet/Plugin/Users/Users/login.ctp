<div class="row signup-wrapper">
    <div class="col-md-12 text-center header">
        <a href="<?php echo $this->Html->url('/') ?>">
            <img src="http://placehold.it/284x90">
        </a>
    </div>
</div>
<div class="row signup-wrapper">
    <div class="col-md-12 content text-center">
        <h3>Đăng nhập</h3>

        <p>
            Click vào nút dưới đây để đăng nhập với tài khoản Facebook của bạn. Tài khoản của bạn trên sẽ tự động được
            tạo sau lần đăng nhập đầu tiên mà không cần đăng ký.
        </p>
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
        </fb:login-button>
    </div>
    <?php
        echo $this->Form->create('User',array('type'=>'post','url' => array('plugin'=>'users','controller' => 'users', 'action' => 'facebook_login')));
        echo $this->Form->input('data',array('style'=>'display:none','div'=>false,'label'=>false));
        echo $this->Form->end();
    ?>
</div>