<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;
use Wawaiguntang\Satusehat\SatusehatClient;

#[Route('/satusehat/patients', name: 'satusehat_patient_')]
class PatientController extends AbstractController
{
    public function __construct(
        private readonly SatusehatClient $satusehat,
    ) {}

    /**
     * GET /satusehat/patients/nik/{nik}
     * Cari pasien berdasarkan NIK
     */
    #[Route('/nik/{nik}', name: 'find_by_nik', methods: ['GET'])]
    public function findByNik(string $nik): JsonResponse
    {
        try {
            $bundle  = $this->satusehat->patient()->getByNik($nik);
            $patient = $bundle->first();

            if (!$patient) {
                return $this->json(['message' => 'Pasien tidak ditemukan'], 404);
            }

            return $this->json([
                'id'        => $patient->id,
                'name'      => $patient->name,
                'nik'       => $patient->nik,
                'gender'    => $patient->gender,
                'birthDate' => $patient->birthDate,
                'active'    => $patient->active,
            ]);
        } catch (ResourceNotFoundException) {
            return $this->json(['message' => 'Pasien tidak ditemukan'], 404);
        } catch (AuthenticationException) {
            return $this->json(['message' => 'Autentikasi SATUSEHAT gagal'], 503);
        } catch (SatusehatException $e) {
            return $this->json(['message' => $e->getMessage()], 502);
        }
    }

    /**
     * GET /satusehat/patients/{id}
     * Get detail pasien berdasarkan IHS ID
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        try {
            $patient = $this->satusehat->patient()->getById($id);

            return $this->json([
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
            return $this->json(['message' => 'Pasien tidak ditemukan'], 404);
        } catch (SatusehatException $e) {
            return $this->json(['message' => $e->getMessage()], 502);
        }
    }

    /**
     * GET /satusehat/patients?name=&birthDate=&gender=
     * Cari pasien berdasarkan nama
     */
    #[Route('', name: 'search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $name      = $request->query->get('name', '');
        $birthDate = $request->query->get('birthDate');
        $gender    = $request->query->get('gender');

        if (strlen($name) < 3) {
            return $this->json(['message' => 'Parameter "name" minimal 3 karakter'], 422);
        }

        try {
            $bundle = $this->satusehat->patient()->searchByName(
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

            return $this->json([
                'total'    => $bundle->total,
                'patients' => $patients,
            ]);
        } catch (ValidationException $e) {
            return $this->json(['message' => $e->getMessage()], 422);
        } catch (SatusehatException $e) {
            return $this->json(['message' => $e->getMessage()], 502);
        }
    }
}
