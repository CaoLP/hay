<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
──────────────────────────────▓▓█───────
────────────────────────────▒██▒▒█──────
───────────────────────────█▓▓▓░▒▓▓─────
─────────────────────────▒█▓▒█░▒▒▒█─────
────────────────────────▒█▒▒▒█▒▒▒▒▓▒────
─▓▓▒░──────────────────▓█▒▒▒▓██▓▒░▒█────
─█▓▓██▓░──────────────▓█▒▒▒▒████▒▒▒█────
─▓█▓▒▒▓██▓░──────────▒█▒▒▒▒▒██▓█▓░░▓▒───
─▓▒▓▒▒▒▒▒▓█▓░──░▒▒▓▓██▒▒▒▒▒▒█████▒▒▒▓───
─▓░█▒▒▒▒▒▒▒▓▓█▓█▓▓▓▓▒▒▒▒▒▒▒▒██▓██▒░▒█───
─▓░▓█▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▓████▒▒▒█───
─▓░▓██▒▒▒▒▒▒▒▒▒▒▒▒▒▓▓▒▒▒▒▒▒▒▒▒▓██░░░█───
─▓░▓███▒▒▒▒▒▒▒▒▒▒▒▓█▒▒▒▒▒▒▒▒▒▒▒▒▓▓▓▒▓▓──
─▒▒▒██▓▒▓█▓▒▒▒▒▒▒▒▓▒▒▒▒▒▒▓▓▓▒▒▒▒▒▒▒▓▒█──
──▓▒█▓▒▒▒▒▓▒▒▒▒▒▒▒▒▒▒▒▓█▓▓▓▓█▓▒▒▒▒▒▒▒▓▒─
──▓▒█▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▓▓──────▓█▓▒▒▒▒▒▓█─
──▒▒▓▒▒▒▓▓▓▒▒▒▒▒▒▒▒▒▓▓───░▓▓───█▓▒▒▒▒▒█─
───█▒▒▓▓▓▒▒▓▓▒▒▒▒▒▒▓▓───█████▓──█▓▒▒▒▒▓▒
───▓▓█▒─────▒▓▒▒▒▒▒█───░██████──░█▒▒▒▒▓▓
───▓█▒──▒███─▒▓▒▒▒▒█────██████───▓▒▒▒▒▒▓
───██───█████─█▒▒▒▒█─────███▓────▓▓▒▒▒▒▓
───█▓───█████─▒▓▒▒▒█─────────────█▓▓▓▒▒▓
───█▓───░███──░▓▒▒▒▓█──────────░█▓▒▒▒▓▒▓
───██─────────▒▓▒▒▒▒▓▓──────░▒▓█▓────░▓▓
───▓█░────────█▓██▓▒▒▓█▓▓▓▓██▓▓▒▓▒░░▒▓▒▓
───▒██░──────▓▒███▓▒▒▒▒▓▓▓▓▒▒▒▒▒▒▓▓▓▓▒▓─
────█▓█▓▓▒▒▓█▓▒░██▒▒▓▓█▓▒▒▒▒▒▒▒▒▒▒▒▒▓▓█▒
────▓─░▓▓▓▓▓▒▓▓▓▓▒▓▓▓▒▓▒▒▒▒▒▒▒▒▒▒▒▓▓▓▓▓▓
────▒▒▒▓▒▒▒▒▒▒▓█░─░░░─▓▓▒▒▒▒▒▒▒▒▒▒▒▓██▓▒
─────█▓▒▒▒▒▒▒▒▒▓▓─░░░─▓▓▒▒▒▒▒▒▒▒▒▓▓▓▒▒▓▒
──────██▓▓▒▒▒▒▒▒█▒░░░░█▒▒▒▒▒▒▒▒▓█▓▓▒▒▒▒▒
─────░─▒██▓▓▒▒▒▒▒█▓▒▒▓▒▒▒▒▒▒▓███▓▒▒▒▒▒▓▓
──────────░▒▓▓▓▓▒▒▓▓▓▓▓▓████▓▓█▒▒▒▒▒▓▓█░

-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title'); ?></title>
    <?php
    echo $this->Meta->meta();
    echo $this->element('meta');
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

<script type='text/javascript'>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    (function() {
        var gads = document.createElement('script');
        gads.async = true;
        gads.type = 'text/javascript';
        var useSSL = 'https:' == document.location.protocol;
        gads.src = (useSSL ? 'https:' : 'http:') +
            '//www.googletagservices.com/tag/js/gpt.js';
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(gads, node);
    })();
</script>
<script type='text/javascript'>
    googletag.cmd.push(function() {
        googletag.defineSlot('/12519726/haytuyet336x280', [336, 280], 'div-gpt-ad-1415677118184-0').addService(googletag.pubads());
        googletag.defineSlot('/12519726/haytuyet728x90', [728, 90], 'div-gpt-ad-1415677194948-0').addService(googletag.pubads());
        googletag.defineSlot('/12519726/haytuyet300x600', [300, 600], 'div-gpt-ad-1415677276331-0').addService(googletag.pubads());
        googletag.defineSlot('/12519726/728x90pu1', [728, 90], 'div-gpt-ad-1415677308412-0').addService(googletag.pubads());
        googletag.defineSlot('/12519726/728x90pu2', [728, 90], 'div-gpt-ad-1415677337497-0').addService(googletag.pubads());
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
    });
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
    <?php echo $this->element('footer')?>
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
    var countMSG = '<?php echo $this->Html->url(array(
        'plugin'=>'users',
        'controller'=>'user_messages',
        'action'=>'count_message',
        $this->Session->read('Auth.User.id')
    ))?>';
</script>
<?php
echo $this->Layout->js();
echo $this->Html->script(array(
    '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
    'bootstrap.min',
    'bootswatch',
    '//www.youtube.com/iframe_api',
    'haytuyet',
));
if ($this->Session->read('Auth.User')){
    echo $this->Html->script(array('message'));
}
echo $this->fetch('script');
echo $this->Blocks->get('script');
echo $this->Blocks->get('scriptBottom');
echo $this->Js->writeBuffer();
?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-42201883-7', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>