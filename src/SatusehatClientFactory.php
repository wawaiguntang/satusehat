<?php

namespace Wawaiguntang\Satusehat;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\SimpleCache\CacheInterface;

class SatusehatClientFactory
{
    public static function create(
        string                   $clientId,
        string                   $clientSecret,
        CacheInterface           $cache,
        string                   $baseUrl        = 'https://api-satusehat.kemkes.go.id/fhir-r4/v1',
        string                   $authUrl        = 'https://api-satusehat.kemkes.go.id/oauth2/v1',
        ?ClientInterface         $httpClient     = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface  $streamFactory  = null,
    ): SatusehatClient {
        return new SatusehatClient(
            clientId:       $clientId,
            clientSecret:   $clientSecret,
            httpClient:     $httpClient     ?? Psr18ClientDiscovery::find(),
            requestFactory: $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory:  $streamFactory  ?? Psr17FactoryDiscovery::findStreamFactory(),
            cache:          $cache,
            baseUrl:        $baseUrl,
            authUrl:        $authUrl,
        );
    }
}
