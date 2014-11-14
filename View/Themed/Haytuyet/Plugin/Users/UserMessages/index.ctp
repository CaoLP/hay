<div class="col-md-7">
    <div class="row">
        <?php echo $this->element('note'); ?>
    </div>
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="pagination">
                <?php
                echo $this->Paginator->prev(__('&laquo;'), array('tag' => 'li','escape'=>false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a','escape'=>false));
                echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
                echo $this->Paginator->next(__('&raquo;'), array('tag' => 'li','currentClass' => 'disabled','escape'=>false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a','escape'=>false));
                ?>
            </ul>
        </div>
    </div>
</div>