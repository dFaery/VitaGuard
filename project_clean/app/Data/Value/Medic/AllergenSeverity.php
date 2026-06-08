<?php

namespace App\Data\Value\Medic;

enum AllergenSeverity: string
{
    case MILD = "mild";
    case MODERATE = "moderate";
    case SEVERE = "severe";
}