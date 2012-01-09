<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');

class ServiceController extends CController {
    public function actionIndex() {
        $all_resources = $this->actionGet();

        echo '<h2>Resource</h2>';
        foreach ($all_resources as $r) {
            echo $r->id . '-' . $r->type->name.'<br/>';
            echo 'Metas:<br/>';
            foreach ($r->meta as $m)
                echo '<li>'.$m->meta_value . '</li>';
        }
    }
    
    // Get resource by type
    // URI:
    //    by id:    resource/audio/12312.json
    //    list:     resource/audio/list.json
    //              resource/audio/list.json?from=recNumber&count=recCount
    //
    // Test URI:
    //    http://localhost/~sshkrabak/test/index.php?rtype=images&rid=list&from=1&count=1
    //
    public function actionGet() {
        if (!Parameters::hasParam('rtype'))
            die('ServiceController: Invalid resource TYPE (parameter name: \'rtype\')');
        
        $resource_type = Parameters::get('rtype');
        
        if (!Parameters::hasParam('rid'))
            die('ServiceController: Invalid resource IDENTIFICATOR (parameter name: \'rid\')');
        
        $criteria = new CDbCriteria;
        $criteria->alias = 'r';
        $criteria->addCondition('name=:resource_type');
        $criteria->params = array(':resource_type' => $resource_type);
        
        if (Parameters::get('rid') == 'list') {
            // Offset from the beginning of the result recordset
            if (Parameters::hasParam('from'))
                $criteria->offset = Parameters::getInt('from');
            
            // Result records number
            if (Parameters::hasParam('count'))
                $criteria->limit = Parameters::getInt('count');
        } else {
            $criteria->addCondition('r.id=:resource_id');
            $criteria->params[':resource_id'] = Parameters::getInt('rid');
        }
        
        $result = Resource::model()->with('type')->findAll($criteria);
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        $coder = ObjectCodingFactory::factory()->createObject($format);
        if ($coder != nil) {
            $response = $coder->encode($result);
            echo $response;
        }
        
        return $result;
    }
    
    public function actionPut() {
        if (!Parameters::hasParam('rtype'))
            die('ServiceController: Resource type not valid (parameter name: \'rtype\')');
        
        if (!Parameters::hasParam('robject', 'POST'))
            die('ServiceController: Have no object for put (parameter name: \'robject\', method: \'POST\')');
        
        $resource_type = Parameters::get('rtype');
        $resource_object = Parameters::get('robject', 'POST');
        $response = 'FAIL';
        
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        
        $coder = ObjectCodingFactory::factory()->createObject($format);
        $resource = $coder->decode($resource_object);
        if ($resource->save())
            $response = 'OK';
        
        return $response;
    }
    
    public function actionDelete() {
        if (!Parameters::hasParam('rid'))
            die('ServiceController: Invalid resource IDENTIFICATOR (parameter name: \'rid\')');
        
        $rid = Parameters::get('rid');
        $response = 'FAIL';
        
        if (Resource::model()->deleteByPk($rid) == 1)
            $response = 'OK';
        
        return $response;
    }
    
    public function actionSearch() {
        
    }
}