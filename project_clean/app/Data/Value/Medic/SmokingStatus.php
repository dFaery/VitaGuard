<?php

namespace App\Data\Value\Medic;

enum SmokingStatus: string
{
    case NEVER = "never";
    case FORMER = "former";
    case CURRENT = "current";
}