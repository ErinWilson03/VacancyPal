<?php

namespace App\Enums;

enum VacancyTypeEnum: String
{
    // Defining the allowed values for a vacancy type
    case FullTime = 'full-time';
    case PartTime = 'part-time';
    case Contract = 'contract';
    case Temporary = 'temporary';
    case Internship = 'internship';
}
