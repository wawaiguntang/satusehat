<?php

namespace Wawaiguntang\Satusehat\DTOs\Account;

/**
 * FHIR R4 - Account.coverage
 * @see https://www.hl7.org/fhir/account-definitions.html#Account.coverage
 *
 * Relasi antara Account dan Coverage beserta prioritasnya.
 */
class AccountCoverageDTO
{
    public function __construct(
        /** @var string Referensi Coverage */
        public readonly string $coverageReference,

        /** @var int Prioritas coverage (1 = primer) */
        public readonly int $priority = 1,
    ) {}

    public function toArray(): array
    {
        return [
            'coverage' => ['reference' => $this->coverageReference],
            'priority' => $this->priority,
        ];
    }
}
