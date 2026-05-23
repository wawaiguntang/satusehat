<?php

namespace Wawaiguntang\Satusehat\Shared\DTOs;

/**
 * FHIR R4 - JSON Patch Operation
 * Standard: RFC 6902 (JSON Patch)
 * @see https://www.rfc-editor.org/rfc/rfc6902
 *
 * Digunakan oleh: Patient PATCH, Practitioner PATCH, dan resource FHIR lainnya.
 *
 * SATUSEHAT mewajibkan setiap field yang di-replace harus disertai
 * operasi 'test' terlebih dahulu (validasi nilai saat ini).
 */
class PatchOperationDTO
{
    public function __construct(
        /** @var string Operasi: 'test' | 'replace' | 'add' | 'remove' */
        public readonly string $op,

        /** @var string Path field FHIR (contoh: '/name', '/gender', '/birthDate') */
        public readonly string $path,

        /** @var mixed Nilai baru atau nilai yang di-test */
        public readonly mixed $value,
    ) {}

    public function toArray(): array
    {
        return [
            'op'    => $this->op,
            'path'  => $this->path,
            'value' => $this->value,
        ];
    }
}
