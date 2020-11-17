<?php

namespace Kl;

class UserPaymentDbTable
{
    /**
     * Storage for users payments transactions.
     *
     * @var array
     */
    private array $storage = [];

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
