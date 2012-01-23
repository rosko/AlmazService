<h2 class="section_title">Shema</h2>

<?php

$this->widget('zii.widgets.CListView', array(
    'id'=>'Shema_ListView',
    'dataProvider'=>$shemaDataProvider,
    'template'=>'{items}',
    'itemView'=>'EntityItem',
));

?>

<h2 class="section_title">Resource Type</h2>

<?php

$this->widget('zii.widgets.CListView', array(
    'id'=>'ResourceType_ListView',
    'dataProvider'=>$resourceDataProvider,
    'template'=>'{items}',
    'itemView'=>'EntityItem',
));

?>