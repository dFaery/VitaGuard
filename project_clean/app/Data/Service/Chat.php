<?php

namespace App\Data\Service;

use App\Models\User;
use Carbon\Carbon;
use InvalidArgumentException;

class Chat
{
    #region FIELDS
    private int $id;
    private string $message;
    private ?User $sender;
    #endregion

    #region CONSTRUCTOR
    public function __construct(
        int $id,
        string $message,
        ?User $sender = null
    ) {
        $this->setId($id);
        $this->setMessage($message);
        $this->setSender($sender);
    }
    #endregion

    #region GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }
    #endregion

    #region SETTERS
    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function setMessage(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Chat message cannot be empty.');
        }
        $this->message = $value;
    }

    public function setSender(?User $value): void
    {
        $this->sender = $value;
    }
    #endregion

    #region UTILS
    public function toArray(): array
    {
        return [
            'id'      => $this->getId(),
            'message' => $this->getMessage(),
            'sender'  => $this->getSender()?->toArray(),
        ];
    }

    public static function fromArray(array $data): self
    {
        $expectedKeys = ['id', 'message', 'sender'];

        check_array_keys(
            $expectedKeys,
            $data,
            class_basename(self::class)
        );

        return new self(
            (int) $data['id'],
            (string) $data['message'],
            !empty($data['sender']) ? User::fromArray($data['sender']) : null
        );
    }
    #endregion
}