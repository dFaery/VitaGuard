<?php

namespace App\Data\Value\Medic;

enum DosageForm: string
{
    case TABLET = "tablet";
    case CAPSULE = "capsule";
    case SYRUP = "syrup";
    case INJECTION = "injection";
    case OINTMENT = "ointment";
}