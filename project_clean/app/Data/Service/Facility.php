<?php

namespace App\Data\Service;

use App\Data\Location\Address;
use App\Data\Service\FacilitySchedule;
use InvalidArgumentException;

class Facility
{
    #region FIELDS
    private int $id;
    private string $name;
    private Address $address;
    private string $phoneNumber;
    private float $rating;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        string $name,
        Address $address,
        string $phoneNumber,
        float $rating
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setAddress($address);
        $this->setPhoneNumber($phoneNumber);
        $this->setRating($rating);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getRating(): float
    {
        return $this->rating;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Facility ID must be a positive integer.');
        }
        $this->id = $value;
    }

    public function setName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Facility Name cannot be empty.');
        }
        $this->name = $value;
    }

    public function setAddress(Address $value): void
    {
        $this->address = $value;
    }

    public function setPhoneNumber(string $value): void
    {
        $value = trim($value);
        $maxLength = config("data.max_phone_number_length");
        $pattern = config("regex.phone_number");
        if (empty($value)) {
            throw new InvalidArgumentException("Phone Number cannot be empty.");
        }
        if (!preg_match($pattern, $value)) {
            throw new InvalidArgumentException('Invalid Phone Number format.');
        }
        if (mb_strlen($value) > $maxLength) {
            throw new InvalidArgumentException("Phone Number cannot exceed {$maxLength} characters.");
        }
        $this->phoneNumber = $value;
    }

    public function setRating(float $value): void
    {
        if ($value < 0.0 || $value > 5.0) {
            throw new InvalidArgumentException('Rating must be between 0.0 and 5.0.');
        }
        $this->rating = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'address' => $this->getAddress()->toArray(),
            'phone_number' => $this->getPhoneNumber(),
            'rating' => $this->getRating(),
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
            $data['name'],
            Address::fromArray($data['address']),
            $data['phone_number'],
            (float) $data['rating']
        );
    }
    #endregion
}