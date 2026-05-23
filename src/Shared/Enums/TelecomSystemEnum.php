<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - telecom.system (ContactPoint.system)
 * Standard: http://hl7.org/fhir/contact-point-system
 */
enum TelecomSystemEnum: string
{
    case Phone = 'phone';
    case Fax   = 'fax';
    case Email = 'email';
    case Pager = 'pager';
    case Url   = 'url';
    case Sms   = 'sms';
    case Other = 'other';
}
