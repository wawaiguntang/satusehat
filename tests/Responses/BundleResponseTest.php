<?php

namespace Wawaiguntang\Satusehat\Tests\Responses;

use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\EncounterResponse;

class BundleResponseTest extends TestCase
{
    private function makeBundleData(): array
    {
        return [
            'resourceType' => 'Bundle',
            'total'        => 2,
            'link'         => [
                ['relation' => 'self', 'url' => 'https://example.com/Encounter?subject=P001'],
                ['relation' => 'next', 'url' => 'https://example.com/Encounter?subject=P001&page=2'],
            ],
            'entry' => [
                ['resource' => ['resourceType' => 'Encounter', 'id' => 'enc-001', 'status' => 'finished']],
                ['resource' => ['resourceType' => 'Encounter', 'id' => 'enc-002', 'status' => 'arrived']],
            ],
        ];
    }

    public function test_parses_total_and_entries(): void
    {
        $bundle = BundleResponse::fromArray(
            $this->makeBundleData(),
            fn(array $d) => EncounterResponse::fromArray($d),
        );

        $this->assertSame(2, $bundle->total);
        $this->assertCount(2, $bundle->getEntries());
    }

    public function test_parses_next_link(): void
    {
        $bundle = BundleResponse::fromArray(
            $this->makeBundleData(),
            fn(array $d) => EncounterResponse::fromArray($d),
        );

        $this->assertSame('https://example.com/Encounter?subject=P001&page=2', $bundle->nextLink);
    }

    public function test_first_returns_first_entry(): void
    {
        $bundle = BundleResponse::fromArray(
            $this->makeBundleData(),
            fn(array $d) => EncounterResponse::fromArray($d),
        );

        $first = $bundle->first();
        $this->assertInstanceOf(EncounterResponse::class, $first);
        $this->assertSame('enc-001', $first->id);
    }

    public function test_first_returns_null_on_empty_bundle(): void
    {
        $bundle = BundleResponse::fromArray(
            ['resourceType' => 'Bundle', 'total' => 0, 'entry' => []],
            fn(array $d) => EncounterResponse::fromArray($d),
        );

        $this->assertNull($bundle->first());
    }

    public function test_no_next_link_when_absent(): void
    {
        $data   = $this->makeBundleData();
        $data['link'] = [['relation' => 'self', 'url' => 'https://example.com/Encounter']];

        $bundle = BundleResponse::fromArray($data, fn(array $d) => EncounterResponse::fromArray($d));

        $this->assertNull($bundle->nextLink);
    }
}
