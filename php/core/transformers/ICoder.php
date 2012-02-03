<?php

interface ICoder
{
    public function encode($object);
    
    public function decode($data);
}