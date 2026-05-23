<?php

namespace Wawaiguntang\Satusehat\Enums\Encounter;

/**
 * FHIR R4 - Encounter.status
 * Standard: http://hl7.org/fhir/encounter-status
 */
enum EncounterStatusEnum: string
{
    /** Kunjungan direncanakan tapi belum mulai */
    case Planned     = 'planned';
    /** Pasien sudah tiba di fasilitas */
    case Arrived     = 'arrived';
    /** Pasien sudah ditriage */
    case Triaged     = 'triaged';
    /** Kunjungan sedang berlangsung */
    case InProgress  = 'in-progress';
    /** Pasien sementara meninggalkan fasilitas */
    case OnLeave     = 'onleave';
    /** Kunjungan selesai */
    case Finished    = 'finished';
    /** Kunjungan dibatalkan */
    case Cancelled   = 'cancelled';
    /** Status lain yang tidak terdaftar */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown     = 'unknown';
}
