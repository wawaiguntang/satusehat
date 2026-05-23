<?php

namespace Wawaiguntang\Satusehat\Tests;

use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Wawaiguntang\Satusehat\SatusehatClient;
use Wawaiguntang\Satusehat\Services\AccountService;
use Wawaiguntang\Satusehat\Services\AllergyIntoleranceService;
use Wawaiguntang\Satusehat\Services\CarePlanService;
use Wawaiguntang\Satusehat\Services\ChargeItemService;
use Wawaiguntang\Satusehat\Services\ClaimResponseService;
use Wawaiguntang\Satusehat\Services\ClaimService;
use Wawaiguntang\Satusehat\Services\ClinicalImpressionService;
use Wawaiguntang\Satusehat\Services\CompositionService;
use Wawaiguntang\Satusehat\Services\ConditionService;
use Wawaiguntang\Satusehat\Services\CoverageEligibilityRequestService;
use Wawaiguntang\Satusehat\Services\CoverageEligibilityResponseService;
use Wawaiguntang\Satusehat\Services\CoverageService;
use Wawaiguntang\Satusehat\Services\DiagnosticReportService;
use Wawaiguntang\Satusehat\Services\EncounterService;
use Wawaiguntang\Satusehat\Services\EpisodeOfCareService;
use Wawaiguntang\Satusehat\Services\ImagingStudyService;
use Wawaiguntang\Satusehat\Services\ImmunizationService;
use Wawaiguntang\Satusehat\Services\InvoiceService;
use Wawaiguntang\Satusehat\Services\LocationService;
use Wawaiguntang\Satusehat\Services\MedicationDispenseService;
use Wawaiguntang\Satusehat\Services\MedicationRequestService;
use Wawaiguntang\Satusehat\Services\MedicationService;
use Wawaiguntang\Satusehat\Services\ObservationService;
use Wawaiguntang\Satusehat\Services\OrganizationService;
use Wawaiguntang\Satusehat\Services\PatientService;
use Wawaiguntang\Satusehat\Services\PaymentNoticeService;
use Wawaiguntang\Satusehat\Services\PaymentReconciliationService;
use Wawaiguntang\Satusehat\Services\PractitionerService;
use Wawaiguntang\Satusehat\Services\ProcedureService;
use Wawaiguntang\Satusehat\Services\QuestionnaireResponseService;
use Wawaiguntang\Satusehat\Services\RelatedPersonService;
use Wawaiguntang\Satusehat\Services\ServiceRequestService;
use Wawaiguntang\Satusehat\Services\SpecimenService;
use Wawaiguntang\Satusehat\Tests\Support\ArrayCache;

class SatusehatClientTest extends TestCase
{
    private SatusehatClient $client;

    protected function setUp(): void
    {
        $factory      = new Psr17Factory();
        $this->client = new SatusehatClient(
            clientId:       'test-id',
            clientSecret:   'test-secret',
            httpClient:     new MockClient(),
            requestFactory: $factory,
            streamFactory:  $factory,
            cache:          new ArrayCache(),
        );
    }

    public function test_patient_returns_patient_service(): void
    {
        $this->assertInstanceOf(PatientService::class, $this->client->patient());
    }

    public function test_practitioner_returns_practitioner_service(): void
    {
        $this->assertInstanceOf(PractitionerService::class, $this->client->practitioner());
    }

    public function test_organization_returns_organization_service(): void
    {
        $this->assertInstanceOf(OrganizationService::class, $this->client->organization());
    }

    public function test_location_returns_location_service(): void
    {
        $this->assertInstanceOf(LocationService::class, $this->client->location());
    }

    public function test_encounter_returns_encounter_service(): void
    {
        $this->assertInstanceOf(EncounterService::class, $this->client->encounter());
    }

    public function test_condition_returns_condition_service(): void
    {
        $this->assertInstanceOf(ConditionService::class, $this->client->condition());
    }

    public function test_observation_returns_observation_service(): void
    {
        $this->assertInstanceOf(ObservationService::class, $this->client->observation());
    }

    public function test_composition_returns_composition_service(): void
    {
        $this->assertInstanceOf(CompositionService::class, $this->client->composition());
    }

    public function test_procedure_returns_procedure_service(): void
    {
        $this->assertInstanceOf(ProcedureService::class, $this->client->procedure());
    }

