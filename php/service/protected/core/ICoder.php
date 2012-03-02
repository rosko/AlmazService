<?php

interface ICoder1 {
    public function encodeWithCoder($coder);
    
    public function decodeWithCoder($coder, $value);
}