# Contoh Penggunaan — CodeIgniter 4

Panduan integrasi `wawaiguntang/satusehat` di project **CodeIgniter 4**.

---

## 1. Install Library

```bash
composer require wawaiguntang/satusehat guzzlehttp/guzzle
```

---

## 2. Salin File Config

Salin `app/Config/Satusehat.php` ke folder `app/Config/` project Anda.

---

## 3. Konfigurasi `.env`

Tambahkan di file `.env`:

```env
SATUSEHAT_CLIENT_ID = your-client-id
SATUSEHAT_CLIENT_SECRET = your-client-secret
SATUSEHAT_ENV = staging
```

---

## 4. Salin Library

Salin `app/Libraries/SatusehatManager.php` ke `app/Libraries/` project Anda.

`SatusehatManager` berisi:
- **`CIToSatusehatCache`** — adapter PSR-16 untuk CI4 `CacheInterface`
- **`SatusehatManager`** — singleton factory yang lazy-init `SatusehatClient`

---

## 5. Penggunaan di Controller

```php
use App\Libraries\SatusehatManager;

class EncounterController extends BaseController
{
    private SatusehatManager $manager;

    public function __construct()
    {
        $this->manager = new SatusehatManager(config('Satusehat'));
    }

    public function encounters(string $patientId)
    {
        $bundle = $this->manager->client()->encounter()->searchByPatient($patientId);

        return $this->response->setJSON([
            'total'      => $bundle->total,
            'encounters' => array_map(fn($e) => [
                'id'     => $e->id,
                'status' => $e->status,
            ], $bundle->getEntries()),
        ]);
    }
}
```

---

## 6. Tambahkan Routes

Di `app/Config/Routes.php`:

```php
$routes->group('satusehat', function ($routes) {
    $routes->get('patients/search',     'PatientController::search');
    $routes->get('patients/nik/(:segment)', 'PatientController::findByNik/$1');
    $routes->get('patients/(:segment)', 'PatientController::show/$1');
});
```

---

## File

| File | Salin ke |
|---|---|
| `app/Config/Satusehat.php` | `app/Config/Satusehat.php` |
| `app/Libraries/SatusehatManager.php` | `app/Libraries/SatusehatManager.php` |
| `app/Controllers/PatientController.php` | `app/Controllers/PatientController.php` |

---

## Catatan Cache

CI4 menggunakan handler cache sendiri (file, redis, memcached). `CIToSatusehatCache` menjembatani CI4 `CacheInterface` ke PSR-16 yang dibutuhkan library. Pastikan cache handler yang digunakan persistent (bukan `dummy`).

Konfigurasi cache di `app/Config/Cache.php`:

```php
public string $handler = 'redis';  // atau 'file'
```
