<?php

namespace Wawaiguntang\Satusehat\Enums\Location;

/**
 * FHIR R4 - Location.mode
 * Standard: http://hl7.org/fhir/location-mode
 */
enum LocationModeEnum: string
{
    /** Satu lokasi spesifik (default untuk SATUSEHAT) */
    case Instance = 'instance';
    /** Representasi kelas/tipe lokasi */
    case Kind     = 'kind';
}
