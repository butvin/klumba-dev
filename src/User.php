<?php

namespace Kl;

class User
{
    /**
     * @var int
     */
    public int $id;
    private float $balance;
    private string $email;

    public function __construct(int $id, float $balance, string $email)
    {
        $this->id = $id;
        $this->balance = $balance;
        $this->email = $email;
    }

    public function getBalance() :float
    {
        return $this->balance;
    }

    public function setBalance(float $balance) :float
    {
        return $this->balance = $balance;
    }

    public function getEmail() :string
    {
        return $this->email;
    }

    public function setEmail(string $email) :string
    {
        return $this->email = $email;
    }
}
