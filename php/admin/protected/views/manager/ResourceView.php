<h2 class="section_title">Resource</h2>

<div style="height:30px;">
<h3>Class name: <?php echo $class['name']; ?></h3>
</div>

<?php 

$properties = $class['property'];

echo CHtml::beginForm(Yii::app()->createUrl('/manager/resourceSave', array(
    'class_id'=>$class['id'],
    'type'=>$type,
)), 'POST');

if (isset($properties) && count($properties)) {
    foreach ($properties as $property) {
        echo '<div style="height:30px;">';
        echo CHtml::label($property['key_name'].': ', $property['key_name']);
        echo CHtml::textField($property['key_name']);
        echo '</div>';
    }
}

echo '<div style="height:30px;">';
echo CHtml::submitButton('Save');
echo '</div>';

echo CHtml::endForm();

echo '<br/>'. CHtml::link('< back', 'index.php');

?>
