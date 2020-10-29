<?php

namespace App\Tests\ThirdPartyServers\PunkApi;

use App\Entity\Beer;
use App\ThirdPartyServers\PunkApi\PunkApiClient;
use App\ThirdPartyServers\PunkApi\PunkApiConfiguration;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class PunkApiClientTest extends TestCase
{
    public function testGetBeerById()
    {

        $clientProphecy = $this->prophesize(Client::class);
        $configProphecy = $this->prophesize(PunkApiConfiguration::class);
        $responseProphecy = $this->prophesize(ResponseInterface::class);
        $streamProphecy = $this->prophesize(StreamInterface::class);

        $configProphecy->getApiUrl()->willReturn('url');

        $streamProphecy->getContents()->willReturn('{ "id": 192,
                "name": "Punk IPA 2007 - 2010",
                "tagline": "Post Modern Classic. Spiky. Tropical. Hoppy.",
                "first_brewed": "04/2007"}'
        );

        $responseProphecy->getBody()->willReturn($streamProphecy->reveal());

        $clientProphecy->send(Argument::any())->willReturn($responseProphecy->reveal());

        $punkApiClient = new PunkApiClient(
            $clientProphecy->reveal(),
            $configProphecy->reveal()
        );
        $beer = new Beer();
        $this->assertEquals(
            $beer,
            $punkApiClient->getBeerById(192)
        );
    }
}
