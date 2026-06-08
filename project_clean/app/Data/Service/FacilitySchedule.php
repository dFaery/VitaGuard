<?php

namespace App\Data\Service;

use Carbon\Carbon;
use App\Data\Value\Schedule\DayOfWeek;

class FacilitySchedule extends DailySchedule
{
    public static function fromArray(array $data): self
    {
        $expectedKeys = ['id', 'day', 'open_time', 'close_time', 'break_start_time', 'break_end_time'];

        check_array_keys($expectedKeys, $data, class_basename(self::class));

        return new self(
            $data['id'],
            DayOfWeek::from($data['day']),
            Carbon::parse($data['open_time']),
            Carbon::parse($data['close_time']),
            $data['break_start'] ? Carbon::parse($data['breakStart']) : null,
            $data['break_end'] ? Carbon::parse($data['breakEnd']) : null,
        );
    }
    #endregion
}