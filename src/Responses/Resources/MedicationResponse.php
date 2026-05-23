<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;

class MedicationResponse extends AbstractFhirResponse
{
    public ?string $status       = null;
    public ?string $kfaCode      = null;
    public ?string $kfaDisplay   = null;
    public ?string $formCode     = null;
    public ?string $formDisplay  = null;
    /** @var array[] */
    public array   $ingredient   = [];

    protected function mapFields(array $data): void
    {
        $this->status = $data['status'] ?? null;

        $code = $data['code']['coding'][0] ?? [];
        $this->kfaCode    = $code['code']    ?? null;
        $this->kfaDisplay = $code['display'] ?? null;

        $form = $data['form']['coding'][0] ?? [];
        $this->formCode    = $form['code']    ?? null;
        $this->formDisplay = $form['display'] ?? null;

        $this->ingredient = $data['ingredient'] ?? [];
    }
}