    public function test_allergy_intolerance_returns_allergy_intolerance_service(): void
    {
        $this->assertInstanceOf(AllergyIntoleranceService::class, $this->client->allergyIntolerance());
    }

    public function test_clinical_impression_returns_clinical_impression_service(): void
    {
        $this->assertInstanceOf(ClinicalImpressionService::class, $this->client->clinicalImpression());
    }

    public function test_imaging_study_returns_imaging_study_service(): void
    {
        $this->assertInstanceOf(ImagingStudyService::class, $this->client->imagingStudy());
    }

    public function test_immunization_returns_immunization_service(): void
    {
        $this->assertInstanceOf(ImmunizationService::class, $this->client->immunization());
    }

    public function test_medication_returns_medication_service(): void
    {
        $this->assertInstanceOf(MedicationService::class, $this->client->medication());
    }

    public function test_medication_request_returns_medication_request_service(): void
    {
        $this->assertInstanceOf(MedicationRequestService::class, $this->client->medicationRequest());
    }

    public function test_medication_dispense_returns_medication_dispense_service(): void
    {
        $this->assertInstanceOf(MedicationDispenseService::class, $this->client->medicationDispense());
    }

    public function test_diagnostic_report_returns_diagnostic_report_service(): void
    {
        $this->assertInstanceOf(DiagnosticReportService::class, $this->client->diagnosticReport());
    }

    public function test_episode_of_care_returns_episode_of_care_service(): void
    {
        $this->assertInstanceOf(EpisodeOfCareService::class, $this->client->episodeOfCare());
    }

    public function test_care_plan_returns_care_plan_service(): void
    {
        $this->assertInstanceOf(CarePlanService::class, $this->client->carePlan());
    }

    public function test_questionnaire_response_returns_questionnaire_response_service(): void
    {
        $this->assertInstanceOf(QuestionnaireResponseService::class, $this->client->questionnaireResponse());
    }

    public function test_service_request_returns_service_request_service(): void
    {
        $this->assertInstanceOf(ServiceRequestService::class, $this->client->serviceRequest());
    }

    public function test_specimen_returns_specimen_service(): void
    {
        $this->assertInstanceOf(SpecimenService::class, $this->client->specimen());
    }

    public function test_related_person_returns_related_person_service(): void
    {
        $this->assertInstanceOf(RelatedPersonService::class, $this->client->relatedPerson());
    }

    public function test_coverage_returns_coverage_service(): void
    {
        $this->assertInstanceOf(CoverageService::class, $this->client->coverage());
    }

    public function test_coverage_eligibility_request_returns_correct_service(): void
    {
        $this->assertInstanceOf(CoverageEligibilityRequestService::class, $this->client->coverageEligibilityRequest());
    }

    public function test_coverage_eligibility_response_returns_correct_service(): void
    {
        $this->assertInstanceOf(CoverageEligibilityResponseService::class, $this->client->coverageEligibilityResponse());
    }

    public function test_account_returns_account_service(): void
    {
        $this->assertInstanceOf(AccountService::class, $this->client->account());
    }

    public function test_charge_item_returns_charge_item_service(): void
    {
        $this->assertInstanceOf(ChargeItemService::class, $this->client->chargeItem());
    }

    public function test_invoice_returns_invoice_service(): void
    {
        $this->assertInstanceOf(InvoiceService::class, $this->client->invoice());
    }

    public function test_claim_returns_claim_service(): void
    {
        $this->assertInstanceOf(ClaimService::class, $this->client->claim());
    }

    public function test_claim_response_returns_claim_response_service(): void
    {
        $this->assertInstanceOf(ClaimResponseService::class, $this->client->claimResponse());
    }

    public function test_payment_reconciliation_returns_correct_service(): void
    {
        $this->assertInstanceOf(PaymentReconciliationService::class, $this->client->paymentReconciliation());
    }

    public function test_payment_notice_returns_payment_notice_service(): void
    {
        $this->assertInstanceOf(PaymentNoticeService::class, $this->client->paymentNotice());
    }

    public function test_lazy_getter_returns_same_instance(): void
    {
        $first  = $this->client->patient();
        $second = $this->client->patient();

        $this->assertSame($first, $second);
    }
}
