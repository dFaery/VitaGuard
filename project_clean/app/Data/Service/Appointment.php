<?php

namespace App\Data\Service;

use App\Data\Account\Doctor;
use App\Data\Account\Member;
use App\Data\Value\Schedule\AppointmentStatus;
use Carbon\Carbon;
use InvalidArgumentException;

class Appointment
{
    #region FIELDS
    private int $id;
    private Doctor $doctor;
    private Member $patient;
    private Carbon $date;
    private Carbon $time;
    private int $queueOrder;
    private AppointmentStatus $status;
    private ?string $notes;
    private ?Carbon $checkInTime;
    private ?Carbon $completedTime;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        Doctor $doctor,
        Member $patient,
        Carbon $date,
        Carbon $time,
        int $queueOrder,
        AppointmentStatus $status,
        ?string $notes = null,
        ?Carbon $checkInTime = null,
        ?Carbon $completedTime = null
    ) {
        $this->setId($id);
        $this->setDoctor($doctor);
        $this->setPatient($patient);
        $this->setDate($date);
        $this->setTime($time);
        $this->setQueueOrder($queueOrder);
        $this->setStatus($status);
        $this->setNotes($notes);
        $this->setCheckInTime($checkInTime);
        $this->setCompletedTime($completedTime);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function getPatient(): Member
    {
        return $this->patient;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getTime(): Carbon
    {
        return $this->time;
    }

    public function getQueueOrder(): int
    {
        return $this->queueOrder;
    }

    public function getStatus(): AppointmentStatus
    {
        return $this->status;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getCheckInTime(): ?Carbon
    {
        return $this->checkInTime;
    }

    public function getCompletedTime(): ?Carbon
    {
        return $this->completedTime;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setDoctor(Doctor $value): void
    {
        $this->doctor = $value;
    }

    public function setPatient(Member $value): void
    {
        $this->patient = $value;
    }

    public function setDate(Carbon $value): void
    {
        $this->date = $value;
    }

    public function setTime(Carbon $value): void
    {
        $this->time = $value;
    }

    public function setQueueOrder(int $value): void
    {
        if ($value < 1) {
            throw new InvalidArgumentException("Queue order must be a positive integer.");
        }
        $this->queueOrder = $value;
    }

    public function setStatus(AppointmentStatus $value): void
    {
        $this->status = $value;
    }

    public function setNotes(?string $value): void
    {
        $this->notes = $value;
    }

    public function setCheckInTime(?Carbon $value): void
    {
        if ($value !== null && $value < $this->date) {
            throw new InvalidArgumentException("Check-in time cannot be earlier than the appointment date.");
        }
        $this->checkInTime = $value;
    }

    public function setCompletedTime(?Carbon $value): void
    {
        if ($value !== null) {
            if ($this->checkInTime !== null && $value < $this->checkInTime) {
                throw new InvalidArgumentException("Completion time cannot be earlier than check-in time.");
            }
            if ($value < $this->date) {
                throw new InvalidArgumentException("Completion time cannot be earlier than the appointment date.");
            }
        }
        $this->completedTime = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id'             => $this->getId(),
            'doctor'         => $this->getDoctor()->toArray(),
            'patient'        => $this->getPatient()->toArray(),
            'date'           => $this->getDate()->toDateString(),
            'time'           => $this->getTime()->toTimeString(),
            'queue_order'    => $this->getQueueOrder(),
            'status'         => $this->getStatus()->value,
            'notes'          => $this->getNotes(),
            'check_in_time'  => $this->getCheckInTime()?->toDateTimeString(),
            'completed_time' => $this->getCompletedTime()?->toDateTimeString(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $expectedKeys = [
            'id',
            'doctor',
            'patient',
            'date',
            'time',
            'queue_order',
            'status',
            'notes',
            'check_in_time',
            'completed_time'
        ];

        check_array_keys(
            $expectedKeys,
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            Doctor::fromArray($data['doctor']),
            Member::fromArray($data['patient']),
            Carbon::parse($data['date']),
            Carbon::parse($data['time']),
            (int) $data['queue_order'],
            AppointmentStatus::from($data['status']),
            isset($data['notes']) ? (string) $data['notes'] : null,
            !empty($data['check_in_time']) ? Carbon::parse($data['check_in_time']) : null,
            !empty($data['completed_time']) ? Carbon::parse($data['completed_time']) : null
        );
    }
    #endregion
}