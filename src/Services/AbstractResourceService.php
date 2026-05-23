<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\Http\SatusehatHttpClient;
use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Responses\BundleResponse;

abstract class AbstractResourceService
{
    public function __construct(
        protected readonly SatusehatHttpClient $client,
    ) {}

    protected function doPost(string $path, array $body, callable $mapper): AbstractFhirResponse
    {
        $data = $this->client->post($path, $body);

        return $mapper($data);
    }

    protected function doGet(string $path, array $queryParams, callable $mapper): AbstractFhirResponse
    {
        $data = $this->client->get($path, $queryParams);

        return $mapper($data);
    }

    protected function doGetBundle(string $path, array $queryParams, callable $entryMapper): BundleResponse
    {
        $data = $this->client->get($path, $queryParams);

        return BundleResponse::fromArray($data, $entryMapper);
    }

    protected function doPut(string $path, array $body, callable $mapper): AbstractFhirResponse
    {
        $data = $this->client->put($path, $body);

        return $mapper($data);
    }

    protected function doPatch(string $path, array $operations, callable $mapper): AbstractFhirResponse
    {
        $data = $this->client->patch($path, $operations);

        return $mapper($data);
    }
}
