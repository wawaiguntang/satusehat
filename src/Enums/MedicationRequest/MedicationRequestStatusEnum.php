<?php

namespace Wawaiguntang\Satusehat\Enums\MedicationRequest;

/**
 * FHIR R4 - MedicationRequest.status
 * Standard: http://hl7.org/fhir/CodeSystem/medicationrequest-status
 */
enum MedicationRequestStatusEnum: string
{
    /** Resep aktif */
    case Active         = 'active';
    /** Resep ditunda */
    case OnHold         = 'on-hold';
    /** Resep dibatalkan */
    case Cancelled      = 'cancelled';
    /** Resep selesai */
    case Completed      = 'completed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Resep dihentikan */
    case Stopped        = 'stopped';
    /** Resep masih draft */
    case Draft          = 'draft';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
