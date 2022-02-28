<?php

namespace Payright\Tests;
use Mockery as m;
use PHPUnit\Framework\TestCase as PHPUnit;

class TestCase extends PHPUnit
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function getApiKey(): string
    {
        return 'DDFxDSyqgbZFBTJ13nfTljjAi4a96DH8fSxxyCgN';
    }

}
