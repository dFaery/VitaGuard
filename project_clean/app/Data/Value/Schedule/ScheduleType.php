<?php

namespace App\Data\Value\Schedule;

use App\Data\Service\DoctorSchedule;
use App\Data\Service\FacilitySchedule;

enum ScheduleType: string
{
    case DOCTOR = "doctor";
    case FACILITY = "facility";
    public function getClass(): string
    {
        return match ($this) {
            self::DOCTOR => DoctorSchedule::class,
            self::FACILITY => FacilitySchedule::class
        };
    }
}