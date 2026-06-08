<?php

namespace App\Data\Value\Schedule;

enum AppointmentStatus: string
{
    case PENDING = "pending";
    case CONFIRMED = "confirmed";
    case COMPLETED = "completed";
    case CANCELLED = "cancelled";
    case NO_SHOW = "no_show";
}