<?php

namespace Wawaiguntang\Satusehat\Tests\Responses;

use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\Responses\Resources\AccountResponse;
use Wawaiguntang\Satusehat\Responses\Resources\AllergyIntoleranceResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CarePlanResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ChargeItemResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ClaimResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ClaimResponseResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ClinicalImpressionResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CompositionResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ConditionResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageEligibilityRequestResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageEligibilityResponseResponse;
use Wawaiguntang\Satusehat\Responses\Resources\CoverageResponse;
use Wawaiguntang\Satusehat\Responses\Resources\DiagnosticReportResponse;
use Wawaiguntang\Satusehat\Responses\Resources\EncounterResponse;
use Wawaiguntang\Satusehat\Responses\Resources\EpisodeOfCareResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ImagingStudyResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ImmunizationResponse;
use Wawaiguntang\Satusehat\Responses\Resources\InvoiceResponse;
use Wawaiguntang\Satusehat\Responses\Resources\LocationResponse;
use Wawaiguntang\Satusehat\Responses\Resources\MedicationDispenseResponse;
use Wawaiguntang\Satusehat\Responses\Resources\MedicationRequestResponse;
use Wawaiguntang\Satusehat\Responses\Resources\MedicationResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ObservationResponse;
use Wawaiguntang\Satusehat\Responses\Resources\OrganizationResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PatientResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PaymentNoticeResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PaymentReconciliationResponse;
use Wawaiguntang\Satusehat\Responses\Resources\PractitionerResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ProcedureResponse;
use Wawaiguntang\Satusehat\Responses\Resources\QuestionnaireResponseResponse;
use Wawaiguntang\Satusehat\Responses\Resources\RelatedPersonResponse;
use Wawaiguntang\Satusehat\Responses\Resources\ServiceRequestResponse;
use Wawaiguntang\Satusehat\Responses\Resources\SpecimenResponse;

class ResourceResponseNullSafetyTest extends TestCase
{
    /**
     * @dataProvider allResponseClasses
     */
    public function test_from_array_with_empty_data_does_not_throw(string $class): void
    {
        $response = $class::fromArray([]);
        $this->assertNull($response->id);
        $this->assertSame('', $response->resourceType);
    }

    /**
     * @dataProvider allResponseClasses
     */
    public function test_from_array_with_minimal_meta_does_not_throw(string $class): void
    {
        $response = $class::fromArray([
            'resourceType' => 'TestResource',
            'id'           => 'test-001',
            'meta'         => ['versionId' => '1', 'lastUpdated' => '2024-01-01T00:00:00Z'],
        ]);
        $this->assertSame('test-001', $response->id);
        $this->assertSame('1', $response->versionId);
    }

    public static function allResponseClasses(): array
    {
        return [
            'AccountResponse'                    => [AccountResponse::class],
            'AllergyIntoleranceResponse'         => [AllergyIntoleranceResponse::class],
            'CarePlanResponse'                   => [CarePlanResponse::class],
            'ChargeItemResponse'                 => [ChargeItemResponse::class],
            'ClaimResponse'                      => [ClaimResponse::class],
            'ClaimResponseResponse'              => [ClaimResponseResponse::class],
            'ClinicalImpressionResponse'         => [ClinicalImpressionResponse::class],
            'CompositionResponse'                => [CompositionResponse::class],
            'ConditionResponse'                  => [ConditionResponse::class],
            'CoverageEligibilityRequestResponse' => [CoverageEligibilityRequestResponse::class],
            'CoverageEligibilityResponseResponse'=> [CoverageEligibilityResponseResponse::class],
            'CoverageResponse'                   => [CoverageResponse::class],
            'DiagnosticReportResponse'           => [DiagnosticReportResponse::class],
            'EncounterResponse'                  => [EncounterResponse::class],
            'EpisodeOfCareResponse'              => [EpisodeOfCareResponse::class],
            'ImagingStudyResponse'               => [ImagingStudyResponse::class],
            'ImmunizationResponse'               => [ImmunizationResponse::class],
            'InvoiceResponse'                    => [InvoiceResponse::class],
            'LocationResponse'                   => [LocationResponse::class],
            'MedicationDispenseResponse'         => [MedicationDispenseResponse::class],
            'MedicationRequestResponse'          => [MedicationRequestResponse::class],
            'MedicationResponse'                 => [MedicationResponse::class],
            'ObservationResponse'                => [ObservationResponse::class],
            'OrganizationResponse'               => [OrganizationResponse::class],
            'PatientResponse'                    => [PatientResponse::class],
            'PaymentNoticeResponse'              => [PaymentNoticeResponse::class],
            'PaymentReconciliationResponse'      => [PaymentReconciliationResponse::class],
            'PractitionerResponse'               => [PractitionerResponse::class],
            'ProcedureResponse'                  => [ProcedureResponse::class],
            'QuestionnaireResponseResponse'      => [QuestionnaireResponseResponse::class],
            'RelatedPersonResponse'              => [RelatedPersonResponse::class],
            'ServiceRequestResponse'             => [ServiceRequestResponse::class],
            'SpecimenResponse'                   => [SpecimenResponse::class],
        ];
    }
}
