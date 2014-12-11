<?php
if(false){
    $nodes = file_get_contents('http://haytuyet.com/?random=1');
    $nodes = json_decode($nodes,true);
    foreach($nodes as $node){
        ?>
        <div class="col-xs-6 col-md-3">
            <a href="http://haytuyet.com<?php echo $node['Node']['path']?>"
               class="thumbnail" target="_blank" title="<?php echo $node['Node']['title'];?>">
                <img src="<?php echo $node['CustomFields']['image'];?>">
                <h4><?php echo $node['Node']['title'];?></h4>
            </a>
        </div>
    <?php
    }
}
?>
