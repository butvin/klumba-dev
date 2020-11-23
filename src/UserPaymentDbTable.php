<?php

namespace Kl;

class UserPaymentDbTable implements \Kl\DbTable
{
    /**
     * Storage for users payments transactions.
     *
     * @var array
     */
    private array $storage = [
        // [666, 'in', 666.66, -111.11, 999]
    ];

    /**
     * Gets storage data.
     *
     * @return array
     */
    public function getStorage() :array
    {
        return $this->storage;
    }

    /**
     * @param  array  $payment
     * @return bool
     */
    public function add(array $payment)
    {
        if (empty($payment['id'])) {
            $payment['id'] = count($this->getStorage()) + 1;
        }

        return
            ($this->storage[] = $payment) ? true : false;
    }
}
