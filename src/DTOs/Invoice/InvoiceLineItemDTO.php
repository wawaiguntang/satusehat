<?php

namespace Wawaiguntang\Satusehat\DTOs\Invoice;

/**
 * FHIR R4 - Invoice.lineItem
 * @see https://www.hl7.org/fhir/invoice-definitions.html#Invoice.lineItem
 *
 * Satu baris item tagihan yang mereferensikan ChargeItem.
 * Kode tindakan menggunakan KPTL SATUSEHAT: http://terminology.kemkes.go.id/CodeSystem/kptl
 * Mata uang: IDR
 */
class InvoiceLineItemDTO
{
    public function __construct(
        /** @var int Nomor urut item */
        public readonly int $sequence,

        /** @var string Referensi ChargeItem */
        public readonly string $chargeItemReference,

        /** @var string|null Kode KPTL tindakan */
        public readonly ?string $kptlCode = null,

        /** @var string|null Display tindakan */
        public readonly ?string $kptlDisplay = null,

        /** @var float|null Jumlah tagihan (IDR) */
        public readonly ?float $amount = null,

        /** @var string Tipe price component (surcharge/base/deductible/discount/tax/informational) */
        public readonly string $priceComponentType = 'surcharge',
    ) {}

    public function toArray(): array
    {
        $data = [
            'sequence'           => $this->sequence,
            'chargeItemReference' => ['reference' => $this->chargeItemReference],
        ];

        if ($this->kptlCode !== null && $this->amount !== null) {
            $priceComponent = [
                'type'   => $this->priceComponentType,
                'amount' => [
                    'value'    => $this->amount,
                    'currency' => 'IDR',
                ],
            ];
            if ($this->kptlCode !== null) {
                $priceComponent['code'] = [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.kemkes.go.id/CodeSystem/kptl',
                            'code'    => $this->kptlCode,
                            'display' => $this->kptlDisplay ?? $this->kptlCode,
                        ],
                    ],
                ];
            }
            $data['priceComponent'] = [$priceComponent];
        }

        return $data;
    }
}
