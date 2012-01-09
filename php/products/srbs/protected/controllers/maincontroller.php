<?php

class MainController extends CController {
    /*
    Actions method implementation. Method name must contain page name and 'action' string
    as a prefix
    */
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionAbout() {
        $this->render('about');
    }
}