<?php

namespace Wawaiguntang\Satusehat;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\SimpleCache\CacheInterface;
use Wawaiguntang\Satusehat\Auth\SatusehatAuthenticator;
use Wawaiguntang\Satusehat\Http\SatusehatHttpClient;
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

class SatusehatClient
{
    private readonly SatusehatHttpClient $httpClient;

    private ?PatientService                      $patientService                      = null;
    private ?PractitionerService                 $practitionerService                 = null;
    private ?OrganizationService                 $organizationService                 = null;
    private ?LocationService                     $locationService                     = null;
    private ?EncounterService                    $encounterService                    = null;
    private ?ConditionService                    $conditionService                    = null;
    private ?ObservationService                  $observationService                  = null;
    private ?CompositionService                  $compositionService                  = null;
    private ?ProcedureService                    $procedureService                    = null;
    private ?AllergyIntoleranceService           $allergyIntoleranceService           = null;
    private ?ClinicalImpressionService           $clinicalImpressionService           = null;
    private ?ImagingStudyService                 $imagingStudyService                 = null;
    private ?ImmunizationService                 $immunizationService                 = null;
    private ?MedicationService                   $medicationService                   = null;
    private ?MedicationRequestService            $medicationRequestService            = null;
    private ?MedicationDispenseService           $medicationDispenseService           = null;
    private ?DiagnosticReportService             $diagnosticReportService             = null;
    private ?EpisodeOfCareService                $episodeOfCareService                = null;
    private ?CarePlanService                     $carePlanService                     = null;
    private ?QuestionnaireResponseService        $questionnaireResponseService        = null;
    private ?ServiceRequestService               $serviceRequestService               = null;
    private ?SpecimenService                     $specimenService                     = null;
    private ?RelatedPersonService                $relatedPersonService                = null;
    private ?CoverageService                     $coverageService                     = null;
    private ?CoverageEligibilityRequestService   $coverageEligibilityRequestService   = null;
    private ?CoverageEligibilityResponseService  $coverageEligibilityResponseService  = null;
    private ?AccountService                      $accountService                      = null;
    private ?ChargeItemService                   $chargeItemService                   = null;
    private ?InvoiceService                      $invoiceService                      = null;
    private ?ClaimService                        $claimService                        = null;
    private ?ClaimResponseService                $claimResponseService                = null;
    private ?PaymentReconciliationService        $paymentReconciliationService        = null;
    private ?PaymentNoticeService                $paymentNoticeService                = null;

    public function __construct(
        string                   $clientId,
        string                   $clientSecret,
        ClientInterface          $httpClient,
        RequestFactoryInterface  $requestFactory,
        StreamFactoryInterface   $streamFactory,
        CacheInterface           $cache,
        string                   $baseUrl = 'https://api-satusehat.kemkes.go.id/fhir-r4/v1',
        string                   $authUrl = 'https://api-satusehat.kemkes.go.id/oauth2/v1',
    ) {
        $authenticator    = new SatusehatAuthenticator(
            $clientId,
            $clientSecret,
            $authUrl,
            $httpClient,
            $requestFactory,
            $streamFactory,
            $cache,
        );

        $this->httpClient = new SatusehatHttpClient(
            $baseUrl,
            $httpClient,
            $requestFactory,
            $streamFactory,
            $authenticator,
        );
    }

    public function patient(): PatientService
    {
        return $this->patientService ??= new PatientService($this->httpClient);
    }

    public function practitioner(): PractitionerService
    {
        return $this->practitionerService ??= new PractitionerService($this->httpClient);
    }

    public function organization(): OrganizationService
    {
        return $this->organizationService ??= new OrganizationService($this->httpClient);
    }

    public function location(): LocationService
    {
        return $this->locationService ??= new LocationService($this->httpClient);
    }

    public function encounter(): EncounterService
    {
        return $this->encounterService ??= new EncounterService($this->httpClient);
    }

    public function condition(): ConditionService
    {
        return $this->conditionService ??= new ConditionService($this->httpClient);
    }

