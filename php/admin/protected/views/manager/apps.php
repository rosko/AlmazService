<div class="container-fluid">

    <div class="row-fluid">
        
        <?php
            echo Yii::app()->bootstrap->registerCss();
            Yii::app()->getController()->setActiveTab("Client Applications");
        ?>

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
                    $deleteButtonUrl = 'Yii::app()->createUrl("/manager/removeUser", array("id"=>$data->id, "type"=>"'.$resource->name.'"));';
                    $updateButtonUrl = 'Yii::app()->createUrl("/manager/viewUser", array("id"=>$data->id, "type"=>"'.$resource->name.'", "type_id" => "'.$resource->id.'"));';
                    
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
                
                <div class="pull-left"><h3>Applications</h3></div>
                
                <div>

                    <?php
                    /* Render action buttons */

                    $this->widget('bootstrap.widgets.BootMenu', array(
                        'type'=>'pills',
                        'htmlOptions'=>array('class'=>'pull-right'),
                        'stacked'=>false,
                        'items'=>array(
                            array('label'=>'Add', 'url'=>'addUser', 'active'=>true),
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