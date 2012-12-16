<?php
echo Yii::app()->bootstrap->registerCss();
?>

<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'action'=>'saveUser'
)); ?>

<fieldset>
    <legend>New User</legend>

    <?php
        $fields = $user->getFields();
        $attributes = $user->getAttributes();
    ?>

    <!-- ID -->
<!--    <div class="control-group">-->
<!--        <label class="control-label" for="userid">ID</label>-->
<!--        <div class="controls">-->
<!--            <span class="input-xlarge uneditable-input" id="userid" name="id">--><?php //echo $attributes['id']; ?><!--</span>-->
<!--            --><?php //echo CHtml::hiddenField('id', $attributes['id']); ?>
<!--        </div>-->
<!--    </div>-->
    
    <?php

    foreach ($fields as $field) {
        if ($field['type'] == 'string') {

        echo '<div class="control-group">';
        echo '  <label class="control-label" for="'.$field['attribute'].'">'.$field['label'].'</label>';
        echo '  <div class="controls">';
        echo '      <input type="text" class="input-xlarge" id='.$field['attribute'].' value="'.$attributes[$field['attribute']].'" name="'.$field['attribute'].'">';
        echo '  </div>';
        echo '</div>';

        }
    }

    ?>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save changes</button>
    <?php echo CHtml::link('Cancel', 'user', array('class'=>'btn')) ?>
</div>

<?php $this->endWidget(); ?>
