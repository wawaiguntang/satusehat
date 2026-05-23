<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - telecom.use (ContactPoint.use)
 * Standard: http://hl7.org/fhir/contact-point-use
 */
enum TelecomUseEnum: string
{
    case Home   = 'home';
    case Work   = 'work';
    case Temp   = 'temp';
    case Old    = 'old';
    case Mobile = 'mobile';
}
