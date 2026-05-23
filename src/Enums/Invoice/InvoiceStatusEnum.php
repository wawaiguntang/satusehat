<?php

namespace Wawaiguntang\Satusehat\Enums\Invoice;

/**
 * FHIR R4 - Invoice.status
 * Standard: http://hl7.org/fhir/invoice-status
 */
enum InvoiceStatusEnum: string
{
    /** Draft */
    case Draft          = 'draft';
    /** Diterbitkan */
    case Issued         = 'issued';
    /** Seimbang/lunas */
    case Balanced       = 'balanced';
    /** Dibatalkan */
    case Cancelled      = 'cancelled';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
}
