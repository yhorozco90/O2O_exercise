<?php

namespace App\ThirdPartyServers\PunkApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class PunkApiClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var PunkApiConfiguration
     */
    private $config;

    /**
     * @param string $method
     * @param string $path
     * @return RequestInterface
     */
    protected function prepareRequest(
        string $method,
        string $path
    ): RequestInterface
    {
        return new Request($method, $this->config->getApiUrl() . $path);

    }

    /**
     * @param Client $client
     * @param PunkApiConfiguration $config
     */
    public function __construct(Client $client, PunkApiConfiguration $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }


    /**
     * @param string $id
     * @return mixed
     * @throws GuzzleException
     */
    public function getBeerById(string $id)
    {
        $request = $this->prepareRequest('GET', "/beers/$id");
        $response = $this->client->send($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param array $queryParams
     * @return mixed
     * @throws GuzzleException
     */
    public function listBeers(array $queryParams=[])
    {

        $request = $this->prepareRequest('GET', "/beers");
        $response = $this->client->send($request,['query'=>$queryParams]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
