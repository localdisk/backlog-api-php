<?php

use Mockery as m;

class ApiTest extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        m::close();
    }

}
