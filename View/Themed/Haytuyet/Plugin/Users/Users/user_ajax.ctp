<div class="media">
    <a class="media-left pull-left"
       href="<?php echo $this->Html->url(array('plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'user_posted', 'user_id' => $user['User']['id'])) ?>"
       title="<?php echo $user['User']['name'] ?>">
        <img src="<?php
        if (!empty($user['User']['image']))
            echo $user['User']['image'];
        else
            echo '/img/noimage.gif';
        ?>">
    </a>
    <a class="pull-left"
       href="<?php echo $this->Html->url(array('plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'user_posted', 'user_id' => $user['User']['id'])) ?>"
       title="<?php echo $user['User']['name'] ?>">
        <div class="media-body pull-right">
            <h4 class="media-heading"><?php echo $user['User']['name'] ?></h4>

            <p><i class="fa fa-thumbs-up"></i> <?php
                        if(isset($total[0][0]['likes'])){
                            $i = $total[0][0]['likes'];
                            if($total[0][0]['likes']>=1000) echo ($i/1000) . 'k';
                            else echo $i;
                        }else echo '0';
                ?></p>

            <p><i class="fa fa-bookmark-o"></i> <?php
                if(isset($total[0][0]['total'])){
                    $i = $total[0][0]['total'];
                    if($total[0][0]['total']>=1000) echo ($i/1000) . 'k';
                    else echo $i;
                }else echo '0';
                ?></p>
        </div>
    </a>
</div>