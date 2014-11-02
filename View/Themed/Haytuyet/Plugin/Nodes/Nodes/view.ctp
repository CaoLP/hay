<?php $this->Nodes->set($node); ?>
<div id="node-<?php echo $this->Nodes->field('id'); ?>" class="node node-type-<?php echo $this->Nodes->field('type'); ?>">
	<h2><?php echo $this->Nodes->field('title'); ?></h2>
	<?php
//		echo $this->Nodes->info();
//		echo $this->Nodes->body();
//		echo $this->Nodes->moreInfo();
    if($this->Nodes->field('CustomFields.youtube_clip')){
        ?>
        <div class="video-container">
            <iframe src="<?php echo str_replace('watch?v=','embed/',$this->Nodes->field('CustomFields.youtube_clip'));?>?rel=0&showinfo=0&iv_load_policy=3&modestbranding=1&nologo=1&vq=large&autoplay=0&amp;ps=docs" frameborder="0"
                    width="560"
                    height="315" allowfullscreen></iframe>
        </div>
    <?php
    }else if($this->Nodes->field('CustomFields.image')){
        ?>
        <img class="img-responsive"
             src="<?php echo $this->Nodes->field('CustomFields.image'); ?>">
    <?php
    }
	?>
</div>

<?php if (CakePlugin::loaded('Comments')): ?>
<div id="comments" class="node-comments">
<?php
	$type = $types_for_layout[$this->Nodes->field('type')];

	if ($type['Type']['comment_status'] > 0 && $this->Nodes->field('comment_status') > 0) {
		echo $this->element('Comments.comments', array('model' => 'Node', 'data' => $node));
	}

	if ($type['Type']['comment_status'] == 2 && $this->Nodes->field('comment_status') == 2) {
		echo $this->element('Comments.comments_form', array('model' => 'Node', 'data' => $node));
	}
?>
</div>
<?php endif; ?>