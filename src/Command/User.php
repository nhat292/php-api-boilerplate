<?php

namespace PhpApi\Command;

class User extends BaseCommand 
{
    
    public function execute() {
        return $database->query("SELECT * FROM `users`")->$database->resultSet();
    }

}