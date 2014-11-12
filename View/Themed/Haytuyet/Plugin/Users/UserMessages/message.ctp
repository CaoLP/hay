<ul class="list-group">
    <?php foreach($messages as $message){
        ?>
        <li class="list-group-item">
            <img src="<?php
            if(!empty($message['User']['image']))
            echo $message['User']['image'];
            else echo '/img/noimage.gif';
            ?>" class="avatar"><span> <?php echo $message['UserMessage']['message']?></span>
        </li>
    <?php
    }?>
</ul>