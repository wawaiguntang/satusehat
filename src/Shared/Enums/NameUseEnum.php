<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - name.use (HumanName.use)
 * Standard: http://hl7.org/fhir/name-use
 */
enum NameUseEnum: string
{
    case Official  = 'official';
    case Usual     = 'usual';
    case Temp      = 'temp';
    case Nickname  = 'nickname';
    case Anonymous = 'anonymous';
    case Old       = 'old';
    case Maiden    = 'maiden';
}
