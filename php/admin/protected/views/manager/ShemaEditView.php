<h2><u>Add new Shema DataModel object</u></h2>

<div style="margin-top:20px;">

<div style="margin:0 auto;background-color:lightyellow;width:100%;">

<?php
    
    echo CHtml::beginForm(Yii::app()->createUrl('/manager/ShemaSave', array('type'=>$type)), 'GET');
    
    $fields = $object->getFields();
    $attributes = $object->getAttributes();
    
    if (isset($attributes['id'])) {
        echo CHtml::hiddenField('id', $attributes['id']);
    }
    
    foreach ($fields as $field) {
        echo '<div style="padding:10px 10px 10px 10px;height:20px;font-family:verdana;">';

        echo '<div style="width:150px;height:30px;float:left;">';
        echo CHtml::label($field['label'].': ', $field['attribute']);
        echo '</div>';

        echo '<div style="padding:1px;float:left;background-color:black;">';

        if ($field['type'] == 'array') {
            // Draw property
            $properties = $attributes[$field['attribute']];
            foreach ($properties as $prop) {
                if ($prop['key_name'] !== '')
                    $props .= $prop['key_name'].';';
            }

            echo CHtml::textField($field['attribute'], $props, array('class'=>'tb7'));
        } else {
            echo CHtml::textField($field['attribute'], $attributes[$field['attribute']], array('class'=>'tb7'));
        }

        echo '</div>';
        echo '</div>';
    }
    
    echo '<div style="padding:10px;">';
    echo CHtml::submitButton('Save');
    echo '</div>';
    
    echo CHtml::endForm();
    
?>

</div>

</div>

<?php echo '<br/>'. CHtml::link('< back', $_SERVER['HTTP_REFERER']); ?>
