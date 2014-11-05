<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="../" class="navbar-brand"><?php echo Configure::read('Site.name'); ?></a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <?php echo $this->Custom->menu('main', array('dropdown' => true)); ?>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($this->Session->read('Auth.User')) {
                    ?>
                    <li><a href="#user-post-form" data-toggle="modal" data-target="#user-post-form"><i
                                class="fa fa-cloud-upload"></i> Đăng bài</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">
                            <img src="<?php
                            $img = $this->Session->read('Auth.User.image');
                            echo !empty($img) ? $img : '/img/noimage.gif'?>"
                                  class="avatar" style="width: 15px;height: 15px"> <?php echo $this->Session->read('Auth.User.name') ?>
                            <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="download">
                            <li>
                                <a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $this->Session->read('Auth.User.id'))) ?>">Thông
                                    tin</a></li>
                            <li>
                                <a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')) ?>">Đăng
                                    xuất</a></li>
                        </ul>
                    </li>
                <?php
                } else {
                    ?>
                    <li>
                        <a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login')) ?>"><i
                                class="fa fa-cloud-upload"></i> Đăng bài</a></li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'login')) ?>"><i
                                class="fa fa-clock-o"></i> Đăng nhập</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>