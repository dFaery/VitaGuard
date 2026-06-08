<?php

namespace App\Data\Medic;

use InvalidArgumentException;

class Specialty {
    #region PROPERTIES
    private int $id;
    private string $name;
    #endregion

    #region CONSTRUCT
    public function __construct(int $id, string $name) {
        $this->setId($id);
        $this->setName($name);
    }
    #endregion

    #region GETTERS
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void {
        if ($value <= 0) {
            throw new InvalidArgumentException('Specialty ID must be a positive integer.');
        }
        $this->id = $value;
    }

    public function setName(string $value): void {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Specialty name cannot be empty.');
        }
        $this->name = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }

    public static function fromArray(array $data): self {
        return new self(
            $data['id'],
            $data['name']
        );
    }
    #endregion
}