<?php

namespace App\ThirdPartyServers\PunkApi;

use App\Entity\Beer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    public function getBeerById(int $id):Beer
    {
        $request = $this->prepareRequest('GET', "/beers/$id");
        $response = $this->client->send($request);
        $beers = $this->deserializeResponse($response);
        return current($beers);
    }

    /**
     * @param array $queryParams
     * @return mixed
     * @throws GuzzleException
     */
    public function listBeers(array $queryParams = [])
    {

        $request = $this->prepareRequest('GET', "/beers");
        $response = $this->client->send($request, ['query' => $queryParams]);
        return $this->deserializeResponse($response);
    }

    private function deserializeResponse(ResponseInterface $response): array
    {
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(
                null,
                new CamelCaseToSnakeCaseNameConverter()),
                new ArrayDenormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->deserialize(
            $response->getBody()->getContents(),
            'App\Entity\Beer[]', 'json'
        );
    }
}
