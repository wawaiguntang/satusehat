<?php

namespace Wawaiguntang\Satusehat\Responses;

class BundleResponse
{
    public readonly int     $total;
    public readonly ?string $nextLink;
    /** @var AbstractFhirResponse[] */
    public readonly array   $entries;

    /**
     * @param AbstractFhirResponse[] $entries
     */
    public function __construct(
        int     $total,
        array   $entries  = [],
        ?string $nextLink = null,
    ) {
        $this->total    = $total;
        $this->entries  = $entries;
        $this->nextLink = $nextLink;
    }

    /**
     * @return AbstractFhirResponse[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function first(): ?AbstractFhirResponse
    {
        return $this->entries[0] ?? null;
    }

    /**
     * Build from raw FHIR Bundle array, using a callable to map each entry resource to a Response object.
     *
     * @param array    $bundle      Raw FHIR Bundle array
     * @param callable $entryMapper fn(array $resource): AbstractFhirResponse
     */
    public static function fromArray(array $bundle, callable $entryMapper): self
    {
        $total   = $bundle['total'] ?? 0;
        $entries = [];

        foreach ($bundle['entry'] ?? [] as $entry) {
            $resource = $entry['resource'] ?? [];
            if ($resource) {
                $entries[] = $entryMapper($resource);
            }
        }

        $nextLink = null;
        foreach ($bundle['link'] ?? [] as $link) {
            if (($link['relation'] ?? '') === 'next') {
                $nextLink = $link['url'] ?? null;
                break;
            }
        }

        return new self($total, $entries, $nextLink);
    }
}
