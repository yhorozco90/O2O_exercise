<?php

namespace App\Tests\ThirdPartyServers\PunkApi;

use App\ThirdPartyServers\PunkApi\PunkApiConfiguration;
use PHPUnit\Framework\TestCase;

class PunkApiConfigurationTest extends TestCase
{
    public function testGetBaseUri()
    {
        $configuration = new PunkApiConfiguration(
            'apiUrl',
            'apiVersion'

        );

        $this->assertEquals('apiUrl', $configuration->getBaseUri());
    }

    public function testGetApiVersion()
    {
        $configuration = new PunkApiConfiguration(
            'apiUrl',
            'apiVersion'

        );

        $this->assertEquals('apiVersion', $configuration->getApiVersion());
    }

    public function testGetApiUrl()
    {
        $configuration = new PunkApiConfiguration(
            'apiUrl',
            'apiVersion'

        );

        $this->assertEquals('apiUrl/apiVersion', $configuration->getApiUrl());
    }

}
