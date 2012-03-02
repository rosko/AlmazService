<div class="container-fluid">

    <div class="row-fluid">
        
        <div class="span2">
            
            <?php
            
            // TODO: delete me
            echo Yii::app()->bootstrap->registerCss();
            
            $items = array(array('label'=>'SHEMA', 'itemOptions'=>array('class'=>'nav-header')));
            
            foreach ($shemaDataProvider->rawData as $shemaItem) {
                $item = array('label'=>$shemaItem, 'url'=>'shema?shema='.$shemaItem, 'icon'=>'list-alt');
                if ($shemaItem === $shema)
                    $item['active'] = true;
                $items[] = $item;
            }
            
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type'=>'list',
                'items'=>$items,
            ));
            
            ?>

        </div>
        
        <div class="span10">
            
            <?php
            
            $columns = array();

            if (!is_null($dataProvider->rawData)) {
                $data = $dataProvider->data;
                if (count($data) > 0) {
                    $attrs = $data[0]->getAttributes();
                    foreach ($attrs as $key => $value) {
                        if (is_string($value)) {
                            $columns[] = $key;
                        }
                    }
                }
                
                if (isset($columns)) {
                    $deleteButtonUrl = 'Yii::app()->createUrl("/manager/removeShemaObject", array("id"=>$data->id, "shema"=>"'.$shema.'"));';
                    $updateButtonUrl = 'Yii::app()->createUrl("/manager/viewShemaObject", array("id"=>$data->id, "shema"=>"'.$shema.'"));';
                    
                    $columns[] = array(
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}{delete}',
                        'htmlOptions'=>array('style'=>'width: 30px'),
                        'deleteButtonUrl'=>$deleteButtonUrl,
                        'updateButtonUrl'=>$updateButtonUrl
                    );
                }
            } else {
                $dataProvider = new CArrayDataProvider(array());
            }
            ?>
            
            <div>
                <div class="pull-left"><h3><?php echo strtoupper($shema[0]).substr($shema, 1); ?> shema</h3></div>
                
                <div>
                    <?php $this->widget('bootstrap.widgets.BootMenu', array(
                        'type'=>'pills',
                        'htmlOptions'=>array('class'=>'pull-right'),
                        'stacked'=>false,
                        'items'=>array(
                            array('label'=>'New '.$shema, 'url'=>'viewShemaObject?shema='.$shema, 'active'=>true),
                        ),
                    )); ?>
                </div>
            </div>
            
            <div>
                <?php $this->widget('bootstrap.widgets.BootGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>"{items}{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>$columns
                )); ?>
            </div>
            
        </div>
        
    </div>
    
</div>