<?php
echo Yii::app()->bootstrap->registerCss();

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'action'=>'saveResourceObject'
));

//echo CHtml::hiddenField('shema', $type);

?>

<fieldset>
    <legend>New <?php echo $type; ?> resource</legend>

    <?php
        //$fields = $object->getFields();
        //$attributes = $object->getAttributes();

        foreach ($resource->getFields() as $field) {
            if ($field['type'] === 'array')
                continue;
            
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
            {
                if ($field['type'] === 'string')
                    echo '<input type="text" class="input-xlarge" id="'.$field_id.'" name="'.$field_id.'" value="'.$value.'">';
                else
                    echo "<textarea rows=5 class=input-xlarge id=$field_id name=$field_id>$value</textarea>";
            }

            echo '</div>';
            echo '</div>';
        }
    ?>

    <legend>Property</legend>
    
    <div id="prop-fields">
        
        <?php
        
        $idx = 0;
        
        foreach ($class->property as $property) {
            $id = 'property_'.$idx;
            $parent_id = 'parent_'.$id;
            
            echo "<div class=\"control-group\" id=\"$parent_id\">";
            echo "<label class=\"control-label\" for=\"$id\">$property->key_name</label>";
            echo "<div class=\"controls\">";
            echo "<input type=\"hidden\" name=\"property[$idx][key_name]\" value=\"$property->key_name\">";
            echo "<input type=\"text\" class=\"input-xlarge\" id=\"$id\" value=\"$property->value\" name=\"property[$idx][value]\">";
            echo "</div>";
            echo "</div>";
            
            $idx++;
        }
        ?>
        
    </div>
    
   <legend>Objects</legend>
   
   <div id="obj-fields">
       
   </div>
    
   <div class="control-group" id="parent_empty">
        <div class="controls">
            <?php 
//            $list = array();
//            foreach ($propertyList as $prop) {
//                $prop_name = 'property_'.str_replace('-', '_', $prop->key_name);
//                $list[$prop_name] = $prop->key_name;
//            }
//            
//            echo CHtml::dropDownList('object_property', 'key_name', $list, array('empty'=>'Select property'));
            ?>
            
            <?php //echo CHtml::button('Add', array('class'=>'btn btn-success', 'id'=>'btnAdd', 'style'=>'width:70px;')); ?>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <?php echo CHtml::link('Cancel', 'resources?resource='.$type, array('class'=>'btn')) ?>
</div>

<?php $this->endWidget(); ?>