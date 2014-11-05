<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title'); ?></title>
    <?php
    echo $this->Meta->meta();
    echo $this->Layout->feed();
    echo $this->Html->css(array(
        'bootstrap.min',
        'bootswatch.min',
        'font-awesome.min',
        'haytuyet',
    ));
    echo $this->Blocks->get('css');
    ?>
</head>
<body>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '462179947218302',
            xfbml: true,
            version: 'v2.2'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<?php echo $this->element('top_nav') ?>
<div class="container-fluid main">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo $this->Layout->sessionFlash();
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?php echo $this->Regions->blocks('left'); ?>
        </div>
        <?php
        echo $content_for_layout;
        ?>
        <div class="col-md-3">
            <?php echo $this->Regions->blocks('right'); ?>
        </div>
    </div>
</div>
<footer class="" role="contentinfo">

</footer>
<?php
if ($this->Session->read('Auth.User'))
    echo $this->element('user_post_form');
?>
<script type="text/javascript">
    var clipHot = '<?php echo $this->Html->url(array(
    'plugin'=>'nodes','controller'=>'nodes','action'=>'hot_clip'
))?>';
    var topView = '<?php echo $this->Html->url(array(
    'plugin'=>'users','controller'=>'users','action'=>'top_view'
))?>';
</script>
<?php
echo $this->Layout->js();
echo $this->Html->script(array(
    '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
    'bootstrap.min',
    'bootswatch',
    'haytuyet',
));
echo $this->fetch('script');
echo $this->Blocks->get('script');
echo $this->Blocks->get('scriptBottom');
echo $this->Js->writeBuffer();
?>
</body>
</html>