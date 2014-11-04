<h2 class="sidebar-title"><i class="fa fa-star"></i> Clip hot</h2>
<hr>
<ul id="jsid-featured-item-container">
    <?php
    foreach($hot_nodes as $item){
        ?>
        <li class="badge-featured-item" data-item-id="5806" id="featured-item-5806">
            <div class="img-container" data-item-id="5806">
                <a href="<?php echo $this->Html->url($item['Node']['url'])?>" class="badge-evt" target="_blank">
                    <img src="<?php echo $item['CustomFields']['image']?>">
                </a>
            </div>
            <div class="info-container" data-item-id="5806">
                <h3>
                    <a href="<?php echo $this->Html->url($item['Node']['url'])?>" class="badge-evt" target="_blank">
                        <?php echo $item['Node']['title']?>
                    </a>
                </h3>
            </div>
        </li>
    <?php
    }
    ?>
</ul>
