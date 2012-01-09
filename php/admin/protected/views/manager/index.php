<h2>Resource Type List</h2>

<?php 
echo $this->str; 

$dataProvider = new CArrayDataProvider(array(
    array('title'=>'wer'),
    array('title'=>'some', 'test'=>'ew'),
    array('title'=>'423'),
    array('title'=>'434'),
));

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'title',
        'test',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
));

?>

