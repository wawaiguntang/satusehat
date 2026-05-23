# Contoh Penggunaan — Native PHP

Contoh integrasi `wawaiguntang/satusehat` tanpa framework.

---

## Requirements

- PHP 8.1+
- Composer

## Dependencies

```bash
composer require wawaiguntang/satusehat \
    guzzlehttp/guzzle \
    http-interop/http-factory-guzzle \
    cache/filesystem-adapter \
    league/flysystem:^1.0
```

## Konfigurasi

Set environment variables sebelum menjalankan:

```bash
export SATUSEHAT_CLIENT_ID="your-client-id"
export SATUSEHAT_CLIENT_SECRET="your-client-secret"
export SATUSEHAT_ENV="staging"   # atau "production"
```

Atau edit langsung nilai di `bootstrap.php`.

## Cara Menjalankan

```bash
# Cari dan update pasien
php patient.php

# Buat encounter, patch status, get everything
php encounter.php

# Cari dan buat coverage BPJS
php coverage.php
```

## File

| File | Deskripsi |
|---|---|
| `bootstrap.php` | Inisialisasi `SatusehatClient` dengan Guzzle + file cache |
| `patient.php` | Cari by NIK, by IHS number, by NIK Ibu, by nama, dan PATCH |
| `encounter.php` | Create, search by patient, patch status, getEverything |
| `coverage.php` | Search by patient, search by identifier BPJS, create, patch |

## Catatan

Token OAuth2 di-cache otomatis di `storage/cache/`. Selama token masih valid, tidak akan ada request autentikasi ulang.
