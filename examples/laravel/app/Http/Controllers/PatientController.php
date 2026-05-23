<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Wawaiguntang\Satusehat\Exceptions\AuthenticationException;
use Wawaiguntang\Satusehat\Exceptions\ResourceNotFoundException;
use Wawaiguntang\Satusehat\Exceptions\SatusehatException;
use Wawaiguntang\Satusehat\Exceptions\ValidationException;
use Wawaiguntang\Satusehat\SatusehatClient;

class PatientController extends Controller
{
    public function __construct(
        private readonly SatusehatClient $satusehat,
    ) {}

    /**
     * GET /api/patients/nik/{nik}
     * Cari pasien berdasarkan NIK di SATUSEHAT
     */
    public function findByNik(string $nik): JsonResponse
    {
        try {
            $bundle = $this->satusehat->patient()->getByNik($nik);

            if ($bundle->total === 0 || !$bundle->first()) {
                return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
            }

            $patient = $bundle->first();

            return response()->json([
                'id'        => $patient->id,
                'name'      => $patient->name,
                'nik'       => $patient->nik,
                'gender'    => $patient->gender,
                'birthDate' => $patient->birthDate,
                'active'    => $patient->active,
            ]);
        } catch (ResourceNotFoundException) {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        } catch (AuthenticationException $e) {
            return response()->json(['message' => 'Autentikasi SATUSEHAT gagal'], 503);
        } catch (SatusehatException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }
    }

    /**
     * GET /api/patients/{id}
     * Get detail pasien berdasarkan IHS ID
     */
    public function show(string $id): JsonResponse
    {
        try {
            $patient = $this->satusehat->patient()->getById($id);

            return response()->json([
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
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        } catch (SatusehatException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }
    }

    /**
     * GET /api/patients/search?name=&birthDate=&gender=
     * Cari pasien berdasarkan nama
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'name'      => 'required|string|min:3',
            'birthDate' => 'nullable|date_format:Y-m-d',
            'gender'    => 'nullable|in:male,female',
        ]);

        try {
            $bundle = $this->satusehat->patient()->searchByName(
                name:      $request->string('name'),
                birthDate: $request->input('birthDate'),
                gender:    $request->input('gender'),
            );

            $patients = array_map(fn ($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'nik'       => $p->nik,
                'gender'    => $p->gender,
                'birthDate' => $p->birthDate,
            ], $bundle->getEntries());

            return response()->json([
                'total'    => $bundle->total,
                'patients' => $patients,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (SatusehatException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }
    }
}
