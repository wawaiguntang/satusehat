<?php

namespace Wawaiguntang\Satusehat\Enums\MedicationDispense;

/**
 * FHIR R4 - MedicationDispense.status
 * Standard: http://terminology.hl7.org/CodeSystem/medicationdispense-status
 */
enum MedicationDispenseStatusEnum: string
{
    /** Sedang dipersiapkan */
    case Preparation    = 'preparation';
    /** Sedang diproses */
    case InProgress     = 'in-progress';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Ditunda */
    case OnHold         = 'on-hold';
    /** Selesai */
    case Completed      = 'completed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Dihentikan */
    case Stopped        = 'stopped';
    /** Ditolak */
    case Declined       = 'declined';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
