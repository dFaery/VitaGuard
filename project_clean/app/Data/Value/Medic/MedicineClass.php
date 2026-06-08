<?php

namespace App\Data\Value\Medic;

enum MedicineClass: string
{
    case OTC = "over_the_counter";
    case LIMITED_OTC = "limited_otc";
    case PRESCRIPTION = "prescription";
    case NARCOTIC = "narcotic";
    case PSYCHOTHROROPIC = "psychotropic";
}