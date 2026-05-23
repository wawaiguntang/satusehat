<?php

namespace Wawaiguntang\Satusehat\Responses;

abstract class AbstractFhirResponse
{
    public readonly ?string $id;
    public readonly string  $resourceType;
    public readonly ?string $versionId;
    public readonly ?string $lastUpdated;
    public readonly array   $raw;

    public function __construct(array $data)
    {
        $this->raw          = $data;
        $this->id           = $data['id']                         ?? null;
        $this->resourceType = $data['resourceType']               ?? '';
        $this->versionId    = $data['meta']['versionId']          ?? null;
        $this->lastUpdated  = $data['meta']['lastUpdated']        ?? null;

        $this->mapFields($data);
    }

    abstract protected function mapFields(array $data): void;

    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
