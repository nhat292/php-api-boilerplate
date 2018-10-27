<?php

namespace PhpApi\Exception;

class DependencyNotFound extends \Exception
{
    protected $code = 503;
}
