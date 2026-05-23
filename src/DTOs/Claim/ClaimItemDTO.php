<?php

namespace Wawaiguntang\Satusehat\DTOs\Claim;

/**
 * FHIR R4 - Claim.item
 * @see https://www.hl7.org/fhir/claim-definitions.html#Claim.item
 *
 * Kode tindakan menggunakan KPTL SATUSEHAT: http://terminology.kemkes.go.id/CodeSystem/kptl
 * Mata uang: IDR
 */
class ClaimItemDTO
{
    public function __construct(
        /** @var int Nomor urut item */
        public readonly int $sequence,

        /** @var string Kode KPTL tindakan */
        public readonly string $kptlCode,

        /** @var string Display tindakan */
        public readonly string $kptlDisplay,

        /** @var float Kuantitas */
        public readonly float $quantity,

        /** @var float|null Harga satuan (IDR) */
        public readonly ?float $unitPrice = null,

        /** @var float|null Total harga (IDR) */
        public readonly ?float $net = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'sequence'         => $this->sequence,
            'productOrService' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.kemkes.go.id/CodeSystem/kptl',
                        'code'    => $this->kptlCode,
                        'display' => $this->kptlDisplay,
                    ],
                ],
            ],
            'quantity' => ['value' => $this->quantity],
        ];

        if ($this->unitPrice !== null) {
            $data['unitPrice'] = ['value' => $this->unitPrice, 'currency' => 'IDR'];
        }

        if ($this->net !== null) {
            $data['net'] = ['value' => $this->net, 'currency' => 'IDR'];
        }

        return $data;
    }
}
