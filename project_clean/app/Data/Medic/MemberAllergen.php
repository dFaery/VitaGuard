<?php

namespace App\Data\Medic;

use InvalidArgumentException;
use App\Data\Account\User;
use App\Data\Value\Medic\AllergenSeverity;

class MemberAllergen
{
    #region PROPERTIES
    private int $id;
    private Allergen $allergen;
    private string $description;
    private AllergenSeverity $severity;
    private string $notes;
    private User $creator;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        Allergen $allergen,
        string $description,
        AllergenSeverity $severity,
        string $notes,
        User $creator
    ) {
        $this->setId($id);
        $this->setAllergen($allergen);
        $this->setDescription($description);
        $this->setSeverity($severity);
        $this->setNotes($notes);
        $this->setCreator($creator);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getAllergen(): Allergen
    {
        return $this->allergen;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSeverity(): AllergenSeverity
    {
        return $this->severity;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setAllergen(Allergen $value): void
    {
        $this->allergen = $value;
    }

    public function setDescription(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Description cannot be empty.');
        }
        if (mb_strlen($value) > config('data.max_name_length')) {
            throw new InvalidArgumentException('Description cannot exceed ' . config('data.max_name_length') . ' characters.');
        }
        $this->description = $value;
    }

    public function setSeverity(AllergenSeverity $value): void
    {
        $this->severity = $value;
    }

    public function setNotes(string $value): void
    {
        $this->notes = $value;
    }

    public function setCreator(User $value): void
    {
        $this->creator = $value;
    }
    #endregion

    #region UTILITIES
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'allergen' => $this->getAllergen()->toArray(),
            'description' => $this->getDescription(),
            'severity' => $this->getSeverity()->value,
            'notes' => $this->getNotes(),
            'creator' => $this->getCreator()->toArray(),
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
            $data['id'],
            Allergen::fromArray($data['allergen']),
            $data['description'],
            AllergenSeverity::from($data['severity']),
            $data['notes'],
            User::fromArray($data['creator'])
        );
    }
    #endregion
}