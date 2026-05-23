<?php

namespace Wawaiguntang\Satusehat\DTOs\ChargeItem;

/**
 * Query parameter untuk GET /ChargeItem
 * @see https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/ChargeItem
 */
class ChargeItemSearchQueryDTO
{
    public function __construct(
        /** @var string|null UUID Account */
        public readonly ?string $account = null,

        /** @var string|null ID pasien */
        public readonly ?string $subject = null,
    ) {}

    public function toQueryParams(): array
    {
        $params = [];

        if ($this->account !== null) {
            $params['account'] = $this->account;
        }

        if ($this->subject !== null) {
            $params['subject'] = $this->subject;
        }

        return $params;
    }
}
