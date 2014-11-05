<div class="row">
    <div class="col-md-12">
        <h3 class="topUsers">Top like tháng <?php echo date('m')?></h3>

        <div id="topUserContent">
            <ul class="topUsers-list">
                <?php
                foreach ($top_likes as $user) {
                    ?>
                    <li class="item">
                        <a href="<?php echo $this->Html->url(array('plugin'=>'users','controller'=>'users','action'=>'view','username'=>$user['User']['username']));?>" title="<?php echo $user['User']['name'];?>">
                            <div class="row">
                                <img src="<?php echo !empty($user['User']['image'])?$user['User']['image']:'/img/noimage.gif';?>">
                            </div>
                            <div class="row">
                                <div class="info">
                                    <span class="name"><?php echo $user['User']['name'];?></span> <span><i class="fa fa-thumbs-up"></i> <?php
                                        if($user[0]['total'] >= 1000){
                                            echo ($user[0]['total']/1000);
                                            echo 'k';
                                        }else{
                                            echo $user[0]['total'];
                                        }
                                        ?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php
                }?>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3 class="topUsers">Top post tháng <?php echo date('m')?></h3>

        <div id="topUserContent">
            <ul class="topUsers-list">
                <?php
                foreach ($top_posts as $user) {
                    ?>
                    <li class="item">
                        <a href="<?php echo $this->Html->url(array('plugin'=>'users','controller'=>'users','action'=>'view','username'=>$user['User']['username']));?>" title="<?php echo $user['User']['name'];?>">
                            <div class="row">
                                <img src="<?php echo !empty($user['User']['image'])?$user['User']['image']:'/img/noimage.gif';?>">
                            </div>
                            <div class="row">
                                <div class="info">
                                    <span class="name"><?php echo $user['User']['name'];?></span> <span><i class="fa fa-bookmark"></i> <?php
                                        if($user[0]['total'] >= 1000){
                                            echo ($user[0]['total']/1000);
                                            echo 'k';
                                        }else{
                                            echo $user[0]['total'];
                                        }
                                        ?></span>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php
                }?>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>
