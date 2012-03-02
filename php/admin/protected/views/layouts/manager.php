<?php

// TODO: need to refactor
echo Yii::app()->bootstrap->registerCss();

$this->beginContent('/layouts/main');

$items = array(
    array('label'=>'Shema', 'icon'=>'book', 'url'=>Yii::app()->createUrl('manager/shema')),
    array('label'=>'Resources', 'icon'=>'home', 'url'=>Yii::app()->createUrl('manager/resources')),
    array('label'=>'Users', 'icon'=>'user', 'url'=>Yii::app()->createUrl('manager/user')),
    array('label'=>'Client Applications', 'icon'=>'pencil', 'url'=>Yii::app()->createUrl('manager/client')),
);

for ($idx = 0; $idx < count($items); ++$idx) {
    if ($items[$idx]['label'] === $this->getActiveTab()) {
        $items[$idx]['active'] = true;
        break;
    }
}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs',
    'stacked'=>false,
    'items'=>$items
));

echo $content;

$this->endContent();

?>