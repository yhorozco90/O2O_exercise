<?php

namespace App\ThirdPartyServers\PunkApi;


class PunkApiConfiguration
{

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @param string $apiUrl
     * @param string $apiVersion
     */
    public function __construct(
        string $apiUrl,
        string $apiVersion
    )
    {
        $this->apiUrl = $apiUrl;
        $this->apiVersion = $apiVersion;
    }


    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->getBaseUri() . '/' . $this->getApiVersion();
    }

    /**
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->apiUrl;
    }
}
