<?php

namespace App\Controllers;

use App\Libraries\SatusehatManager;
use CodeIgniter\HTTP\ResponseInterface;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;

class PatientController extends BaseController
{
    private SatusehatManager $manager;

    public function __construct()
    {
        $this->manager = new SatusehatManager(config('Satusehat'));
    }

    /**
     * GET /satusehat/patients/nik/(:segment)
     * Cari pasien berdasarkan NIK
     */
    public function findByNik(string $nik): ResponseInterface
    {
        try {
            $bundle  = $this->manager->client()->patient()->getByNik($nik);
            $patient = $bundle->first();

            if (!$patient) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['message' => 'Pasien tidak ditemukan']);
            }

            return $this->response->setJSON([
                'id'        => $patient->id,
                'name'      => $patient->name,
                'nik'       => $patient->nik,
                'gender'    => $patient->gender,
                'birthDate' => $patient->birthDate,
                'active'    => $patient->active,
            ]);
        } catch (ResourceNotFoundException) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['message' => 'Pasien tidak ditemukan']);
        } catch (AuthenticationException $e) {
            return $this->response
                ->setStatusCode(503)
                ->setJSON(['message' => 'Autentikasi SATUSEHAT gagal']);
        } catch (SatusehatException $e) {
            return $this->response
                ->setStatusCode(502)
                ->setJSON(['message' => $e->getMessage()]);
        }
    }

    /**
     * GET /satusehat/patients/(:segment)
     * Get detail pasien berdasarkan IHS ID
     */
    public function show(string $id): ResponseInterface
    {
        try {
            $patient = $this->manager->client()->patient()->getById($id);

            return $this->response->setJSON([
                'id'          => $patient->id,
                'name'        => $patient->name,
                'nik'         => $patient->nik,
                'gender'      => $patient->gender,
                'birthDate'   => $patient->birthDate,
                'active'      => $patient->active,
                'versionId'   => $patient->versionId,
                'lastUpdated' => $patient->lastUpdated,
            ]);
        } catch (ResourceNotFoundException) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['message' => 'Pasien tidak ditemukan']);
        } catch (SatusehatException $e) {
            return $this->response
                ->setStatusCode(502)
                ->setJSON(['message' => $e->getMessage()]);
        }
    }

    /**
     * GET /satusehat/patients/search?name=&birthDate=&gender=
     * Cari pasien berdasarkan nama
     */
    public function search(): ResponseInterface
    {
        $name      = $this->request->getGet('name');
        $birthDate = $this->request->getGet('birthDate');
        $gender    = $this->request->getGet('gender');

        if (empty($name) || strlen($name) < 3) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['message' => 'Parameter "name" minimal 3 karakter']);
        }

        try {
            $bundle = $this->manager->client()->patient()->searchByName(
                name:      $name,
                birthDate: $birthDate ?: null,
                gender:    $gender ?: null,
            );

            $patients = array_map(fn ($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'nik'       => $p->nik,
                'gender'    => $p->gender,
                'birthDate' => $p->birthDate,
            ], $bundle->getEntries());

            return $this->response->setJSON([
                'total'    => $bundle->total,
                'patients' => $patients,
            ]);
        } catch (ValidationException $e) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['message' => $e->getMessage()]);
        } catch (SatusehatException $e) {
            return $this->response
                ->setStatusCode(502)
                ->setJSON(['message' => $e->getMessage()]);
        }
    }
}
