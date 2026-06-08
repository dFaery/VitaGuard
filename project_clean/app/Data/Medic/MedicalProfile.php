<?php

namespace App\Data\Medic;

use Carbon\Carbon;
use App\Data\Account\User;
use App\Data\Account\Member;
use App\Data\Value\Medic\AlcoholConsumption;
use App\Data\Value\Medic\BloodType;
use App\Data\Value\Medic\SmokingStatus;
use InvalidArgumentException;

class MedicalHistory
{
    #region PROPERTIES
    private int $id;
    private string $description;
    private BloodType $bloodType;
    private float $height;
    private float $weight;
    private SmokingStatus $smokingStatus;
    private AlcoholConsumption $alcoholConsumption;
    private User $creator;
    private Member $patient;
    private Carbon $diagnosedDate;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        string $description,
        BloodType $bloodType,
        float $height,
        float $weight,
        SmokingStatus $smokingStatus,
        AlcoholConsumption $alcoholConsumption,
        User $creator,
        Member $patient,
        Carbon $diagnosedDate
    ) {
        $this->setId($id);
        $this->setDescription($description);
        $this->setBloodType($bloodType);
        $this->setHeight($height);
        $this->setWeight($weight);
        $this->setSmokingStatus($smokingStatus);
        $this->setAlcoholConsumption($alcoholConsumption);
        $this->setCreator($creator);
        $this->setPatient($patient);
        $this->setDiagnosedDate($diagnosedDate);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBloodType(): BloodType
    {
        return $this->bloodType;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getSmokingStatus(): SmokingStatus
    {
        return $this->smokingStatus;
    }

    public function getAlcoholConsumption(): AlcoholConsumption
    {
        return $this->alcoholConsumption;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function getPatient(): Member
    {
        return $this->patient;
    }

    public function getDiagnosedDate(): Carbon
    {
        return $this->diagnosedDate;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('ID must be a positive integer.');
        }
        $this->id = $value;
    }

    public function setDescription(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Description cannot be empty.');
        }
        $this->description = $value;
    }

    public function setBloodType(BloodType $value): void
    {
        $this->bloodType = $value;
    }

    public function setHeight(float $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Height must be greater than zero.');
        }
        $this->height = $value;
    }

    public function setWeight(float $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Weight must be greater than zero.');
        }
        $this->weight = $value;
    }

    public function setSmokingStatus(SmokingStatus $value): void
    {
        $this->smokingStatus = $value;
    }

    public function setAlcoholConsumption(AlcoholConsumption $value): void
    {
        $this->alcoholConsumption = $value;
    }

    public function setCreator(User $value): void
    {
        $this->creator = $value;
    }

    public function setPatient(Member $value): void
    {
        $this->patient = $value;
    }

    public function setDiagnosedDate(Carbon $value): void
    {
        $this->diagnosedDate = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return [
            'id'                 => $this->getId(),
            'description'        => $this->getDescription(),
            'bloodType'          => $this->getBloodType()->value,
            'height'             => $this->getHeight(),
            'weight'             => $this->getWeight(),
            'smokingStatus'      => $this->getSmokingStatus()->value,
            'alcoholConsumption' => $this->getAlcoholConsumption()->value,
            'creator'            => $this->getCreator()->toArray(),
            'patient'            => $this->getPatient()->toArray(),
            'diagnosedDate'      => $this->getDiagnosedDate()->toDateTimeString(),
        ];
    }

    public static function fromArray(array $data): self
    {
        check_array_keys(
            array_keys(get_class_vars(self::class)),
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            $data['description'],
            BloodType::from($data['bloodType']),
            (float) $data['height'],
            (float) $data['weight'],
            SmokingStatus::from($data['smokingStatus']),
            AlcoholConsumption::from($data['alcoholConsumption']),
            User::fromArray($data['creator']), 
            Member::fromArray($data['patient']),
            Carbon::parse($data['diagnosedDate'])
        );
    }
    #endregion
}