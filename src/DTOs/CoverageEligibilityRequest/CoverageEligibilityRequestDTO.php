<?php

namespace Wawaiguntang\Satusehat\DTOs\CoverageEligibilityRequest;

class CoverageEligibilityRequestDTO
{
    public function __construct(
        public readonly ?string $id              = null,
        public readonly string  $resourceType    = 'CoverageEligibilityRequest',
        public readonly ?string $metaProfile     = null,
        public readonly ?string $status          = null,
        public readonly ?string $purpose         = null,
        public readonly ?string $patientReference = null,
        public readonly ?string $servicedDate    = null,
        public readonly ?string $created         = null,
        public readonly ?string $insurerReference = null,
        public readonly array   $insurance       = [],
        public readonly array   $identifier      = [],
        public readonly array   $supportingInfo  = [],
        public readonly array   $item            = [],
    ) {}

    public function toArray(): array
    {
        $data = ['resourceType' => $this->resourceType];

        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        if ($this->metaProfile !== null) {
            $data['meta'] = ['profile' => [$this->metaProfile]];
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        if ($this->purpose !== null) {
            $data['purpose'] = [$this->purpose];
        }
        if ($this->patientReference !== null) {
            $data['patient'] = ['reference' => $this->patientReference];
        }
        if ($this->servicedDate !== null) {
            $data['servicedDate'] = $this->servicedDate;
        }
        if ($this->created !== null) {
            $data['created'] = $this->created;
        }
        if ($this->insurerReference !== null) {
            $data['insurer'] = ['reference' => $this->insurerReference];
        }
        if (!empty($this->insurance)) {
            $data['insurance'] = $this->insurance;
        }
        if (!empty($this->identifier)) {
            $data['identifier'] = $this->identifier;
        }
        if (!empty($this->item)) {
            $data['item'] = $this->item;
        }

        return $data;
    }
}
