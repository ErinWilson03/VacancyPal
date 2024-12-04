<?php

namespace App\Enums;

enum IndustryEnum: String
{
    // Allowed values for the industry field of a vacancy
    case Finance = 'Finance';
    case Technology = 'Technology';
    case Healthcare = 'Healthcare';
    case Education = 'Education';
    case Retail = 'Retail';
    case Manufacturing = 'Manufacturing';
    case InformationSecurity = 'Information Security';
}
