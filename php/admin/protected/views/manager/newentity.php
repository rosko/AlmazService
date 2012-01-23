<h2 class="section_title">Add new <?php echo strtoupper($type); ?></h2>

<?php

// Class view
echo CHtml::beginForm(Yii::app()->createUrl('/manager/save', array('type'=>$type)), 'GET');

if ($type == 'class') {
    echo CHtml::hiddenField('id', $data['id']);
    echo CHtml::label('Name: ', 'name');
    echo CHtml::textField('name', $data['name']).'<br/><br/>';
    echo CHtml::label('Description: ', 'descr');
    echo CHtml::textField('descr', $data['descr']).'<br/><br/>';
    
    $columns = array();
    
    if (!is_null($data['property']))
    {
        if (count($data['property']) > 0) {
            foreach ($data['property'][0] as $key => $value) {
                if (is_string($value)) {
                    $columns[] = $key;
                }
            }
        }
        
        $dataProvider = new CArrayDataProvider($data['property']);
    }
    else
    {
        $dataProvider = new CArrayDataProvider(array());
    }
    
    echo "Class Property:<br/><br/>";
    
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'buttonType'=>'button',
        'name'=>'add_new',
        'caption'=>'Add',
    ));
    
    $this->widget('zii.widgets.jui.CJuiButton', array(
        'buttonType'=>'button',
        'name'=>'remove',
        'caption'=>'Remove',
        'url'=>Yii::app()->createUrl("/manager/create", array("type"=>$_GET["type"])),
    ));
    
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns'=>$columns,
    ));
    
} else if ($type == 'meta') {
    echo CHtml::hiddenField('id', $id);
    echo CHtml::label('Key: ', 'key_name');
    echo CHtml::textField('key_name', $key_name).'<br/><br/>';
    echo CHtml::label('Description: ', 'descr');
    echo CHtml::textField('descr', $descr).'<br/><br/>';
} else if ($type == 'object') {
    echo CHtml::hiddenField('id', $id);
    echo CHtml::label('Text: ', 'text');
    echo CHtml::textField('text', $name).'<br/><br/>';
    echo CHtml::label('Description: ', 'descr');
    echo CHtml::textField('descr', $descr).'<br/><br/>';
}

echo '<br/>';
echo CHtml::submitButton('Save');
echo CHtml::endForm();

echo '<br/>';
echo CHtml::link('< back', Yii::app()->createUrl('manager/entity', array('type'=>$type)));

?>