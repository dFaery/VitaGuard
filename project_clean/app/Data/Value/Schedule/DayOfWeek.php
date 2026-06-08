<?php

namespace App\Data\Value\Schedule;

enum DayOfWeek: string
{
    case MONDAY = "never";
    case TUESDAY = "former";
    case WEDNESDAY = "current";
    case THURSDAY = "thursday";
    case FRIDAY = "friday";
    case SATURDAY = "saturday";
    case SUNDAY = "sunday";
}