<?php
foreach($new_nodes as $node){
    ?>
<div class="col-md-3 new-post-item">
    <a href="<?php echo $this->Html->url($node['Node']['url']); ?>" title="<?php echo $node['Node']['title'];?>">
    <div class="row new-img">
        <img class="img-responsive" src="<?php echo $node['CustomFields']['image'];?>">
    </div>
    <div class="row new-title">
        <h3>
        <?php echo $node['Node']['title'];?>
        </h3>
    </div>
        </a>
</div>
<?php
}
