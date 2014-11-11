<?php
$nextVideo = $this->Html->url('/',true);
$prevVideo = $this->Html->url('/',true);
if(isset($nextNprev['prev']['Node']['url']))
    $nextVideo =  $this->Html->url($nextNprev['prev']['Node']['url'],true);
if(isset($nextNprev['next']['Node']['url']))
    $prevVideo =  $this->Html->url($nextNprev['next']['Node']['url'],true);
?>
<div class="col-md-7 content">
    <?php $this->Nodes->set($node); ?>
    <script>
        var videoLink = 'http://www.youtube.com/embed/<?php echo $this->Nodes->field('CustomFields.youtube_clip'); ?>?autoplay=1&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs';
        var updateView = '<?php echo $this->Html->url(array('plugin'=>'nodes','controller'=>'nodes','action'=>'update_view'));?>';
        var pid = '<?php echo $this->Nodes->field('id');?>';
        var link = '<?php echo urlencode($this->Html->url($this->Nodes->field('url'),true));?>';
        var postNew = '<?php echo $this->Html->url(array('plugin'=>'nodes','controller'=>'nodes','action'=>'index'));?>';
    </script>
    <div id="node-<?php echo $this->Nodes->field('id'); ?>"
         class="node node-type-<?php echo $this->Nodes->field('type'); ?> node-block">
        <h2 class="view-title"><?php echo $this->Nodes->field('title'); ?></h2>
        <?php
        if ($this->Nodes->field('CustomFields.youtube_clip')) {
            ?>
            <div class="video-container" id="view-iframe">
                <div class="text-center count" id="top-center-a"><span>Clip tiếp theo sau <span id="timer-a">10</span>s nữa</span></div>
                <iframe class="ytplayer" id="player1" data-stateEvent="State1"
                        src="http://www.youtube.com/embed/<?php echo $this->Nodes->field('CustomFields.youtube_clip'); ?>?enablejsapi=1&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs"
                        frameborder="0"
                        width="560"
                        height="315" allowfullscreen></iframe>
                <div class="badge-item-vote-container post-afterbar-a in-list-view video-share text-center"
                     id="video-share-a">
                    <div class="share right">
                        <ul>
                            <li><a href="javascript:void(0);"
                                   class="badge-facebook-share badge-evt badge-track btn-share facebook"
                                   data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Facebook</a>
                            </li>

                            <li><a href="javascript:void(0);"
                                   class="badge-twitter-share badge-evt badge-track btn-share twitter"
                                   data-title="<?php echo $this->Nodes->field('title') ?>"
                                   data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Twitter</a>
                            </li>
                        </ul>
                    </div>
                    <a href="<?php echo $prevVideo;?>" class="btn btn-success"><i
                            class="fa fa-arrow-circle-o-left"></i> Clip trước</a>
                    <a href="<?php echo $nextVideo;?>" class="btn btn-success">Clip tiếp theo <i
                            class="fa fa-arrow-circle-o-right"></i></a>
                </div>

            </div>
            <a href="#" id="view-video" data-toggle="modal" data-target=".video-modal">
                <div class="play-btn" style="display: none;">
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

            ?>
            <a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'user_posted', 'user_id'=>$this->Nodes->field('User.id'))) ?>">
            <span class="author">
        <img class="avatar"
             src="<?php echo $this->Nodes->field('User.image') ? $this->Nodes->field('User.image') : '/img/noimage.gif'; ?>">
                <?php
                echo $this->Nodes->field('User.name');
                ?>
        </span>
            <?php
            if ($type['Type']['format_show_date']) {
                $dt1 = new DateTime();
                $dt2 = new DateTime($this->Nodes->field('created'));
                $total = $this->Custom->getDiffInHours($dt1, $dt2);
                if ($total > 48)
                    echo '<span class="date pull-right">' . $this->Time->format(Configure::read('Reading.date_time_format'), $this->Nodes->field('created'), null, Configure::read('Site.timezone')) . '</span>';
                else
                    echo '<span class="date pull-right">' . $total . ' giờ</span>';
            }
            ?>
                </a>
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
    <div class="row">
        <div class="col-md-12" id="new-posts">
            <div id="new-loading" class="loading" style="display: none;">
                <a class="btn spin" href="#">Loading</a>
            </div>
        </div>
    </div>
    <div class="modal fade video-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->Nodes->field('title'); ?></h4>
                </div>
                -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="video-container" id="video-container">
                                <div class="text-center count" id="top-center-b"><span>Clip tiếp theo sau <span id="timer-b">10</span>s nữa</span>
                                </div>
                                <iframe id="video-iframe" class="ytplayer" data-stateEvent="State2"
                                        src="http://www.youtube.com/embed/<?php echo $this->Nodes->field('CustomFields.youtube_clip'); ?>?enablejsapi=1&rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs"
                                        frameborder="0"
                                        width="560"
                                        height="315" allowfullscreen></iframe>
                                <div
                                    class="badge-item-vote-container post-afterbar-a in-list-view video-share text-center"
                                    id="video-share-b">
                                    <div class="share right">
                                        <ul>
                                            <li><a href="javascript:void(0);"
                                                   class="badge-facebook-share badge-evt badge-track btn-share facebook"
                                                   data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Facebook</a>
                                            </li>

                                            <li><a href="javascript:void(0);"
                                                   class="badge-twitter-share badge-evt badge-track btn-share twitter"
                                                   data-title="<?php echo $this->Nodes->field('title') ?>"
                                                   data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Twitter</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="<?php echo $prevVideo;?>" class="btn btn-success"><i
                                            class="fa fa-arrow-circle-o-left"></i> Clip trước</a>
                                    <a href="<?php echo $nextVideo;?>" class="btn btn-success" id="bt-next">Clip tiếp theo <i
                                            class="fa fa-arrow-circle-o-right"></i></a>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <div class="fb-like" data-href="<?php echo $this->Html->url($this->Nodes->field('url'),true)?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
                                    </div>
                                </div>
                            </div>
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