<h2 class="sidebar-title"><i class="fa fa-star"></i> Clip hot</h2>
<hr>
<ul id="jsid-featured-item-container">
    <?php
    foreach($hot_nodes as $item){
        ?>
        <li class="badge-featured-item">
            <div class="img-container">
                <a href="<?php echo $this->Html->url($item['Node']['url'])?>" class="badge-evt">
                    <img src="<?php echo $item['CustomFields']['image']?>">
                </a>
            </div>
            <div class="info-container">
                <h3>
                    <a href="<?php echo $this->Html->url($item['Node']['url'])?>" class="badge-evt">
                        <?php echo $item['Node']['title']?>
                    </a>
                </h3>
            </div>
        </li>
    <?php
    }
    ?>
</ul>
