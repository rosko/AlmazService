<?php
echo Yii::app()->bootstrap->registerCss();

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'action'=>'saveShemaObject'
));

echo CHtml::hiddenField('shema', $shema);

?>

<fieldset>
    <legend>New <?php echo $shema; ?></legend>

    <?php
        $fields = $object->getFields();
        $attributes = $object->getAttributes();

        foreach ($fields as $field) {
            
            $field_id = $field['attribute'];
            
            echo '<div class="control-group">';
            echo '<label class="control-label" for='.$field_id.'>'.$field['label'].'</label>';
            echo '<div class="controls">';
            
            $value = $attributes[$field_id];
            
            if ($field['readonly']) 
            {
                echo '<span class="input-xlarge uneditable-input" id="'.$field_id.'">'.$value.'</span>';
                echo CHtml::hiddenField($field_id, $value);
            }
            else
                echo '<input type="text" class="input-xlarge" id="'.$field_id.'" name="'.$field_id.'" value="'.$value.'">';

            echo '</div>';
            echo '</div>';
        }
    ?>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <?php echo CHtml::link('Cancel', 'shema?shema='.$shema, array('class'=>'btn')) ?>
</div>

<?php $this->endWidget(); ?>