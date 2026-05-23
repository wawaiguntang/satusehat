<?php

namespace Wawaiguntang\Satusehat\Shared\Enums;

/**
 * FHIR R4 - address.use
 * Standard: http://hl7.org/fhir/address-use
 */
enum AddressUseEnum: string
{
    case Home = 'home';
    case Work = 'work';
    case Temp = 'temp';
    case Old  = 'old';
}
