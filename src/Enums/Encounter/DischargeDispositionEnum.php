<?php

namespace Wawaiguntang\Satusehat\Enums\Encounter;

/**
 * FHIR R4 - Encounter.hospitalization.dischargeDisposition.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/discharge-disposition
 */
enum DischargeDispositionEnum: string
{
    /** Pulang ke rumah */
    case Home       = 'home';
    /** Pulang ke tempat tinggal alternatif */
    case AltHome    = 'alt-home';
    /** Dirujuk ke faskes lain */
    case OtherHcf   = 'other-hcf';
    /** Dirawat di hospice */
    case Hosp       = 'hosp';
    /** Perawatan jangka panjang */
    case Long       = 'long';
    /** Pulang atas permintaan sendiri */
    case Aadvice    = 'aadvice';
    /** Meninggal */
    case Exp        = 'exp';
    /** Psikiatri */
    case Psy        = 'psy';
    /** Rehabilitasi */
    case Rehab      = 'rehab';
    /** Keluar dengan status tidak diketahui */
    case Oth        = 'oth';
    /** Masih di sini */
    case Sns        = 'sns';
}
