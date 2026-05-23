<?php

/**
 * Contoh: PatientService — cari, get, dan update pasien
 *
 * Run: php patient.php
 */

/** @var \Wawaiguntang\Satusehat\SatusehatClient $satusehat */
$satusehat = require __DIR__ . '/bootstrap.php';

use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;

// ── 1. Cari pasien berdasarkan NIK ─────────────────────────────────────────
echo "=== Cari Pasien by NIK ===" . PHP_EOL;

try {
    $bundle = $satusehat->patient()->getByNik('3271234567890001');

    echo "Total ditemukan: {$bundle->total}" . PHP_EOL;

    $patient = $bundle->first();
    if ($patient) {
        echo "ID       : {$patient->id}" . PHP_EOL;
        echo "Nama     : {$patient->name}" . PHP_EOL;
        echo "NIK      : {$patient->nik}" . PHP_EOL;
        echo "Gender   : {$patient->gender}" . PHP_EOL;
        echo "Tgl Lahir: {$patient->birthDate}" . PHP_EOL;
    } else {
        echo "Pasien tidak ditemukan." . PHP_EOL;
    }
} catch (ResourceNotFoundException $e) {
    echo "Pasien tidak ditemukan: " . $e->getMessage() . PHP_EOL;
} catch (AuthenticationException $e) {
    echo "Autentikasi gagal: " . $e->getMessage() . PHP_EOL;
} catch (SatusehatException $e) {
    echo "Error SATUSEHAT: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 2. Get pasien berdasarkan ID IHS ────────────────────────────────────────
echo "=== Get Pasien by IHS Number ===" . PHP_EOL;

try {
    $bundle = $satusehat->patient()->getByIhsNumber('P20394967125');
    $patient = $bundle->first();

    if ($patient) {
        echo "Pasien ditemukan: {$patient->name} (ID: {$patient->id})" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 3. Cari pasien by NIK Ibu (untuk pasien bayi) ─────────────────────────
echo "=== Cari Pasien by NIK Ibu ===" . PHP_EOL;

try {
    $bundle = $satusehat->patient()->getByNikIbu(
        nikIbu:    '9104025209000006',
        birthDate: '2024-12-09',
    );

    echo "Total bayi ditemukan: {$bundle->total}" . PHP_EOL;

    foreach ($bundle->getEntries() as $bayi) {
        echo "  - {$bayi->name} (lahir: {$bayi->birthDate})" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 4. Cari pasien berdasarkan nama ────────────────────────────────────────
echo "=== Cari Pasien by Nama ===" . PHP_EOL;

try {
    $bundle = $satusehat->patient()->searchByName(
        name:      'Budi',
        birthDate: '1990-01-01',
        gender:    'male',
    );

    echo "Total ditemukan: {$bundle->total}" . PHP_EOL;

    foreach ($bundle->getEntries() as $p) {
        echo "  - {$p->name} | {$p->gender} | {$p->birthDate}" . PHP_EOL;
    }
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;

// ── 5. Update data pasien via PATCH ────────────────────────────────────────
echo "=== PATCH Pasien ===" . PHP_EOL;

try {
    $patientId = '100000030009';

    $updated = $satusehat->patient()->patch($patientId, [
        ['op' => 'replace', 'path' => '/active', 'value' => true],
    ]);

    echo "Pasien berhasil di-update: {$updated->id}" . PHP_EOL;
} catch (ValidationException $e) {
    echo "Validasi gagal: " . $e->getMessage() . PHP_EOL;
} catch (SatusehatException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
