<?php

class CashApiTest extends PHPUnit_Framework_TestCase
{

    public function testEmptyConstructor()
    {
        $api = new \Vdbf\Components\Cashweb\CashApi();

        $this->assertNull($api->getService());
        $this->assertNull($api->getAdministration());
    }

}