# SATUSEHAT PHP Library

PHP library untuk integrasi [SATUSEHAT](https://satusehat.kemkes.go.id) FHIR R4 API — mendukung 33 resource FHIR dengan typed response DTOs, OAuth2 authentication, PSR-16 token caching, dan retry otomatis.

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Tests](https://img.shields.io/badge/tests-198%20passed-brightgreen)]()

---

## Requirements

- PHP 8.1+
- PSR-18 HTTP Client (misal: `guzzlehttp/guzzle`, `symfony/http-client`)
- PSR-17 HTTP Factory (misal: `nyholm/psr7`, `guzzlehttp/psr7`)
- PSR-16 Simple Cache (misal: `symfony/cache`, `illuminate/cache`)

---

## Installation

```bash
composer require wawaiguntang/satusehat
```

---

## Quick Start

### Menggunakan Factory (Direkomendasikan)

Pastikan ada PSR-18 + PSR-17 yang terinstall (misal `guzzlehttp/guzzle` + `http-interop/http-factory-guzzle`):

```bash
composer require guzzlehttp/guzzle http-interop/http-factory-guzzle symfony/cache
```

```php
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Wawaiguntang\Satusehat\SatusehatClientFactory;

$cache  = new Psr16Cache(new FilesystemAdapter());
$client = SatusehatClientFactory::create(
    clientId:     'your-client-id',
    clientSecret: 'your-client-secret',
    cache:        $cache,
);
```

### Inisialisasi Manual (PSR-18/17 Explicit)

```php
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use Wawaiguntang\Satusehat\SatusehatClient;

$client = new SatusehatClient(
    clientId:       'your-client-id',
    clientSecret:   'your-client-secret',
    httpClient:     new GuzzleClient(),
    requestFactory: new HttpFactory(),
    streamFactory:  new HttpFactory(),
    cache:          $cache,
);
```

### Environment Staging

```php
$client = SatusehatClientFactory::create(
    clientId:     'your-client-id',
    clientSecret: 'your-client-secret',
    cache:        $cache,
    baseUrl:      'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1',
    authUrl:      'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1',
);
```

---

## Contoh Penggunaan

### Patient

```php
// Cari pasien berdasarkan NIK
$bundle = $client->patient()->getByNik('3271234567890001');
$patient = $bundle->first(); // PatientResponse
echo $patient->name;         // "Budi Santoso"
echo $patient->nik;          // "3271234567890001"

// Cari berdasarkan NIK Ibu (untuk pasien bayi)
$bundle = $client->patient()->getByNikIbu('9104025209000006', '2024-12-09');

// Cari berdasarkan nomor IHS
$bundle = $client->patient()->getByIhsNumber('P20394967125');

// Cari berdasarkan nama
$bundle = $client->patient()->searchByName('Budi Santoso', '1990-01-01', 'male');

// Get by ID
$patient = $client->patient()->getById('100000030009');
```

### Encounter

```php
use Wawaiguntang\Satusehat\DTOs\Encounter\EncounterDTO;

// Buat encounter baru
$encounter = $client->encounter()->create(new EncounterDTO(
    status:           'arrived',
    classCode:        'AMB',
    subjectReference: 'Patient/100000030009',
    // ...
));

// Cari encounter by patient
$bundle = $client->encounter()->searchByPatient('100000030009');
foreach ($bundle->getEntries() as $enc) {
    echo $enc->id . ': ' . $enc->status . PHP_EOL;
}

// Update status via PATCH
$client->encounter()->patch($encounter->id, [
    ['op' => 'replace', 'path' => '/status', 'value' => 'finished'],
]);

// Ambil semua resource terkait satu encounter
$everything = $client->encounter()->getEverything($encounter->id);
```

### Coverage (BPJS/Asuransi)

```php
// Cari kepesertaan pasien
$bundle = $client->coverage()->searchByPatientAndIdentifier(
    patientId:  '100000030009',
    identifier: 'https://sys-ids.kemkes.go.id/insurance-subscriber/org-id|',
);

// Buat coverage BPJS
$coverage = $client->coverage()->create(new CoverageDTO(/* ... */));
```

---

## Error Handling

```php
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;
use Wawaiguntang\Satusehat\Exceptions\ServerException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;

try {
    $patient = $client->patient()->getById('invalid-id');
} catch (ResourceNotFoundException $e) {
    // 404 — resource tidak ditemukan
} catch (ValidationException $e) {
    // 400 — request tidak valid
} catch (AuthenticationException $e) {
    // 401 — token expired atau client credentials salah
} catch (ServerException $e) {
    // 5xx — server error (sudah di-retry 3x otomatis)
} catch (SatusehatException $e) {
    // Error lainnya
    echo $e->getMessage();
}
```

---

## Daftar Services

| Service | Method Utama |
|---|---|
| `patient()` | `getByNik`, `getByNikIbu`, `getByIhsNumber`, `searchByName`, `getById`, `create`, `patch` |
| `practitioner()` | `getByNik`, `getById` |
| `organization()` | `getById`, `search`, `create`, `update` |
| `location()` | `getById`, `searchByOrganization`, `create`, `update`, `patch` |
| `encounter()` | `create`, `getById`, `searchByPatient`, `update`, `patch`, `getEverything` |
| `condition()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update`, `patch` |
| `observation()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `searchByCode`, `update`, `patch` |
| `composition()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update`, `patch` |
| `procedure()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update`, `patch` |
| `allergyIntolerance()` | `create`, `getById`, `searchByPatient`, `update`, `patch` |
| `clinicalImpression()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update`, `patch` |
| `imagingStudy()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update` |
| `immunization()` | `create`, `getById`, `searchByPatient`, `update`, `patch` |
| `medication()` | `create`, `getById`, `searchByCode`, `update` |
| `medicationRequest()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update`, `patch` |
| `medicationDispense()` | `create`, `getById`, `searchByPatient`, `update`, `patch` |
| `diagnosticReport()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `update`, `patch` |
| `episodeOfCare()` | `create`, `getById`, `searchByPatient`, `update`, `patch` |
| `carePlan()` | `create`, `getById`, `searchByPatient`, `update` |
| `questionnaireResponse()` | `create`, `getById`, `searchByPatient`, `update` |
| `serviceRequest()` | `create`, `getById`, `searchByPatient`, `searchByEncounter`, `searchByReferralNumber`, `update` |
| `specimen()` | `create`, `getById`, `searchByPatient`, `searchByRequest`, `searchByCollector`, `searchBySubjectAndDate`, `searchByIdentifierAndRequest`, `update`, `patch` |
| `relatedPerson()` | `create`, `getById`, `searchByPatient`, `searchByNik`, `update`, `patch` |
| `coverage()` | `create`, `getById`, `searchByPatient`, `searchByPatientAndIdentifier`, `update`, `patch` |
| `coverageEligibilityRequest()` | `create`, `getById`, `searchByIdentifier`, `getEverything` |
| `coverageEligibilityResponse()` | `create`, `getById`, `searchByRequest` |
| `account()` | `create`, `getById`, `searchByPatient`, `patch` |
| `chargeItem()` | `create`, `getById`, `searchByAccount` |
| `invoice()` | `create`, `getById`, `searchByPatient` |
| `claim()` | `create`, `getById`, `searchByPatient`, `searchByIdentifier` |
| `claimResponse()` | `create`, `getById`, `searchByPatient` |
| `paymentReconciliation()` | `create`, `getById`, `searchByClaimId` |
| `paymentNotice()` | `create`, `getById`, `searchByClaimId` |

---

## Response DTOs

Semua method mengembalikan typed response DTOs:

```php
$patient = $client->patient()->getById('100000030009');

// Typed properties:
$patient->id;          // string|null
$patient->name;        // string|null
$patient->nik;         // string|null
$patient->gender;      // string|null
$patient->birthDate;   // string|null
$patient->active;      // bool|null
$patient->raw;         // array — raw response dari API
$patient->versionId;   // string|null
$patient->lastUpdated; // string|null
```

Search methods mengembalikan `BundleResponse`:

```php
$bundle = $client->patient()->getByNik('3271...');
$bundle->total;          // int — total hasil
$bundle->getEntries();   // PatientResponse[]
$bundle->first();        // PatientResponse|null
$bundle->nextLink;       // string|null — URL halaman berikutnya
```

---

## License

MIT — lihat [LICENSE](LICENSE).
