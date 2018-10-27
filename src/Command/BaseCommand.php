<?php

namespace PhpApi\Command;

use PhpApi\Database\PDODatabase;

abstract class BaseCommand 
{
    public $database = null;

    public function __construct() {
        $database = new PDODatabase();
    }

    abstract public function execute(); 
}