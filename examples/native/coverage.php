<?php

/**
 * Contoh: CoverageService — create coverage BPJS dan search
 *
 * Run: php coverage.php
 */

/** @var \Wawaiguntang\Satusehat\SatusehatClient $satusehat */
$satusehat = require __DIR__ . '/bootstrap.php';

use Wawaiguntang\Satusehat\DTOs\Coverage\CoverageDTO;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;

$patientId      = '100000030009';
$organizationId = '10000004';
$noBpjs         = '0000000000001';

// ── 1. Cari coverage pasien ────────────────────────────────────────────────
echo "=== Cari Coverage by Pasien ===" . PHP_EOL;

try {
    $bundle = $satusehat->coverage()->searchByPatient($patientId);

    echo "Total coverage: {$bundle->total}" . PHP_EOL;

    foreach ($bundle->getEntries() as $cov) {
        echo "  - ID: {$cov->id} | Status: {$cov->status}" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 2. Cari coverage by identifier BPJS ───────────────────────────────────
echo "=== Cari Coverage by Identifier BPJS ===" . PHP_EOL;

try {
    $bundle = $satusehat->coverage()->searchByPatientAndIdentifier(
        patientId:  $patientId,
        identifier: "https://sys-ids.kemkes.go.id/insurance-subscriber/{$organizationId}|{$noBpjs}",
    );

    echo "Total coverage BPJS: {$bundle->total}" . PHP_EOL;

    $coverage = $bundle->first();
    if ($coverage) {
        echo "Coverage ditemukan: {$coverage->id}" . PHP_EOL;
        echo "Status            : {$coverage->status}" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 3. Buat coverage baru ─────────────────────────────────────────────────
echo "=== Buat Coverage ===" . PHP_EOL;

try {
    $dto = new CoverageDTO(
        status:               'active',
        beneficiaryReference: "Patient/{$patientId}",
        payorReference:       "Organization/{$organizationId}",
        identifier: [
            [
                'system' => "https://sys-ids.kemkes.go.id/insurance-subscriber/{$organizationId}",
                'value'  => $noBpjs,
            ],
        ],
        class: [
            [
                'type'  => ['coding' => [['system' => 'http://terminology.hl7.org/CodeSystem/coverage-class', 'code' => 'class']]],
                'value' => '1',
                'name'  => 'Kelas I',
            ],
        ],
    );

    $coverage = $satusehat->coverage()->create($dto);

    echo "Coverage berhasil dibuat!" . PHP_EOL;
    echo "ID    : {$coverage->id}" . PHP_EOL;
    echo "Status: {$coverage->status}" . PHP_EOL;

    $coverageId = $coverage->id;
} catch (ValidationException $e) {
    echo "Validasi gagal: " . $e->getMessage() . PHP_EOL;
    exit(1);
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

echo PHP_EOL;

// ── 4. Nonaktifkan coverage via PATCH ─────────────────────────────────────
echo "=== PATCH Coverage (cancel) ===" . PHP_EOL;

try {
    $updated = $satusehat->coverage()->patch($coverageId, [
        ['op' => 'replace', 'path' => '/status', 'value' => 'cancelled'],
    ]);

    echo "Coverage dinonaktifkan: {$updated->status}" . PHP_EOL;
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
