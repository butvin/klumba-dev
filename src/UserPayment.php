<?php

namespace Kl;

class UserPayment
{
    /**
     * Users id variable.
     *
     * @var int
     */
    public int $userId;

    public string $paymentType;
    /**
     * Users balance before transaction.
     *
     * @var float
     */
    public float $userBalanceBefore;

    /**
     * Incoming bill amount.
     *
     * @var float
     */
    public float $incomingAmount;

    public ?int $id;

    public function __construct(
        int $userId,
        string $paymentType,
        float $userBalanceBefore,
        float $incomingAmount,
        $id = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->paymentType = $paymentType;
        $this->userBalanceBefore = $userBalanceBefore;
        $this->incomingAmount = $incomingAmount;
    }
}