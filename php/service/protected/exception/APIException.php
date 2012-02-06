<?php

class APIException extends Exception
{
    public function getResponse($format) {
        $className = 'Unknown';
        
        $trace = $this->getTrace();
        if (count($trace) > 0) {
            $place = $trace[0];
            if (isset($place['class']))
                $className = $place['class'];
        }
        
        $response = array(
            'error'=>array(
                'code'=>$this->getCode(),
                'message'=>$this->getMessage(),
                'class'=>$className,
            ),
        );
        
        $coder = new CJSON();
        return $coder->encode($response);
    }
}