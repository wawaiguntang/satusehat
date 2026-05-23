<?php

namespace Wawaiguntang\Satusehat\Enums\Location;

/**
 * FHIR R4 - Location.status
 * Standard: http://hl7.org/fhir/location-status
 */
enum LocationStatusEnum: string
{
    /** Lokasi beroperasi */
    case Active    = 'active';
    /** Lokasi sementara tidak beroperasi */
    case Suspended = 'suspended';
    /** Lokasi tidak aktif */
    case Inactive  = 'inactive';
}
