
<div style="height:20px;font-size:14px;">
    <?php
        if ($widget->id == 'Shema_ListView')
            echo CHtml::link($data, Yii::app()->createUrl('manager/entity', array('type'=>$data)));
        else
            echo CHtml::link($data['name'], Yii::app()->createUrl('manager/resource', array('type'=>$data['name'], 'id'=>$data['id'])));
    ?>
</div>
