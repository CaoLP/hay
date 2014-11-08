<script>
    var userInfo = '<?php echo $this->Html->url(array('plugin'=>'users','controller'=>'users','action'=>'view',$user_id));?>';
</script>
<div class="col-md-7">
    <div class="row">
        <?php echo $this->element('note'); ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="nodes promoted">
                <?php
                if (count($nodes) == 0) {
                    echo __d('croogo', 'No items found.');
                }
                ?>

                <?php
                $arr = Set::combine($nodes, '{n}.Node.id', '{n}.Node.id');

                $next = array_keys($arr);
                unset($next[0]);
                $next[] = '0';
                $next[] = '0';
                $next = array_values($next);
                $prev = array_keys($arr);
                array_unshift($prev, '0');
                $temp = array();
                for ($i = 0; $i < count($arr); $i++) {
                    $temp[array_keys($arr)[$i]] = array(
                        'next' => $next[$i],
                        'prev' => $prev[$i],
                    );
                }
                $count = 0;
                foreach ($nodes as $key => $node):
                    $this->Nodes->set($node);
                    ?>
                    <div class="node node-block node-type-<?php echo $this->Nodes->field('type'); ?>">
                        <?php
                        echo $this->Nodes->info();
                        ?>
                        <?php
                        echo $this->Nodes->body();
                        ?>
                        <div class="title">
                            <h2><a href="<?php echo $this->Html->url($this->Nodes->field('url')); ?>"
                                   target="_blank"><?php echo $this->Nodes->field('title') ?></a></h2>
                        </div>
                        <?php
                        echo $this->Nodes->moreInfo(array('keys' => $temp));
                        ?>
                    </div>
                    <?php
                    if ($count == 0) {
                        ?>
                        <div class="like-box">
                            <h3 class="like-box-title"><img src="/img/like-icon.png" alt="Like"> Like <a
                                    href="http://www.facebook.com/haytuyetcom"
                                    target="_blank"><?php echo Configure::read('Site.title') ?> trên Facebook</a> để
                                được cười nhiều hơn</h3>
                            <div class="like-haytyet">
                                <div class="fb-like" data-href="http://www.facebook.com/haytuyetcom" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
                            </div>
                        </div>
                    <?php
                    }
                    $count++;
                endforeach;
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo $this->Paginator->prev(__('&laquo; Trang trước'), array('tag' => false, 'class' => 'btn btn-success pull-left', 'escape' => false), null, array('tag' => false, 'class' => 'btn btn-success pull-left disabled', 'disabledTag' => 'a', 'escape' => false));
                        echo $this->Paginator->next(__('&raquo; Trang tiếp theo'), array('tag' => false, 'class' => 'btn btn-success pull-right', 'escape' => false), null, array('tag' => false, 'class' => 'btn btn-success pull-right disabled', 'disabledTag' => 'a', 'escape' => false));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>