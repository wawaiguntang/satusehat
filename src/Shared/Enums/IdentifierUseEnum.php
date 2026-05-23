<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - identifier.use
 * Standard: http://hl7.org/fhir/identifier-use
 */
enum IdentifierUseEnum: string
{
    case Official  = 'official';
    case Usual     = 'usual';
    case Temp      = 'temp';
    case Secondary = 'secondary';
    case Old       = 'old';
}
