

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
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
                <li><a href="http://builtwithbootstrap.com/" target="_blank"><i class="fa fa-cloud-upload"></i> Đăng bài</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download"><i class="fa fa-user"></i> Tề thiên <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="download">
                        <li><a href="./bootstrap.min.css">bootstrap.min.css</a></li>
                        <li><a href="./bootstrap.css">bootstrap.css</a></li>
                        <li class="divider"></li>
                        <li><a href="./variables.less">variables.less</a></li>
                        <li><a href="./bootswatch.less">bootswatch.less</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</div>