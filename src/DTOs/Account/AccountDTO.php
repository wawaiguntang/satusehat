<?php

namespace Wawaiguntang\Satusehat\DTOs\Account;

use Wawaiguntang\Satusehat\Enums\Account\AccountStatusEnum;

/**
 * FHIR R4 - Account Resource
 * StructureDefinition: https://fhir.kemkes.go.id/r4/StructureDefinition/Account
 *
 * Merepresentasikan akun billing pasien yang menghubungkan patient, coverage, dan charge items.
 *
 * Operasi yang didukung:
 *  - POST  /Account           → create
 *  - GET   /Account/:id       → by ID
 *  - GET   /Account?subject=  → search by patient ID
 *
 * Field type.coding.system: "http://terminology.hl7.org/CodeSystem/v3-ActCode"
 * Contoh kode type: PBILLACCT (patient billing account)
 */
class AccountDTO
{
    public readonly string $resourceType;

    public function __construct(
        /** @var AccountStatusEnum Status akun */
        public readonly AccountStatusEnum $status,

        /** @var string Kode v3-ActCode tipe akun (contoh: "PBILLACCT") */
        public readonly string $typeCode,

        /** @var string Display tipe akun (contoh: "patient billing account") */
        public readonly string $typeDisplay,

        /** @var string Nama akun */
        public readonly string $name,

        /** @var string Referensi Organization pemilik akun */
        public readonly string $ownerReference,

        /** @var string Datetime mulai periode layanan (ISO 8601 + timezone) */
        public readonly string $servicePeriodStart,

        /** @var string Datetime akhir periode layanan (ISO 8601 + timezone) */
        public readonly string $servicePeriodEnd,

        /** @var string|null ID unik Account di SATUSEHAT */
        public readonly ?string $id = null,

        /**
         * @var array[]|null Subjek akun (Patient)
         * Struktur: [['reference' => string, 'display' => string|null], ...]
         */
        public readonly ?array $subject = null,

        /** @var AccountCoverageDTO[]|null Coverage yang terkait dengan akun */
        public readonly ?array $coverage = null,

        /** @var string|null Deskripsi akun */
        public readonly ?string $description = null,

        /** @var string|null Teks tipe akun */
        public readonly ?string $typeText = null,
    ) {
        $this->resourceType = 'Account';
    }

    public function toArray(): array
    {
        $type = [
            'coding' => [
                [
                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                    'code'    => $this->typeCode,
                    'display' => $this->typeDisplay,
                ],
            ],
        ];
        if ($this->typeText !== null) {
            $type['text'] = $this->typeText;
        }

        $data = [
            'resourceType'  => $this->resourceType,
            'status'        => $this->status->value,
            'type'          => $type,
            'name'          => $this->name,
            'servicePeriod' => [
                'start' => $this->servicePeriodStart,
                'end'   => $this->servicePeriodEnd,
            ],
            'owner'         => ['reference' => $this->ownerReference],
        ];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }

        if ($this->subject !== null) {
            $data['subject'] = array_map(function ($s) {
                $item = ['reference' => $s['reference']];
                if (!empty($s['display'])) {
                    $item['display'] = $s['display'];
                }
                return $item;
            }, $this->subject);
        }

        if ($this->coverage !== null) {
            $data['coverage'] = array_map(fn($c) => $c->toArray(), $this->coverage);
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        return $data;
    }
}
