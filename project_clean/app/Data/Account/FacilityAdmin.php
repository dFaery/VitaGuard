<?php

namespace App\Data\Account;

use App\Data\Service\Facility;
use App\Data\Value\Account\Role;
use App\Data\Value\Account\Status;

class FacilityAdmin extends User
{
    #region FIELDS
    private Facility $facility;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        string $username,
        string $email,
        string $phoneNumber,
        Facility $facility,
        Status $status
    ) {
        parent::__construct($username, $email, $phoneNumber, Role::FACILITY_ADMIN, $status);
        $this->setFacility($facility);
    }
    #endregion

    #region GETTERS
    public function getFacility(): Facility
    {
        return $this->facility;
    }
    #endregion

    #region SETTERS
    public function setFacility(Facility $value): void
    {
        $this->facility = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'facility' => $this->getFacility()->toArray(),
        ]);
    }

    public static function fromArray(array $data): self
    {
        check_array_keys(
            array_keys(get_class_vars(self::class)),
            $data,
            class_basename(self::class)
        );

        return new self(
            $data['username'],
            $data['email'],
            $data['phoneNumber'],
            Facility::fromArray($data['facility']),
            Status::from($data['status'])
        );
    }
    #endregion
}