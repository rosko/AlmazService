<?php

interface ICoder {
    public function encodeWithCoder($coder);
    
    public function decodeWithCoder($coder, $value);
}