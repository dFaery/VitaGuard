<?php

namespace App\Data\Medic\PrescriptionDetail;

use Carbon\Carbon;
use App\Data\Medic\Medicine;
use App\Data\Service\Facility;
use InvalidArgumentException;

class PrescriptionDetail
{
    #region FIELDS
    private int $id;
    private Medicine $medicine;
    private int $quantity;
    private Carbon $start;
    private Carbon $end;
    private Carbon $taken;
    private Facility $takenAt;
    private string $instructions;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        Medicine $medicine,
        int $quantity,
        Carbon $start,
        Carbon $end,
        Carbon $taken,
        Facility $takenAt,
        string $instructions
    ) {
        $this->setId($id);
        $this->setMedicine($medicine);
        $this->setQuantity($quantity);
        $this->setStart($start);
        $this->setEnd($end);
        $this->setTaken($taken);
        $this->setTakenAt($takenAt);
        $this->setInstructions($instructions);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getMedicine(): Medicine
    {
        return $this->medicine;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getStart(): Carbon
    {
        return $this->start;
    }

    public function getEnd(): Carbon
    {
        return $this->end;
    }

    public function getTaken(): Carbon
    {
        return $this->taken;
    }

    public function getTakenAt(): Facility
    {
        return $this->takenAt;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }
    #endregion

    #region SETTERS
    public function setId(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('ID must be a positive integer.');
        }
        $this->id = $id;
    }

    public function setMedicine(Medicine $medicine): void
    {
        $this->medicine = $medicine;
    }

    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException('Quantity cannot be negative.');
        }
        $this->quantity = $quantity;
    }

    public function setStart(Carbon $start): void
    {
        $this->start = $start;
    }

    public function setEnd(Carbon $end): void
    {
        if (isset($this->start) && $end->lessThan($this->start)) {
            throw new InvalidArgumentException('End date cannot be before the start date.');
        }
        $this->end = $end;
    }

    public function setTaken(Carbon $taken): void
    {
        $this->taken = $taken;
    }

    public function setTakenAt(Facility $takenAt): void
    {
        $this->takenAt = $takenAt;
    }

    public function setInstructions(string $instructions): void
    {
        $trimmed = trim($instructions);
        if (empty($trimmed)) {
            throw new InvalidArgumentException('Instructions cannot be empty.');
        }
        $this->instructions = $trimmed;
    }
    #endregion

    #region UTILITIES
    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? 0),
            $data['medicine'] instanceof Medicine ? $data['medicine'] : Medicine::fromArray($data['medicine'] ?? []),
            (int)($data['quantity'] ?? 0),
            $data['start'] instanceof Carbon ? $data['start'] : Carbon::parse($data['start'] ?? 'now'),
            $data['end'] instanceof Carbon ? $data['end'] : Carbon::parse($data['end'] ?? 'now'),
            $data['taken'] instanceof Carbon ? $data['taken'] : Carbon::parse($data['taken'] ?? 'now'),
            $data['takenAt'] instanceof Facility ? $data['takenAt'] : Facility::fromArray($data['takenAt'] ?? []),
            (string)($data['instructions'] ?? '')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'medicine' => $this->medicine->toArray(),
            'quantity' => $this->quantity,
            'start' => $this->start->toDateString(),
            'end' => $this->end->toDateString(),
            'taken' => $this->taken->toDateTimeString(),
            'takenAt' => $this->takenAt->toArray(),
            'instructions' => $this->instructions,
        ];
    }
    #endregion
}