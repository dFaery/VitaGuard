<?php

namespace App\Data\Medic;

use App\Data\Account\Doctor;
use App\Data\Account\Member;
use App\Data\Service\Appointment;
use App\Data\Service\Consultation;
use InvalidArgumentException;

class Prescription
{
    #region FIELDS
    private int $id;
    private Member $patient;
    private Doctor $doctor;
    private string $notes;
    private ?Appointment $appointment;
    private ?Consultation $consultation;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        Member $patient,
        Doctor $doctor,
        string $notes,
        ?Appointment $appointment = null,
        ?Consultation $consultation = null
    ) {
        $this->setId($id);
        $this->setPatient($patient);
        $this->setDoctor($doctor);
        $this->setNotes($notes);
        $this->setAppointment($appointment);
        $this->setConsultation($consultation);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getPatient(): Member
    {
        return $this->patient;
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getAppointment(): ?Appointment
    {
        return $this->appointment;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setPatient(Member $value): void
    {
        $this->patient = $value;
    }

    public function setDoctor(Doctor $value): void
    {
        $this->doctor = $value;
    }

    public function setNotes(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Prescription notes cannot be empty.');
        }
        $this->notes = $value;
    }

    public function setAppointment(?Appointment $value): void
    {
        $this->appointment = $value;
    }

    public function setConsultation(?Consultation $value): void
    {
        $this->consultation = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id'           => $this->getId(),
            'patient'      => $this->getPatient()->toArray(),
            'doctor'       => $this->getDoctor()->toArray(),
            'notes'        => $this->getNotes(),
            'appointment'  => $this->getAppointment()?->toArray(),
            'consultation' => $this->getConsultation()?->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $expectedKeys = ['id', 'patient', 'doctor', 'notes', 'appointment', 'consultation'];

        check_array_keys(
            $expectedKeys,
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            Member::fromArray($data['patient']),
            Doctor::fromArray($data['doctor']),
            (string) $data['notes'],
            !empty($data['appointment']) ? Appointment::fromArray($data['appointment']) : null,
            !empty($data['consultation']) ? Consultation::fromArray($data['consultation']) : null
        );
    }
    #endregion
}