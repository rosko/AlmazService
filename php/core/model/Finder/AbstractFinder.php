<?php

interface AbstractFinder
{
    public function findAll();
    public function findById($id);
    public function findWithOptions($options);
}
