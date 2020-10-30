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

    public function testGetBeersFoodMatchs()
    {
        $client = static::createClient();

        // response 200
        $client->request('GET',
            '/beer/match',
            ['food' => 'Beef']);

        $this->assertEquals(true, $client->getResponse()->isOk());

        $client->request('GET',
            '/beer/match',
            ['food' => 'Beef', 'page' => 1, 'per_page' => 25]);

        $this->assertEquals(true, $client->getResponse()->isOk());

        $client->request('GET',
            '/beer/match',
            ['food' => 'Beef', 'page' => 'uu', 'string' => 'string']);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        //Not found
        $client->request('GET',
            '/beer/match',
            ['food' => '999op']);

        $this->assertEquals(true, $client->getResponse()->isNotFound());
    }
}
