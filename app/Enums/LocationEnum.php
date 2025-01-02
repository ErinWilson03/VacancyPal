<?php

namespace App\Enums;

enum LocationEnum: String
{
    // Allowed values for the location field of a vacancy
    case Remote = 'Remote';
    case InOffice = 'In Office';
    case Hybrid = 'Hybrid';
}
