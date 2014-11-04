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
            <div class="title">
                <h2><a href="<?php echo $this->Html->url( $this->Nodes->field('url')); ?>" target="_blank"><?php echo $this->Nodes->field('title')?></a></h2>
                <?php
                echo $this->Nodes->info();
                ?>
            </div>
            <?php
            echo $this->Nodes->body();
            echo $this->Nodes->moreInfo(array('keys' => $temp));
            ?>
        </div>
    <?php
    endforeach;
    ?>

    <div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
</div>
    </div>