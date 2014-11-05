<div class="col-md-7 content">


<?php $this->Nodes->set($node); ?>
<script>
    var videoLink = 'http://www.youtube.com/embed/<?php echo $this->Nodes->field('CustomFields.youtube_clip'); ?>?autoplay=1&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs';
    var updateView = '<?php echo $this->Html->url(array('plugin'=>'nodes','controller'=>'nodes','action'=>'update_view'));?>';
    var pid = '<?php echo $this->Nodes->field('id');?>';
    var link = '<?php echo urlencode($this->Html->url($this->Nodes->field('url'),true));?>';
</script>
<div id="node-<?php echo $this->Nodes->field('id'); ?>"
     class="node node-type-<?php echo $this->Nodes->field('type'); ?> node-block">
    <h2 class="view-title"><?php echo $this->Nodes->field('title'); ?></h2>
    <?php
    if ($this->Nodes->field('CustomFields.youtube_clip')) {
        ?>
        <div class="video-container" id="view-iframe">
            <iframe
                src="http://www.youtube.com/embed/<?php echo $this->Nodes->field('CustomFields.youtube_clip'); ?>?rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs"
                frameborder="0"
                width="560"
                height="315" allowfullscreen></iframe>

        </div>
        <a href="#" id="view-video" data-toggle="modal" data-target=".video-modal">
            <div class="play-btn">
            </div>
            <img class="img-responsive video-img"
                 src="<?php echo $this->Nodes->field('CustomFields.image'); ?>"></a>

    <?php
    } else if ($this->Nodes->field('CustomFields.image')) {
        ?>
        <img class="img-responsive"
             src="<?php echo $this->Nodes->field('CustomFields.image'); ?>">
    <?php
    }
    ?>
</div>
<div class="row">
    <div class="view-info col-md-12">
        <?php
        $type = $types_for_layout[$this->Nodes->field('type')];

        if ($this->Nodes->field('User.website') != null) {
            echo '<a href="' . $this->Nodes->field('User.website') . '">';
        }
        ?>
        <span class="author">
        <img class="avatar"
             src="<?php echo $this->Nodes->field('User.image') ? $this->Nodes->field('User.name') : '/img/noimage.gif'; ?>">
            <?php
            echo $this->Nodes->field('User.name');
            ?>
        </span>
        <?php
        if ($type['Type']['format_show_date']) {
            echo $this->Html->tag('span', $this->Time->format(Configure::read('Reading.date_time_format'), $this->Nodes->field('created'), null, Configure::read('Site.timezone')), array('class' => 'date pull-right'));
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="node-view col-md-12" id="count-view">
        <span><i class="fa fa-eye"></i> <?php echo $this->Nodes->field('counts'); ?> </span><span><i
                class="fa fa-thumbs-up"></i> <?php echo $this->Nodes->field('likes'); ?> </span><span><i
                class="fa fa-comment"></i> <?php echo $this->Nodes->field('comments'); ?></span>
    </div>
</div>
<p class="post-meta">
<div class="fb-like" data-href="<?php echo $this->Html->url($this->Nodes->field('url'), true) ?>"
     data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
</p>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Regions->blocks('region1'); ?>
    </div>
</div>
<?php if (CakePlugin::loaded('Comments')): ?>
    <div class="row">
        <div id="comments" class="node-comments col-md-12">
            <?php
            $type = $types_for_layout[$this->Nodes->field('type')];

            if ($type['Type']['comment_status'] > 0) {
                echo $this->element('Comments.comments', array('model' => 'Node', 'data' => $node));
            }
            //	if ($type['Type']['comment_status'] > 0 && $this->Nodes->field('comment_status') > 0) {
            //		echo $this->element('Comments.comments', array('model' => 'Node', 'data' => $node));
            //	}
            //
            //	if ($type['Type']['comment_status'] == 2 && $this->Nodes->field('comment_status') == 2) {
            //		echo $this->element('Comments.comments_form', array('model' => 'Node', 'data' => $node));
            //	}
            ?>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade video-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->Nodes->field('title'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="video-container">
                            <iframe id="video-iframe"
                                src=""
                                frameborder="0"
                                width="560"
                                height="315" allowfullscreen></iframe>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="target-comments">
                            <!--                        <iframe-->
                            <!--                            src="-->
                            <?php //echo $this->Html->url(array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'iframe_comment')) ?><!--" frameborder="0" ></iframe>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>