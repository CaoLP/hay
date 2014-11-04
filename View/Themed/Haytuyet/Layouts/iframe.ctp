<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title'); ?></title>
    <?php
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
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=664600673634236&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<?php
echo $content_for_layout;
?>

<?php
echo $this->Layout->js();
echo $this->Html->script(array(
    '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
    'bootstrap.min',
    'bootswatch',
));
echo $this->fetch('script');
echo $this->Blocks->get('script');
echo $this->Blocks->get('scriptBottom');
echo $this->Js->writeBuffer();
?>
</body>
</html>