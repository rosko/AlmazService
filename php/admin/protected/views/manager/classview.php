<?php
echo Yii::app()->bootstrap->registerCss();
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'action'=>'saveShemaObject'
)); ?>

<?php echo CHtml::hiddenField('shema', $shema); ?>

<fieldset>
    <legend>New <?php echo $shema; ?></legend>

    <?php
        $fields = $object->getFields();
        $attributes = $object->getAttributes();
    ?>

    <!-- ID -->
    <div class="control-group">
        <label class="control-label" for="clsid">ID</label>
        <div class="controls">
            <span class="input-xlarge uneditable-input" id="clsid" name="id"><?php echo $attributes['id']; ?></span>
            <?php echo CHtml::hiddenField('id', $attributes['id']); ?>
        </div>
    </div>
    
    <!-- Name -->
    <div class="control-group">
        <label class="control-label" for="clsname">Name</label>
        <div class="controls">
            <input type="text" class="input-xlarge" id="clsname" name="name" value="<?php echo $attributes['name']; ?>">
        </div>
    </div>
    
    <!-- Description -->
    <div class="control-group">
        <label class="control-label" for="clsdescr">Description</label>
        <div class="controls">
            <input type="text" class="input-xlarge" id="clsdescr" name="descr" value="<?php echo $attributes['descr']; ?>">
        </div>
    </div>
    
    <legend>Class Property</legend>
    
    <div id="prop-fields">
        
        <div class="control-group" id="prototype">
            <label class="control-label" for=""></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="">
                <button class="btn" style="width:70px;">Remove</button>
            </div>
        </div>
        
        <?php
        $idx = 0;
        
        foreach ($attributes['property'] as $property) {
            $id = 'property_'.$idx;
            $value = $property['key_name'];
            
            echo '<div class="control-group" id="parent_'.$id.'">';
            echo '<label class="control-label" for="'.$id.'">Property name</label>';
            echo '<div class="controls">';
            echo "<input type=\"text\" class=\"input-xlarge\" id=$id value=\"$value\" name=\"property[$idx][key_name]\">";
            echo '&nbsp';
            echo '<button class="btn" style="width:70px;" onclick="js:$(parent_'.$id.').remove();">Remove</button>';
            echo '</div>';
            echo '</div>';
            
            $idx++;
        }
        ?>
        
    </div>
    
    <div class="control-group" id="parent_empty">
        <div class="controls">
            <span class="input-xlarge uneditable-input" id="empty" align="center">Press Add button to add new property</span>
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
        var prop_id = "property_" + last_index;
        var prop = $("#prototype").clone().attr("id", "parent_" + prop_id);
        
        prop.children(".controls").children("input").attr("id", prop_id);
        prop.children(".controls").children("input").attr("name", "property["+last_index+"][key_name]");
        prop.children(".controls").children("button").attr("onclick", "js:$(parent_"+prop_id+").remove();");
        prop.children("label").attr("for", prop_id).text("Property name");
        prop.appendTo($("#prop-fields"));
        prop.show();
        
        last_index++
    });
</script>