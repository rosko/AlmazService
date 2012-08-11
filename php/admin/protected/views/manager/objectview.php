<?php
echo Yii::app()->bootstrap->registerCss();

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'action'=>'saveShemaObject',
    'htmlOptions'=>array('enctype'=>'multipart/form-data')
));

echo CHtml::hiddenField('shema', $shema);

?>

<fieldset>
    <legend>New <?php echo $shema; ?></legend>

    <?php
        $fields = $object->getFields();
        $attributes = $object->getAttributes();

        foreach ($fields as $field) {
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
                {
                    echo '<input type="text" class="input-xlarge" id="'.$field_id.'" name="'.$field_id.'" value="'.$value.'">';
                }
                else
                {
                    echo "<textarea rows=5 class=input-xlarge id=$field_id name=$field_id>$value</textarea>";
                    echo "<br/>";
                    echo CHtml::fileField("xfile", "", array('id'=>'btnFile', 'style'=>'color:black;'));
                }
            }

            echo '</div>';
            echo '</div>';
        }
    ?>

    <legend>Property</legend>
    
    <div id="prop-fields">
        
        <div class="control-group" id="prototype">
            <label class="control-label" for=""></label>
            <div class="controls">
                <input type="hidden">
                <input type="text" class="input-xlarge">
                <button class="btn" style="width:70px;">Remove</button>
            </div>
        </div>
        
        <?php
        $idx = 0;
        foreach ($attributes['property'] as $property) {
            $id = 'property_'.$idx;
            $parent_id = 'parent_'.$id;
            $title = $property['key_name'];
            $value = $property['value'];
            
            echo "<div class=\"control-group\" id=\"$parent_id\">";
            echo "<label class=\"control-label\" for=\"$id\">$title</label>";
            echo "<div class=\"controls\">";
            echo "<input type=\"hidden\" name=\"property[$idx][key_name]\" value=\"$title\">";
            echo "<input type=\"text\" class=\"input-xlarge\" id=\"$id\" value=\"$value\" name=\"property[$idx][value]\">";
            echo "&nbsp";
            echo "<button class=\"btn\" style=\"width:70px;\" onclick=\"js:$($parent_id).remove();\">Remove</button>";
            echo "</div>";
            echo "</div>";
            
            $idx++;
        }
        ?>
        
    </div>
    
    <div class="control-group" id="parent_empty">
        <div class="controls">
            <?php 
            $list = array();
            foreach ($propertyList as $prop) {
                $prop_name = 'property_'.str_replace('-', '_', $prop->key_name);
                $list[$prop_name] = $prop->key_name;
            }
            
            echo CHtml::dropDownList('object_property', 'key_name', $list, array('empty'=>'Select property'));
            ?>
            
            <?php echo CHtml::button('Add', array('class'=>'btn btn-success', 'id'=>'btnAdd', 'style'=>'width:70px;')); ?>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <?php echo CHtml::link('Cancel', 'shema?shema='.$shema, array('class'=>'btn')) ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript" language="javascript">
    $("#prototype").hide();
    
    var last_index = document.getElementById("prop-fields").children.length - 1;
    
    $("#btnAdd").click(function() {
        var prop_id = "property_"+last_index;
        var parent_id = "parent_" + prop_id;
        var prop = $("#prototype").clone().attr("id", parent_id);
        
        prop.children(".controls").children("input").attr("id", prop_id);
        prop.children(".controls").children("input[type=hidden]").attr("name", "property["+last_index+"][key_name]");
        prop.children(".controls").children("input[type=text]").attr("name", "property["+last_index+"][value]");
        prop.children(".controls").children("button").attr("onclick", "js:$("+parent_id+").remove();");
        
        var prop_label = $("#object_property").find('option:selected').text();
        prop.children("label").attr("for", prop_id).text(prop_label);
        
        prop.children(".controls").children("input[type=hidden]").attr("value", prop_label);
        
        prop.appendTo($("#prop-fields"));
        prop.show();
        
        $("#object_property").val("Select property");
        
        last_index++;
    });

    $("#btnFile").change(function() {
        var filename = this.value.split('/').pop().split('\\').pop();
        $("#text_value").val(filename);
    });

</script>