<?php

namespace Wawaiguntang\Satusehat\Enums\Claim;

/**
 * FHIR R4 - Claim.use / ClaimResponse.use
 * Standard: http://hl7.org/fhir/claim-use
 *
 * Digunakan oleh: Claim.use, ClaimResponse.use
 */
enum ClaimUseEnum: string
{
    /** Klaim */
    case Claim              = 'claim';
    /** Pra-otorisasi */
    case Preauthorization   = 'preauthorization';
    /** Pra-penentuan */
    case Predetermination   = 'predetermination';
}
