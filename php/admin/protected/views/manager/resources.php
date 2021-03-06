<div class="container-fluid">

    <div class="row-fluid">
        
        <div class="span2">
            
            <?php
            
            // TODO: delete me
            echo Yii::app()->bootstrap->registerCss();
            Yii::app()->getController()->setActiveTab("Resources");
            
            /* 
             * Draw left sidebar with resource types. User can select one of the type
             * and the resources with selected type will be showed.
             */
            $items = array(array('label'=>'RESOURCES', 'itemOptions'=>array('class'=>'nav-header')));
            
            /* Prepare items. Show selected item and set active attribute 
             */
            foreach ($resourceDataProvider->rawData as $resourceItem) {
                $name = $resourceItem['name'];
                $item = array('label'=>$name, 'url'=>'resources?resource='.$name, 'icon'=>'file');
                if ($name === $resource->name)
                    $item['active'] = true;
                $items[] = $item;
            }
            
            /* Render left sidebar
             */
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type'=>'list',
                'items'=>$items,
            ));
            
            ?>

        </div>
        
        <div class="span10">
            
            <?php
            /* Prepare dataprovider for reousrce list widget
             */
            $columns = array();
            if (!is_null($dataProvider->rawData)) {
                $data = $dataProvider->data;
                if (count($data) > 0) {
                    foreach ($data[0] as $key => $value) {
                        if (is_string($value)) {
                            $columns[] = $key;
                        }
                    }
                }

                if (isset($columns)) {
                    $deleteButtonUrl = 'Yii::app()->createUrl("/manager/removeResourceObject", array("id"=>$data->id, "type"=>"'.$resource->name.'"));';
                    $updateButtonUrl = 'Yii::app()->createUrl("/manager/viewResourceObject", array("id"=>$data->id, "type"=>"'.$resource->name.'", "type_id" => "'.$resource->id.'"));';
                    
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
                
                <div class="pull-left"><h3><?php echo strtoupper($resource->name[0]).substr($resource->name, 1); ?> resources</h3></div>
                
                <div>
                
                    <?php
                    /* Render action buttons */

                    $this->widget('bootstrap.widgets.BootMenu', array(
                        'type'=>'pills',
                        'htmlOptions'=>array('class'=>'pull-right'),
                        'stacked'=>false,
                        'items'=>array(
                            array('label'=>'New '.$resource->name, 'url'=>'addResource?type='.$resource->name.'&id='.$resource->id, 'active'=>true),
                        ),
                    ));

                    ?>
                </div>
                
            </div>
            
            <div>
                
                <?php
                /* Render resource list widget */
                
                $this->widget('bootstrap.widgets.BootGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>"{items}{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>$columns
                ));

                ?>
                
            </div>
            
        </div>
        
    </div>
    
</div>