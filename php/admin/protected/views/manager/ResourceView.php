<h2 class="section_title">Resource</h2>

<div style="margin-top:20px;">

<div style="margin:0 auto;background-color:lightyellow;width:100%;">

<?php
    
    function drawTextField($label, $fieldIdent, $fieldValue) {
        echo '<div style="padding:10px 10px 10px 10px;height:20px;font-family:verdana;">';
        echo '<div style="width:150px;height:30px;float:left;">';
        echo CHtml::label($label.': ', $fieldIdent);
        echo '</div>';
        echo '<div style="padding:1px;float:left;background-color:black;">';
        echo CHtml::textField($fieldIdent, $fieldValue, array('class'=>'tb7'));
        echo '</div>';
        echo '</div>';
    }
    
    echo CHtml::beginForm(Yii::app()->createUrl('/manager/resourceSave', array('type'=>$type)), 'GET');
    
    $fields = $object->getFields();
    $attributes = $object->getAttributes();
    
    if (isset($attributes['id'])) {
        echo CHtml::hiddenField('id', $attributes['id']);
    }
    
    foreach ($fields as $field) {
        if ($field['type'] == 'array') {
            $properties = $attributes[$field['attribute']];
            foreach ($properties as $prop) {
                if ($prop['key_name'] !== '' && isset($prop['key_name'])) {
                    drawTextField($prop['key_name'], 'property_'.$prop['key_name'], '');
                }
            }
        } else {
            drawTextField($field['label'], $field['attribute'], $attributes[$field['attribute']]);
        }
    }
    
    echo '<div style="padding:10px;">';
    echo CHtml::submitButton('Save');
    echo '</div>';
    
    echo CHtml::endForm();
    
?>

</div>

</div>

<?php echo '<br/>'. CHtml::link('< back', $_SERVER['HTTP_REFERER']); ?>