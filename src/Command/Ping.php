<?php

namespace PhpApi\Command;

class Ping extends BaseCommand
{
    public function execute()
    {
        return 'Welcome to a Pure PHP API!';
    }
}