    public function observation(): ObservationService
    {
        return $this->observationService ??= new ObservationService($this->httpClient);
    }

    public function composition(): CompositionService
    {
        return $this->compositionService ??= new CompositionService($this->httpClient);
    }

    public function procedure(): ProcedureService
    {
        return $this->procedureService ??= new ProcedureService($this->httpClient);
    }

    public function allergyIntolerance(): AllergyIntoleranceService
    {
        return $this->allergyIntoleranceService ??= new AllergyIntoleranceService($this->httpClient);
    }

    public function clinicalImpression(): ClinicalImpressionService
    {
        return $this->clinicalImpressionService ??= new ClinicalImpressionService($this->httpClient);
    }

    public function imagingStudy(): ImagingStudyService
    {
        return $this->imagingStudyService ??= new ImagingStudyService($this->httpClient);
    }

    public function immunization(): ImmunizationService
    {
        return $this->immunizationService ??= new ImmunizationService($this->httpClient);
    }

    public function medication(): MedicationService
    {
        return $this->medicationService ??= new MedicationService($this->httpClient);
    }

    public function medicationRequest(): MedicationRequestService
    {
        return $this->medicationRequestService ??= new MedicationRequestService($this->httpClient);
    }

    public function medicationDispense(): MedicationDispenseService
    {
        return $this->medicationDispenseService ??= new MedicationDispenseService($this->httpClient);
    }

    public function diagnosticReport(): DiagnosticReportService
    {
        return $this->diagnosticReportService ??= new DiagnosticReportService($this->httpClient);
    }

    public function episodeOfCare(): EpisodeOfCareService
    {
        return $this->episodeOfCareService ??= new EpisodeOfCareService($this->httpClient);
    }

    public function carePlan(): CarePlanService
    {
        return $this->carePlanService ??= new CarePlanService($this->httpClient);
    }

    public function questionnaireResponse(): QuestionnaireResponseService
    {
        return $this->questionnaireResponseService ??= new QuestionnaireResponseService($this->httpClient);
    }

    public function serviceRequest(): ServiceRequestService
    {
        return $this->serviceRequestService ??= new ServiceRequestService($this->httpClient);
    }

    public function specimen(): SpecimenService
    {
        return $this->specimenService ??= new SpecimenService($this->httpClient);
    }

    public function relatedPerson(): RelatedPersonService
    {
        return $this->relatedPersonService ??= new RelatedPersonService($this->httpClient);
    }

    public function coverage(): CoverageService
    {
        return $this->coverageService ??= new CoverageService($this->httpClient);
    }

    public function coverageEligibilityRequest(): CoverageEligibilityRequestService
    {
        return $this->coverageEligibilityRequestService ??= new CoverageEligibilityRequestService($this->httpClient);
    }

    public function coverageEligibilityResponse(): CoverageEligibilityResponseService
    {
        return $this->coverageEligibilityResponseService ??= new CoverageEligibilityResponseService($this->httpClient);
    }

    public function account(): AccountService
    {
        return $this->accountService ??= new AccountService($this->httpClient);
    }

    public function chargeItem(): ChargeItemService
    {
        return $this->chargeItemService ??= new ChargeItemService($this->httpClient);
    }

    public function invoice(): InvoiceService
    {
        return $this->invoiceService ??= new InvoiceService($this->httpClient);
    }

    public function claim(): ClaimService
    {
        return $this->claimService ??= new ClaimService($this->httpClient);
    }

    public function claimResponse(): ClaimResponseService
    {
        return $this->claimResponseService ??= new ClaimResponseService($this->httpClient);
    }

    public function paymentReconciliation(): PaymentReconciliationService
    {
        return $this->paymentReconciliationService ??= new PaymentReconciliationService($this->httpClient);
    }

    public function paymentNotice(): PaymentNoticeService
    {
        return $this->paymentNoticeService ??= new PaymentNoticeService($this->httpClient);
    }
}
