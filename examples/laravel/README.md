# Contoh Penggunaan — Laravel

Panduan integrasi `wawaiguntang/satusehat` di project **Laravel 10/11**.

---

## 1. Install Library

```bash
composer require wawaiguntang/satusehat
```

Library menggunakan `php-http/discovery` untuk auto-detect HTTP client. Jika belum ada, install Guzzle:

```bash
composer require guzzlehttp/guzzle
```

---

## 2. Daftarkan Service Provider

**Laravel 11** — tambahkan di `bootstrap/providers.php`:

```php
return [
    // ...
    App\Providers\SatusehatServiceProvider::class,
];
```

**Laravel 10** — tambahkan di `config/app.php`:

```php
'providers' => [
    // ...
    App\Providers\SatusehatServiceProvider::class,
],
```

Salin file `app/Providers/SatusehatServiceProvider.php` ke project Anda.

---

## 3. Publish Config

```bash
php artisan vendor:publish --tag=satusehat-config
```

Atau salin `config/satusehat.php` langsung ke folder `config/` project Anda.

---

## 4. Konfigurasi `.env`

```env
SATUSEHAT_CLIENT_ID=your-client-id
SATUSEHAT_CLIENT_SECRET=your-client-secret
SATUSEHAT_ENV=staging
SATUSEHAT_CACHE_STORE=redis
```

> **Penting:** Gunakan cache store yang persistent (`redis` atau `file`) agar token OAuth2 tidak di-fetch ulang setiap request.

---

## 5. Penggunaan di Controller

```php
use Wawaiguntang\Satusehat\SatusehatClient;

class EncounterController extends Controller
{
    public function __construct(
        private readonly SatusehatClient $satusehat,
    ) {}

    public function index(string $patientId)
    {
        $bundle = $this->satusehat->encounter()->searchByPatient($patientId);

        return response()->json([
            'total'      => $bundle->total,
            'encounters' => $bundle->getEntries(),
        ]);
    }
}
```

Atau via facade/helper jika di-bind ke container:

```php
app(SatusehatClient::class)->patient()->getByNik('3271...');
```

---

## File

| File | Salin ke |
|---|---|
| `config/satusehat.php` | `config/satusehat.php` |
| `app/Providers/SatusehatServiceProvider.php` | `app/Providers/SatusehatServiceProvider.php` |
| `app/Http/Controllers/PatientController.php` | `app/Http/Controllers/PatientController.php` |
| `routes/api.php` | Merge ke `routes/api.php` |

---

## Exception Handling Global (Opsional)

Tambahkan di `app/Exceptions/Handler.php` atau `bootstrap/app.php` (Laravel 11):

```php
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;

$exceptions->render(function (ResourceNotFoundException $e) {
    return response()->json(['message' => 'Resource SATUSEHAT tidak ditemukan'], 404);
});

$exceptions->render(function (AuthenticationException $e) {
    return response()->json(['message' => 'Autentikasi SATUSEHAT gagal — periksa client credentials'], 503);
});

$exceptions->render(function (SatusehatException $e) {
    return response()->json(['message' => $e->getMessage()], 502);
});
```
