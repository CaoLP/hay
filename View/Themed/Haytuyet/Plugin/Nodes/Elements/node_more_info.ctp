<div class="node-view" id="count-view">
    <span><i class="fa fa-eye"></i> <?php echo $this->Nodes->field('counts');?> </span><span><i class="fa fa-thumbs-up"></i> <?php echo $this->Nodes->field('likes');?> </span><span><i class="fa fa-comment"></i> <?php echo $this->Nodes->field('comments');?></span>
</div>
<p class="post-meta">

</p>
<div id="node-<?php echo $keys[$this->Nodes->field('id')]['next'];?>"></div>
<div class="badge-item-vote-container post-afterbar-a in-list-view  ">
    <div class="vote">
        <div class="pull-left">
            <div class="fb-like" data-href="facebook.com/haytuyetcom" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
        </div>
        <ul class="btn-vote text-center pull-right">
            <li><a class="badge-item-vote-up up " href="#node-<?php echo $keys[$this->Nodes->field('id')]['prev'];?>" title="Lên trên"><i class="fa fa-arrow-up"></i></a></li>
            <li><a class="badge-item-vote-down down " href="#node-<?php echo $keys[$this->Nodes->field('id')]['next'];?>" title="Xuống dưới"><i class="fa fa-arrow-down"></i></a></li>
            <li><a class="comment badge-evt badge-item-comment" target="_blank" href="<?php echo $this->Html->url($this->Nodes->field('url')); ?>#comments"><i class="fa fa-comment"></i></a></li>
        </ul>
    </div>
    <!--
    <div class="share right pull-right">
        <ul>
            <li><a href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook" data-share="<?php echo $this->Html->url($this->Nodes->field('url'),true); ?>">Facebook</a></li>

            <li><a href="javascript:void(0);" class="badge-twitter-share badge-evt badge-track btn-share twitter" data-title="<?php echo $this->Nodes->field('title')?>" data-share="<?php echo $this->Html->url($this->Nodes->field('url'),true); ?>">Twitter</a>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    -->
</div>
