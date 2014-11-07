<meta name="twitter:card" content="photo"/>
<meta name="twitter:site" content="@haytuyet"/>
<meta name="twitter:image" content="<?php
if ($this->request->action == 'view') {
    echo $this->Nodes->field('CustomFields.image');
} else {
    echo $this->Html->url('/img/haytuyet.jpg', true);
}
?>"/>
<meta property="og:title" content="<?php
if ($this->request->action == 'view') {
    echo $this->Nodes->field('title');
} else {
    echo Configure::read('Site.title');
}
?>"/>
<meta property="og:site_name" content="<?php
echo Configure::read('Site.title');
?>"/>
<meta property="og:url" content="<?php
if ($this->request->action == 'view') {
    echo $this->Html->url($this->Nodes->field('url'), true);
} else {
    echo $this->Html->url($this->request->here, true);
}
?>"/>
<meta property="og:description" content="Bấm xem và để lại comment..."/>
<meta property="og:type" content="article"/>
<meta property="og:image" content="<?php
if ($this->request->action == 'view') {
    echo $this->Nodes->field('CustomFields.image');
} else {
    echo $this->Html->url('/img/haytuyet.jpg', true);
}
?>"/>
<meta property="fb:app_id" content="462179947218302"/>