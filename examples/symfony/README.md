# Contoh Penggunaan — Symfony

Panduan integrasi `wawaiguntang/satusehat` di project **Symfony 6/7**.

---

## 1. Install Library

```bash
composer require wawaiguntang/satusehat symfony/http-client nyholm/psr7 symfony/cache
```

`symfony/http-client` + `nyholm/psr7` menyediakan PSR-18/17 yang akan di-discover otomatis oleh `SatusehatClientFactory`.

---

## 2. Konfigurasi `.env`

```env
SATUSEHAT_CLIENT_ID=your-client-id
SATUSEHAT_CLIENT_SECRET=your-client-secret
SATUSEHAT_ENV=staging

# URL otomatis dipilih berdasarkan ENV, atau override manual:
SATUSEHAT_BASE_URL=https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1
SATUSEHAT_AUTH_URL=https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1
```

---

## 3. Import Konfigurasi

Salin `config/packages/satusehat.yaml` ke `config/packages/` project Anda.

Salin `config/services_satusehat.yaml` ke `config/` lalu import di `config/services.yaml`:

```yaml
# config/services.yaml
imports:
    - { resource: 'services_satusehat.yaml' }
```

---

## 4. Salin Controller

Salin `src/Controller/PatientController.php` ke `src/Controller/` project Anda.

Controller menggunakan **constructor injection** — Symfony akan inject `SatusehatClient` secara otomatis berkat konfigurasi di `services_satusehat.yaml`.

---

## 5. Penggunaan di Controller Lain

```php
use Wawaiguntang\Satusehat\SatusehatClient;

class EncounterController extends AbstractController
{
    public function __construct(
        private readonly SatusehatClient $satusehat,
    ) {}

    #[Route('/encounters/{patientId}', methods: ['GET'])]
    public function index(string $patientId): JsonResponse
    {
        $bundle = $this->satusehat->encounter()->searchByPatient($patientId);

        return $this->json([
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

## 6. Exception Handling Global (Opsional)

Buat `EventSubscriber` untuk handle exception SATUSEHAT secara global:

```php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;

class SatusehatExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof ResourceNotFoundException) {
            $event->setResponse(new JsonResponse(['message' => 'Resource tidak ditemukan'], 404));
        } elseif ($e instanceof SatusehatException) {
            $event->setResponse(new JsonResponse(['message' => $e->getMessage()], 502));
        }
    }
}
```

---

## File

| File | Salin ke |
|---|---|
| `config/packages/satusehat.yaml` | `config/packages/satusehat.yaml` |
| `config/services_satusehat.yaml` | `config/services_satusehat.yaml` |
| `src/Controller/PatientController.php` | `src/Controller/PatientController.php` |

---

## Catatan Cache

Library menggunakan PSR-16 untuk cache token. `Symfony\Component\Cache\Psr16Cache` di-wrap dari `cache.app` pool (dikonfigurasi di `config/packages/cache.yaml`). Pastikan adapter `cache.app` persistent (Redis/Memcached) di production.
