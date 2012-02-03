<?php

interface AbstractDataStorage
{
    public function save($object);
    public function remove($object);
}