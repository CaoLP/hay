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
    <?php
    if($this->Session->read('Auth.User.role_id')==1){
        $this->Html->script(array('post'),array('inline'=>false));
        echo $this->Html->css(array('bootstrap-tagsinput'),array('inline'=>false));
        echo $this->Html->script(array('typeahead.bundle','bootstrap-tagsinput','tags'),array('inline'=>false));
        ?>
        <script>
            var youtube_id = '<?php echo $this->Nodes->field('CustomFields.youtube_clip');?>';
            var updateImg = '<?php
            echo $this->Html->url(array(
                            'admin'=>true,
                            'plugin'=>'nodes',
                            'controller'=>'nodes',
                            'action'=>'approve_post',
                            $this->Nodes->field('id'),
                        ));
            ?>'
        </script>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <a href="<?php
                    echo $this->Html->url(array(
                            'admin'=>true,
                            'plugin'=>'nodes',
                            'controller'=>'nodes',
                            'action'=>'users_posts',
                            '?'=>array('status'=>2))
                    );
                    ?>" class="btn btn-danger">Quay lại Admin</a>
                    <?php
                    if($this->Nodes->field('status')==2){
                        ?>
                        <a href="<?php
                        echo $this->Html->url(array(
                            'admin'=>true,
                            'plugin'=>'nodes',
                            'controller'=>'nodes',
                            'action'=>'approve_post',
                            $this->Nodes->field('id'),
                            '?'=>array('url'=>$this->Html->url($this->Nodes->field('url')))
                        ))
                        ?>" class="btn btn-success">Duyệt bài</a>
                    <?php
                    }else{
                        ?>
                        <a href="javascript:;" class="btn btn-warning">Đã duyệt</a>
                    <?php
                    }
                    ?>
                    <?php
                    if($this->Nodes->field('status')==1){
                        if($this->Nodes->field('comments_fbid')){
                            ?>
                            <a href="https://developers.facebook.com/tools/explorer/145634995501895/?method=POST&path=<?php echo $this->Nodes->field('comments_fbid'); ?>" class="btn btn-info" target="_blank">Ghi nhớ lên FACEBOOK</a>
                        <?php
                        }
                    }
                    echo ' ' . $this->Croogo->adminRowAction('Xoá bài',
                            '/admin/nodes/nodes/userpost_delete/'.$node['Node']['id'].'?'.'receive_id='. $node['Node']['user_id'].'&'.'title='.$node['Node']['title'],
                            array(
                                'class' => 'delete btn btn-danger',
                                'tooltip' => __d('croogo', 'Remove this item'),
                            ),
                            __d('croogo', 'Are you sure?')
                        );
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <strong>Ảnh hiện tại</strong>
                <hr>
                <div id="cur_img" class="text-center">
                    <img height="90" src="<?php echo $this->Nodes->field('CustomFields.image');?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <strong>Ảnh thư viện</strong>
                <hr>
                <div id="youtube_img"></div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <strong>Tags</strong>
                <hr>
<!--                http://timschlechter.github.io/bootstrap-tagsinput/examples/-->
                <div class="input-group input-group-sm">
                    <select class="form-control" multiple="multiple" type="text" id="tag-input"></select>
                    <div class="input-group-btn">
                        <a href="javascript:;" class="btn btn-success" id="tag-save">Lưu</a>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    <?php
    }
    ?>
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
                <div>
                    <iframe id="tempFrame" style="
                border:none;
                background: url('<?php echo $this->Nodes->field('CustomFields.image');?>') no-repeat;
                background-size: 100%;
                background-position-y: 50%;" src="/webroot/testpage.php"></iframe>
                </div>
                <div class="badge-item-vote-container post-afterbar-a in-list-view video-share text-center"
                     id="video-share-a">
                    <div class="share right">
                        <a href="javascript:void(0);"
                           class="badge-facebook-share badge-evt badge-track btn-share facebook"
                           data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Facebook</a>
                        <a href="javascript:void(0);"
                           class="badge-twitter-share badge-evt badge-track btn-share twitter"
                           data-title="<?php echo $this->Nodes->field('title') ?>"
                           data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Twitter</a>
                        <ul>
                            <li>
                            </li>

                            <li>
                            </li>
                        </ul>
                    </div>
                    <a href="<?php echo $prevVideo;?>" class="btn btn-success btn-sm"><i
                            class="fa fa-arrow-circle-o-left"></i> Clip trước</a>

                    <a href="javascript:;" id="close-share-a" class="btn btn-success btn-sm"><i
                            class="fa fa-close"></i> Đóng</a>

                    <a href="<?php echo $nextVideo;?>" class="btn btn-success btn-sm">Clip tiếp theo <i
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
    <div class="row" id="support-link">
        <div class="col-md-12">
            <a href="<?php echo $prevVideo;?>" class="btn btn-success pull-left btn-sm"><i
                    class="fa fa-arrow-circle-o-left"></i> Clip trước</a>
            <a href="<?php echo $nextVideo;?>" class="btn btn-success pull-right btn-sm">Clip tiếp theo <i
                    class="fa fa-arrow-circle-o-right"></i></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Regions->blocks('region1'); ?>
        </div>
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
        <div class="col-md-12">
            <h4>Có thể bạn chưa xem</h4>
        </div>
        <div class="col-md-12" id="random-posts">
            <div id="random-loading" class="loading" style="display: none;">
                <a class="btn spin" href="#">Loading</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Clip mới nhất</h4>
        </div>
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
                                        <a href="javascript:void(0);"
                                           class="badge-facebook-share badge-evt badge-track btn-share facebook"
                                           data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Facebook</a>
                                        <a href="javascript:void(0);"
                                           class="badge-twitter-share badge-evt badge-track btn-share twitter"
                                           data-title="<?php echo $this->Nodes->field('title') ?>"
                                           data-share="<?php echo $this->Html->url($this->Nodes->field('url'), true); ?>">Twitter</a>
                                        <ul>
                                            <li>
                                            </li>

                                            <li>
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