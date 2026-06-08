<?php

namespace App\Data\Medic;

use App\Data\Value\Medic\DosageForm;
use App\Data\Value\Medic\MedicineClass;
use InvalidArgumentException;

class Medicine
{
    #region FIELDS
    private int $id;
    private string $name;
    private DosageForm $dosageForm;
    private MedicineClass $medicineClass;
    private string $description;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        string $name,
        DosageForm $dosageForm,
        MedicineClass $medicineClass,
        string $description
    ) {
        $this->setId($id);
        $this->setName($name);
        $this->setDosageForm($dosageForm);
        $this->setMedicineClass($medicineClass);
        $this->setDescription($description);
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

    public function getDosageForm(): DosageForm
    {
        return $this->dosageForm;
    }

    public function getMedicineClass(): MedicineClass
    {
        return $this->medicineClass;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setName(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Medicine name cannot be empty.');
        }
        $this->name = $value;
    }

    public function setDosageForm(DosageForm $value): void
    {
        $this->dosageForm = $value;
    }

    public function setMedicineClass(MedicineClass $value): void
    {
        $this->medicineClass = $value;
    }

    public function setDescription(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Medicine description cannot be empty.');
        }
        $this->description = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id'             => $this->getId(),
            'name'           => $this->getName(),
            'dosage_form'    => $this->getDosageForm()->value,
            'medicine_class' => $this->getMedicineClass()->value,
            'description'    => $this->getDescription(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $expectedKeys = ['id', 'name', 'dosage_form', 'medicine_class', 'description'];

        check_array_keys(
            $expectedKeys,
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            (string) $data['name'],
            DosageForm::from($data['dosage_form']),
            MedicineClass::from($data['medicine_class']),
            (string) $data['description']
        );
    }
    #endregion
}