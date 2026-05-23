<?php

namespace Wawaiguntang\Satusehat\Enums\Account;

/**
 * FHIR R4 - Account.status
 * Standard: http://hl7.org/fhir/account-status
 */
enum AccountStatusEnum: string
{
    /** Aktif */
    case Active         = 'active';
    /** Tidak aktif */
    case Inactive       = 'inactive';
    /** Input dengan error */
    case EnteredInError = 'entered-in-error';
    /** Ditahan */
    case OnHold         = 'on-hold';
    /** Status tidak diketahui */
    case Unknown        = 'unknown';
}
