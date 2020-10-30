<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BeersTest extends WebTestCase
{
    public function testgetBeer()
    {
        $client = static::createClient();

        // response 200
        $client->request('GET', '/beer/68');

        $this->assertEquals(true, $client->getResponse()->isOk());

        //Not found
        $client->request('GET', '/beer/30000000');

        $this->assertEquals(true, $client->getResponse()->isNotFound());

        //Invalid request
        $client->request('GET', '/beer/jjdjfnfjnfdj');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
