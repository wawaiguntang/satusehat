<?php

namespace Wawaiguntang\Satusehat\Responses\Resources;

use Wawaiguntang\Satusehat\Responses\AbstractFhirResponse;
use Wawaiguntang\Satusehat\Shared\Responses\ReferenceResponse;

class QuestionnaireResponseResponse extends AbstractFhirResponse
{
    public ?string            $status    = null;
    public ?ReferenceResponse $subject   = null;
    public ?ReferenceResponse $encounter = null;
    public ?string            $authored  = null;
    public ?ReferenceResponse $author    = null;
    /** @var array[] */
    public array              $item      = [];

    protected function mapFields(array $data): void
    {
        $this->status   = $data['status']   ?? null;
        $this->authored = $data['authored'] ?? null;

        if (isset($data['subject'])) {
            $this->subject = ReferenceResponse::fromArray($data['subject']);
        }

        if (isset($data['encounter'])) {
            $this->encounter = ReferenceResponse::fromArray($data['encounter']);
        }

        if (isset($data['author'])) {
            $this->author = ReferenceResponse::fromArray($data['author']);
        }

        $this->item = $data['item'] ?? [];
    }
}
