<div class="col-md-7">
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
            'next' =>$next[$i],
            'prev' =>$prev[$i],
        );
    }
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
                <h2><a href="<?php echo $this->Html->url( $this->Nodes->field('url')); ?>" target="_blank"><?php echo $this->Nodes->field('title')?></a></h2>
            </div>
            <?php
            echo $this->Nodes->moreInfo(array('keys' => $temp));
            ?>
        </div>
    <?php
    endforeach;
    ?>

    <div class="row">
        <div class="col-md-12">
                <?php
                echo $this->Paginator->prev(__('&laquo; Trang trước'), array('tag' => false,'class' => 'btn btn-success pull-left','escape'=>false), null, array('tag' => false,'class' => 'btn btn-success pull-left disabled','disabledTag' => 'a','escape'=>false));
                echo $this->Paginator->next(__('&raquo; Trang tiếp theo'), array('tag' => false,'class' => 'btn btn-success pull-right','escape'=>false), null, array('tag' => false,'class' => 'btn btn-success pull-right disabled','disabledTag' => 'a','escape'=>false));
                ?>
        </div>
    </div>
</div>
    </div>