<div class="node-info">
    <?php
    $type = $types_for_layout[$this->Nodes->field('type')];

    if ($type['Type']['format_show_author']) {

    ?>
    <a target="_blank" href="<?php echo $this->Html->url(array('plugin' => 'nodes', 'controller' => 'nodes', 'action' => 'user_posted', 'user_id'=>$this->Nodes->field('User.id'))) ?>">
    <div class="pull-left"><img class="avatar"
                                src="<?php echo $this->Nodes->field('User.image') ? $this->Nodes->field('User.name') : '/img/noimage.gif'; ?>">
    </div>
    <div class="author-info">
        <span class="author">
            <?php
            echo $this->Nodes->field('User.name');
            ?>
        </span>
        <?php
        }
        if ($type['Type']['format_show_date']) {
            echo '<br>';
            //echo $this->Html->tag('span', $this->Time->format(Configure::read('Reading.date_time_format'), $this->Nodes->field('created'), null, Configure::read('Site.timezone')), array('class' => 'date'));
            $dt1 = new DateTime();
            $dt2 = new DateTime($this->Nodes->field('created'));
            $total = $this->Custom->getDiffInHours($dt1, $dt2);
            if ($total > 48)
                echo '<span class="date">' . $this->Time->format(Configure::read('Reading.date_time_format'), $this->Nodes->field('created'), null, Configure::read('Site.timezone')) . '</span>';
            else
                echo '<span class="date">' . $total . ' giờ</span>';

        }
        ?>
    </div>
    </a>
</div>
