<?php

namespace Wawaiguntang\Satusehat\Enums\Location;

/**
 * FHIR R4 - Location.physicalType.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/location-physical-type
 */
enum LocationPhysicalTypeEnum: string
{
    /** Site — area yang lebih besar */
    case Si  = 'si';
    /** Building — gedung */
    case Bu  = 'bu';
    /** Wing — sayap gedung */
    case Wi  = 'wi';
    /** Ward — bangsal */
    case Wa  = 'wa';
    /** Level — lantai */
    case Lvl = 'lvl';
    /** Corridor — koridor */
    case Co  = 'co';
    /** Room — ruangan (paling umum di SATUSEHAT) */
    case Ro  = 'ro';
    /** Bed — tempat tidur */
    case Bd  = 'bd';
    /** Vehicle — kendaraan */
    case Ve  = 've';
    /** House — rumah */
    case Ho  = 'ho';
    /** Cabinet — lemari/kabinet */
    case Ca  = 'ca';
    /** Road — jalan */
    case Rd  = 'rd';
    /** Area */
    case Area = 'area';
    /** Jurisdiction */
    case Jdn = 'jdn';
}
