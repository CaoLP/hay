<div class="node-info">
    <?php
    $type = $types_for_layout[$this->Nodes->field('type')];

    if ($type['Type']['format_show_author']) {
        if ($this->Nodes->field('User.website') != null) {
            echo '<a href="' . $this->Nodes->field('User.website') . '">';
        }
        ?>
        <span class="author">
        <img class="avatar"
            src="<?php echo $this->Nodes->field('User.image') ? $this->Nodes->field('User.name') : '/img/noimage.gif'; ?>">
            <?php
            echo $this->Nodes->field('User.name');
            ?>
        </span>
    <?php
    }
    if ($type['Type']['format_show_date']) {
        echo '<br>';
        echo $this->Html->tag('span', $this->Time->format(Configure::read('Reading.date_time_format'), $this->Nodes->field('created'), null, Configure::read('Site.timezone')), array('class' => 'date'));
    }
    ?>
</div>
