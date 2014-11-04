<div class="node-view" id="count-view">
    <span><i class="fa fa-eye"></i> <?php echo $this->Nodes->field('counts');?> </span><span><i class="fa fa-thumbs-up"></i> <?php echo $this->Nodes->field('likes');?> </span><span><i class="fa fa-comment"></i> <?php echo $this->Nodes->field('comments');?></span>
</div>
<p class="post-meta">
<div class="fb-like" data-href="<?php echo $this->Html->url($this->Nodes->field('url'),true)?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
</p>
<div id="node-<?php echo $keys[$this->Nodes->field('id')]['next'];?>"></div>
<div class="badge-item-vote-container post-afterbar-a in-list-view  ">
    <div class="vote">
        <ul class="btn-vote left pull-left">
            <li><a class="badge-item-vote-up up " href="#node-<?php echo $keys[$this->Nodes->field('id')]['prev'];?>" title="Lên trên"></a></li>
            <li><a class="badge-item-vote-down down " href="#node-<?php echo $keys[$this->Nodes->field('id')]['next'];?>" title="Xuống dưới"></a></li>
            <li><a class="comment badge-evt badge-item-comment" target="_blank" href="<?php echo $this->Html->url($this->Nodes->field('url')); ?>#comments" data-evt="EntryAction,CommentButtonClicked,ListPage">Comment</a></li>
        </ul>
    </div>
    <div class="share right pull-right">
        <ul>
            <li><a href="javascript:void(0);" class="badge-facebook-share badge-evt badge-track btn-share facebook" data-track="social,fb.s,,,d,aqZyXAY,l" data-evt="Facebook-Share,ListClicked,http://9gag.com/gag/aqZyXAY" data-share="http://9gag.com/gag/aqZyXAY?ref=fb.s">Facebook</a></li>

            <li><a href="javascript:void(0);" class="badge-twitter-share badge-evt badge-track btn-share twitter" data-track="social,t.s,,,d,aqZyXAY,l" data-evt="Twitter-Share,ListClicked,http://9gag.com/gag/aqZyXAY" data-title="My%20professor%20dressed%20up%20as%20a%20minion%20today.%2050%20minutes%20in%20the%20costume.%20Last%20year%20he%20was%20Darth%20Vader" data-share="http://9gag.com/gag/aqZyXAY?ref=t">Twitter</a>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>
