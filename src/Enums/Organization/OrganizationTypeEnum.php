<?php

namespace Wawaiguntang\Satusehat\Enums\Organization;

/**
 * FHIR R4 - Organization.type.coding.code
 * Standard: http://terminology.hl7.org/CodeSystem/organization-type
 */
enum OrganizationTypeEnum: string
{
    /** Payer */
    case Pay = 'pay';
    /** Educational Institute */
    case Edu = 'edu';
    /** Government */
    case Govt = 'govt';
    /** Insurance Company */
    case Ins = 'ins';
    /** International Organization */
    case Int = 'int';
    /** Non-Healthcare Business or Corporation */
    case Bus = 'bus';
    /** Other */
    case Other = 'other';
    /** Clinical Research Sponsor */
    case Crs = 'crs';
    /** Community Group */
    case Cg = 'cg';
    /** Organizational team */
    case Team = 'team';
    /** Hospital Department */
    case Dept = 'dept';
    /** Provincial */
    case Prov = 'prov';
}
