<?php $this->Nodes->set($node); ?>
<div id="node-<?php echo $this->Nodes->field('id'); ?>"
     class="node node-type-<?php echo $this->Nodes->field('type'); ?>">
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
        <a href="javascript:;" id="view-video" data-toggle="modal" data-target=".video-modal">
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

        if ($type['Type']['format_show_author']) {
            if ($this->Nodes->field('User.website') != null) {
                $author = $this->Html->link(__d('croogo', 'bởi ') . $this->Nodes->field('User.name'), $this->Nodes->field('User.website'));
            } else {
                $author = __d('croogo', 'bởi ') . $this->Nodes->field('User.name');
            }
            echo $this->Html->tag('span', $author, array(
                'class' => 'author pull-left',
            ));
        }
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
<div class="badge-item-vote-container post-afterbar-a in-list-view  ">
    <div class="share right pull-right">
        <ul>
            <li><a href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook"
                   data-track="social,fb.s,,,d,aqZyXAY,l"
                   data-evt="Facebook-Share,ListClicked,http://9gag.com/gag/aqZyXAY"
                   data-share="http://9gag.com/gag/aqZyXAY?ref=fb.s">Facebook</a></li>

            <li><a href="javascript:void(0);" class="badge-twitter-share badge-evt badge-track btn-share twitter"
                   data-track="social,t.s,,,d,aqZyXAY,l"
                   data-evt="Twitter-Share,ListClicked,http://9gag.com/gag/aqZyXAY"
                   data-title="My%20professor%20dressed%20up%20as%20a%20minion%20today.%2050%20minutes%20in%20the%20costume.%20Last%20year%20he%20was%20Darth%20Vader"
                   data-share="http://9gag.com/gag/aqZyXAY?ref=t">Twitter</a>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
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

<div class="modal fade video-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-8">
                    <div class="video-container">
                        <iframe
                            src="http://www.youtube.com/embed/<?php echo $this->Nodes->field('CustomFields.youtube_clip'); ?>?rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs"
                            frameborder="0"
                            width="560"
                            height="315" allowfullscreen></iframe>

                    </div>
                </div>
                <div class="col-md-4">
                    <div id="target-comments">
                        <iframe
                            src="<?php echo $this->Html->url(array('plugin' => 'comments', 'controller' => 'comments', 'action' => 'iframe_comment')) ?>" frameborder="0" ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>