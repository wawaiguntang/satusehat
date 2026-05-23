# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-05-23

### Added
- `SatusehatClient` — main entry point with lazy service getters for all 33 FHIR resources
- `SatusehatClientFactory` — auto-discovery factory using `php-http/discovery`
- `SatusehatAuthenticator` — OAuth2 `client_credentials` flow with PSR-16 token caching
- `SatusehatHttpClient` — PSR-18 wrapper with Bearer token injection, retry with exponential backoff, and HTTP error mapping
- **6 Exception classes**: `SatusehatException`, `AuthenticationException`, `ForbiddenException`, `ResourceNotFoundException`, `ValidationException`, `ServerException`
- **33 Resource Services** with full CRUD + search methods:
  - `PatientService` — getByNik, getByNikIbu, getByIhsNumber, searchByName, getById, create, patch
  - `PractitionerService` — getByNik, getById
  - `OrganizationService` — getById, search, create, update
  - `LocationService` — getById, searchByOrganization, create, update, patch
  - `EncounterService` — create, getById, searchByPatient, update, patch, getEverything
  - `ConditionService` — create, getById, searchByPatient, searchByEncounter, update, patch
  - `ObservationService` — create, getById, searchByPatient, searchByEncounter, searchByCode, update, patch
  - `CompositionService` — create, getById, searchByPatient, searchByEncounter, update, patch
  - `ProcedureService` — create, getById, searchByPatient, searchByEncounter, update, patch
  - `AllergyIntoleranceService` — create, getById, searchByPatient, update, patch
  - `ClinicalImpressionService` — create, getById, searchByPatient, searchByEncounter, update, patch
  - `ImagingStudyService` — create, getById, searchByPatient, searchByEncounter, update
  - `ImmunizationService` — create, getById, searchByPatient, update, patch
  - `MedicationService` — create, getById, searchByCode, update
  - `MedicationRequestService` — create, getById, searchByPatient, searchByEncounter, update, patch
  - `MedicationDispenseService` — create, getById, searchByPatient, update, patch
  - `DiagnosticReportService` — create, getById, searchByPatient, searchByEncounter, update, patch
  - `EpisodeOfCareService` — create, getById, searchByPatient, update, patch
  - `CarePlanService` — create, getById, searchByPatient, update
  - `QuestionnaireResponseService` — create, getById, searchByPatient, update
  - `ServiceRequestService` — create, getById, searchByPatient, searchByEncounter, searchByReferralNumber, update
  - `SpecimenService` — create, getById, searchByPatient, searchByRequest, searchByCollector, searchBySubjectAndDate, searchByIdentifierAndRequest, update, patch
  - `RelatedPersonService` — create, getById, searchByPatient, searchByNik, update, patch
  - `CoverageService` — create, getById, searchByPatient, searchByPatientAndIdentifier, update, patch
  - `CoverageEligibilityRequestService` — create, getById, searchByIdentifier, getEverything
  - `CoverageEligibilityResponseService` — create, getById, searchByRequest
  - `AccountService` — create, getById, searchByPatient, patch
  - `ChargeItemService` — create, getById, searchByAccount
  - `InvoiceService` — create, getById, searchByPatient
  - `ClaimService` — create, getById, searchByPatient, searchByIdentifier
  - `ClaimResponseService` — create, getById, searchByPatient
  - `PaymentReconciliationService` — create, getById, searchByClaimId
  - `PaymentNoticeService` — create, getById, searchByClaimId
- **33 Resource Response DTOs** with typed readonly properties and `fromArray()` factory
- **5 Shared Response DTOs**: `CodingResponse`, `ReferenceResponse`, `PeriodResponse`, `IdentifierResponse`, `MoneyResponse`
- `BundleResponse` — paginated search result with `first()` and `getEntries()` helpers
- `OperationOutcomeResponse` — parses FHIR OperationOutcome, Apigee fault, and auth error formats
- 198 unit tests, 321 assertions

[Unreleased]: https://github.com/wawaiguntang/satusehat/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/wawaiguntang/satusehat/releases/tag/v1.0.0
