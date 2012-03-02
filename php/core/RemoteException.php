<?php

class RemoteException extends Exception
{
    public function __construct($result) {
        $message = 'RemoteService Exception';
        if (isset($result['message']))
            $message = $result['message'];
        
        $code = 0;
        if (isset($result['code']))
            $code = $result['code'];
        
        parent::__construct($message, $code);
    }
}