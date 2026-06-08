<?php

namespace App\Data\Service;

use App\Data\Value\Schedule\ScheduleType;
use InvalidArgumentException;

class WeeklySchedule
{
    #region FIELDS
    private ?array $schedules = null;
    #endregion

    #region CONSTRUCTOR
    public function __construct(?array $schedules = null)
    {
        $this->setSchedules($schedules);
    }
    #endregion

    #region GETTERS
    public function getSchedules(): ?array
    {
        return $this->schedules;
    }
    #endregion

    #region SETTERS
    public function setSchedules(?array $value): void
    {
        if ($value === null) {
            $this->schedules = null;
            return;
        }
        
        $this->schedules = [];
        foreach ($value as $item) {
            if (!$item instanceof DailySchedule) {
                throw new InvalidArgumentException('All items in schedules must be instances of DailySchedule.');
            }
            $this->addSchedule($item);
        }
    }

    public function addSchedule(DailySchedule $newSchedule): void
    {
        if ($this->schedules === null) {
            $this->schedules = [];
        }
        $this->checkAllOverlap($newSchedule);
        $this->schedules[$newSchedule->getDay()->value][] = $newSchedule;
    }
    #endregion

    #region UTILS
    private function checkAllOverlap(DailySchedule $newSchedule): void
    {
        if ($this->schedules === null) {
            return;
        }

        $dayValue = $newSchedule->getDay()->value;
        if (!isset($this->schedules[$dayValue])) {
            return;
        }
        foreach ($this->schedules[$dayValue] as $old) {
            if ($this->checkOverlap($newSchedule, $old)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'The schedule overlaps with an existing time slot on %s (%s - %s).',
                        $old->getDay()->value,
                        $old->getOpen()->toTimeString(),
                        $old->getClose()->toTimeString()
                    )
                );
            }
        }
    }

    private function checkOverlap(DailySchedule $new, DailySchedule $old): bool
    {
        if ($new->getDay() !== $old->getDay()) {
            return false;
        }
        $oldOpen  = $old->getOpen()->toTimeString();
        $oldClose = $old->getClose()->toTimeString();
        $newOpen  = $new->getOpen()->toTimeString();
        $newClose = $new->getClose()->toTimeString();
        return ($newOpen < $oldClose && $newClose > $oldOpen);
    }

    public function toArray(): array
    {
        if ($this->schedules === null) {
            return ['schedules' => null];
        }

        $flatSchedules = [];
        foreach ($this->schedules as $dayGroup) {
            foreach ($dayGroup as $schedule) {
                $flatSchedules[] = $schedule->toArray();
            }
        }

        return [
            'schedules' => $flatSchedules
        ];
    }

    public static function fromArray(array $data, ScheduleType $type): self
    {
        $expectedKeys = ['schedules'];
        
        check_array_keys(
            $expectedKeys,
            $data,
            class_basename(self::class)
        );

        if ($data['schedules'] === null) {
            return new self(null);
        }

        $class = $type->getClass();
        $schedules = [];

        foreach ($data['schedules'] as $scheduleData) {
            $schedules[] = $class::fromArray($scheduleData);
        }
        
        return new self($schedules);
    }
    #endregion
}