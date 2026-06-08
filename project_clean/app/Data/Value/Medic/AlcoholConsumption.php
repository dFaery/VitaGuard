<?php

namespace App\Data\Value\Medic;

enum AlcoholConsumption: string
{
    case NONE = "none";
    case LIGHT = "light";
    case MODERATE = "moderate";
    case HEAVY = "heavy";
}