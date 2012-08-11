
<?php
Yii::app()->clientScript->registerPackage('jquery.ui');

echo Yii::app()->bootstrap->registerCss();

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'action'=>'saveResourceObject'
));

echo CHtml::hiddenField('type', $type);

?>

<fieldset>
    <legend>New <?php echo $type; ?> resource</legend>

    <?php
        $fields = $resource->getFields();
        $attributes = $resource->getAttributes();

        foreach ($resource->getFields() as $field) {
            if ($field['type'] === 'array')
                continue;
            
            $field_id = $field['attribute'];
            
            echo '<div class="control-group">';
            echo '<label class="control-label" for='.$field_id.'>'.$field['label'].'</label>';
            echo '<div class="controls">';
            
            $value = $attributes[$field_id];
            
            if (!empty($field['readonly']))
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

       <div class="control-group" id="prototype">
           <div class="controls">
               <input type="hidden" class="object_id">
               <span class="title"></span>
               <button class="btn obj-remove" style="width:70px;">Remove</button>
           </div>
       </div>

       <?php foreach ($attributes['objects'] as $obj) { ?>

       <div class="control-group">
           <div class="controls">
               <input type="hidden" class="object_id" name="objects[][id]" value="<?php echo $obj['id']; ?>">
               <span class="title"><?php echo $obj['name']; ?></span>
               <button class="btn obj-remove" style="width:70px;">Remove</button>
           </div>
       </div>

       <?php }  ?>

   </div>
    
   <div class="control-group" id="parent_empty">
        <div class="controls">
            <?php
            $list = array(0 => 'Select object');
            foreach ($objects as $obj) {
                $list[$obj->id] = $obj->name;
            }

            echo CHtml::dropDownList('resource_object', '', $list);
            ?>

            <?php echo CHtml::button('Add', array('class'=>'btn btn-success', 'id'=>'btnAdd', 'style'=>'width:70px;')); ?>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <?php echo CHtml::link('Cancel', 'resources?resource='.$type, array('class'=>'btn')) ?>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript" language="javascript">
    $("#prototype").hide();

    $('.obj-remove').live('click', function() {
        $(this).parents('.control-group:eq(0)').remove();
        return false;
    });

    $('#obj-fields').sortable();

    $("#btnAdd").click(function() {

        if ($('#resource_object').val() > 0) {

            var obj = $("#prototype").clone();

            obj.attr('id', '');
            obj.find('input.object_id').attr('name', 'objects[][id]').val($('#resource_object').val());
            obj.find('.title').text($('#resource_object option:selected').text());


            obj.appendTo($("#obj-fields"));
            obj.show();

            $("#resource_object").val(0);

        }


    });
</script>