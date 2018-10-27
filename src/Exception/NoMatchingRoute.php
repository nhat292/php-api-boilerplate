<?php

namespace PhpApi\Exception;

class NoMatchingRoute extends \Exception
{
    protected $code = 404;
}
