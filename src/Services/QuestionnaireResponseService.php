<?php

namespace Wawaiguntang\Satusehat\Services;

use Wawaiguntang\Satusehat\DTOs\QuestionnaireResponse\QuestionnaireResponseDTO;
use Wawaiguntang\Satusehat\Responses\BundleResponse;
use Wawaiguntang\Satusehat\Responses\Resources\QuestionnaireResponseResponse;

class QuestionnaireResponseService extends AbstractResourceService
{
    public function create(QuestionnaireResponseDTO $dto): QuestionnaireResponseResponse
    {
        /** @var QuestionnaireResponseResponse */
        return $this->doPost('/QuestionnaireResponse', $dto->toArray(), fn(array $d) => QuestionnaireResponseResponse::fromArray($d));
    }

    public function getById(string $id): QuestionnaireResponseResponse
    {
        /** @var QuestionnaireResponseResponse */
        return $this->doGet("/QuestionnaireResponse/{$id}", [], fn(array $d) => QuestionnaireResponseResponse::fromArray($d));
    }

    public function searchByPatient(string $patientId): BundleResponse
    {
        return $this->doGetBundle('/QuestionnaireResponse', ['subject' => $patientId], fn(array $d) => QuestionnaireResponseResponse::fromArray($d));
    }

    public function update(string $id, QuestionnaireResponseDTO $dto): QuestionnaireResponseResponse
    {
        /** @var QuestionnaireResponseResponse */
        return $this->doPut("/QuestionnaireResponse/{$id}", $dto->toArray(), fn(array $d) => QuestionnaireResponseResponse::fromArray($d));
    }
}
