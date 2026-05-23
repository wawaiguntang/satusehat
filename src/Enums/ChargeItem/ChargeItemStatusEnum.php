<?php

namespace Wawaiguntang\Satusehat\Enums\ChargeItem;

/**
 * FHIR R4 - ChargeItem.status
 * Standard: http://hl7.org/fhir/chargeitem-status
 */
enum ChargeItemStatusEnum: string
{
    /** Direncanakan */
    case Planned        = 'planned';
    /** Dapat ditagihkan */
    case Billable       = 'billable';
    /** Tidak dapat ditagihkan */
    case NotBillable    = 'not-billable';
    /** Dibatalkan */
    case Aborted        = 'aborted';
    /** Sudah ditagihkan */
    case Billed         = 'billed';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
