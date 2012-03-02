<h2 class="section_title">Resources</h2>

<?php 
$this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'link',
	'name'=>'add_new',
	'caption'=>'Add',
	'url'=>Yii::app()->createUrl("/manager/resourceShowForm", array("type"=>$type,"id"=>$id,)),
));

$columns = array();

if (!is_null($dataProvider->rawData)) {
    $data = $dataProvider->data;
    if (count($data) > 0) {
        foreach ($data[0] as $key => $value) {
            if (is_string($value)) {
                $columns[] = $key;
            }
        }
    }
    
    if (isset($columns)) {
        // $deleteButtonUrl = 'Yii::app()->createUrl("/manager/delete", array("id"=>$data["id"], "type"=>"'.$type.'"));';
        // $updateButtonUrl = 'Yii::app()->createUrl("/manager/update", array("id"=>$data["id"], "type"=>"'.$type.'"));';
        
        $columns[] = array(
            'class'=>'CButtonColumn', 
            'template'=>'{update}{delete}',
            // 'deleteButtonUrl'=>$deleteButtonUrl,
            // 'updateButtonUrl'=>$updateButtonUrl
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
