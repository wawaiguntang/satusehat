<?php

/**
 * Contoh: EncounterService — create, search, patch, getEverything
 *
 * Run: php encounter.php
 */

/** @var \Wawaiguntang\Satusehat\SatusehatClient $satusehat */
$satusehat = require __DIR__ . '/bootstrap.php';

use Wawaiguntang\Satusehat\DTOs\Encounter\EncounterDTO;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;

$patientId      = '100000030009';
$practitionerId = '10009880728';
$organizationId = '10000004';
$locationId     = 'ef011065-38c9-46f8-9c35-d1fe68966a3e';

// ── 1. Buat Encounter baru ─────────────────────────────────────────────────
echo "=== Buat Encounter ===" . PHP_EOL;

try {
    $dto = new EncounterDTO(
        status:                  'arrived',
        classCode:               'AMB',
        classDisplay:            'ambulatory',
        subjectReference:        "Patient/{$patientId}",
        subjectDisplay:          'Budi Santoso',
        participantReference:    "Practitioner/{$practitionerId}",
        participantDisplay:      'dr. Siti',
        periodStart:             date('Y-m-d\TH:i:sP'),
        serviceProviderReference: "Organization/{$organizationId}",
        locationReference:       "Location/{$locationId}",
        locationDisplay:         'Poli Umum',
    );

    $encounter = $satusehat->encounter()->create($dto);

    echo "Encounter berhasil dibuat!" . PHP_EOL;
    echo "ID     : {$encounter->id}" . PHP_EOL;
    echo "Status : {$encounter->status}" . PHP_EOL;
    echo "Version: {$encounter->versionId}" . PHP_EOL;

    $encounterId = $encounter->id;
} catch (ValidationException $e) {
    echo "Validasi gagal: " . $e->getMessage() . PHP_EOL;
    exit(1);
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

echo PHP_EOL;

// ── 2. Cari encounter berdasarkan pasien ──────────────────────────────────
echo "=== Cari Encounter by Pasien ===" . PHP_EOL;

try {
    $bundle = $satusehat->encounter()->searchByPatient($patientId);

    echo "Total encounter: {$bundle->total}" . PHP_EOL;

    foreach ($bundle->getEntries() as $enc) {
        echo "  - {$enc->id} | {$enc->status} | {$enc->period?->start}" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 3. Update status encounter via PATCH ──────────────────────────────────
echo "=== PATCH Encounter (status: in-progress) ===" . PHP_EOL;

try {
    $updated = $satusehat->encounter()->patch($encounterId, [
        ['op' => 'replace', 'path' => '/status', 'value' => 'in-progress'],
    ]);

    echo "Status diupdate: {$updated->status}" . PHP_EOL;
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 4. Selesaikan encounter ────────────────────────────────────────────────
echo "=== PATCH Encounter (status: finished) ===" . PHP_EOL;

try {
    $finished = $satusehat->encounter()->patch($encounterId, [
        ['op' => 'replace', 'path' => '/status',       'value' => 'finished'],
        ['op' => 'replace', 'path' => '/period/end',   'value' => date('Y-m-d\TH:i:sP')],
    ]);

    echo "Encounter selesai: {$finished->status}" . PHP_EOL;
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 5. Get semua resource terkait encounter ────────────────────────────────
echo "=== Get Everything for Encounter ===" . PHP_EOL;

try {
    $everything = $satusehat->encounter()->getEverything($encounterId);

    echo "Total resource: {$everything->total}" . PHP_EOL;

    foreach ($everything->getEntries() as $resource) {
        echo "  - [{$resource->resourceType}] {$resource->id}" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
