<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    
    <link rel="stylesheet" href="/css/layout.css" type="text/css" media="screen, projection" />
    
    <?php echo Yii::app()->bootstrap->registerCss(); ?>
    
</head>

<body>
    <div id="wrapper">
    
    <div>
        <?php
        
        $this->widget('bootstrap.widgets.BootNavbar', array(
            'fixed' => false,
            'brand' => 'Resource Service',
            'brandUrl' => '#',
            'collapse' => true,
            'items' => array(
                array(
                    'class'=>'bootstrap.widgets.BootMenu',
                    'items'=>array(
                        array('label'=>'Managament', 'url'=>'index', 'active'=>true),
                        array('label'=>'Help', 'url'=>'about'),
                        array('label'=>'About', 'url'=>'about'),
                    ),
                ),
                array(
                    'class'=>'bootstrap.widgets.BootMenu',
                    'htmlOptions'=>array('class'=>'pull-right'),
                    'items'=>array(
                        array('label'=>'Logout', 'url'=>'logout')
                    )
                )
            ),
        ));
        
        ?>
    </div>
    
    <div>

        <?php echo $content; ?>
        
    </div>
    
    </div>
    
</body>

</html>