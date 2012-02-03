<h2 class="section_title">Resource Type List</h2>

<?php 
$this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'link',
	'name'=>'add_new',
	'caption'=>'Add',
	'url'=>Yii::app()->createUrl("/manager/showForm", array('type'=>$type)),
));

$columns = array();

if (!is_null($dataProvider->rawData)) {
    $data = $dataProvider->data;
    if (count($data) > 0) {
        $attrs = $data[0]->getAttributes();
        foreach ($attrs as $key => $value) {
            if (is_string($value)) {
                $columns[] = $key;
            }
        }
    }
    
    if (isset($columns)) {
        $deleteButtonUrl = 'Yii::app()->createUrl("/manager/shemaRemove", array("id"=>$data->id, "type"=>"'.$type.'"));';
        $updateButtonUrl = 'Yii::app()->createUrl("/manager/showForm", array("id"=>$data->id, "type"=>"'.$type.'"));';

        $columns[] = array(
            'class'=>'CButtonColumn', 
            'template'=>'{update}{delete}',
            'deleteButtonUrl'=>$deleteButtonUrl,
            'updateButtonUrl'=>$updateButtonUrl
        );
    }
} else {
    $dataProvider = new CArrayDataProvider(array());
}

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>$columns,
));

echo '<br/>'. CHtml::link('< back', 'index.php');

?>
