<?php

namespace Kl;

final class UserPaymentsService
{
    /**
     * Use necessary traits.
     */
    use \Kl\AppHelper;
    use \Kl\DataConversion;

    /**
     * Storage for users table rows.
     *
     * @var UserDbTable|null
     */
    private static ?\Kl\UserDbTable $userDbTable = null;

    /**
     * Storage for payments table rows.
     *
     * @var UserPaymentDbTable|null
     */
    private static ?\Kl\UserPaymentDbTable $userPaymentsDbTable = null;

    /**
     * @var UserPaymentsService|null
     */
    private static ?\Kl\UserPaymentsService $userPaymentsService = null;

    /**
     * Gets UserDbTable instance via lazy initialization (created on first usage)
     *
     * @return UserDbTable
     */
    public static function getUserDbTable() :UserDbTable
    {
        if (static::$userDbTable === null) {
            static::$userDbTable = new UserDbTable();
        }

        return static::$userDbTable;
    }

    /**
     * Gets payments transaction table records.
     *
     * @return UserPaymentDbTable
     */
    public static function getUserPaymentsDbTable() :UserPaymentDbTable
    {
        if (static::$userPaymentsDbTable === null) {
            static::$userPaymentsDbTable = new UserPaymentDbTable();
        }

        return static::$userPaymentsDbTable;
    }

    /**
     * Gets the UserPaymentsService instance (created on first usage).
     */
    public static function getUserPaymentsService(): UserPaymentsService
    {
        if (static::$userPaymentsService === null) {
            static::$userPaymentsService = new UserPaymentsService();
        }

        return static::$userPaymentsService;
    }

    /**
     * Update users balance.
     *
     * @param  User  $user
     * @param  float  $amount
     * @return bool|string
     */
    public function changeBalance(\Kl\User $user, float $amount)
    {
        try {
            // gets users & transactions records
            $usersStorage = self::getUserDbTable();
            $paymentsStorage = self::getUserPaymentsDbTable();

            // create payment record
            $payment = new UserPayment(
                $user->id,
                $amount >= 0 ? 'in' : 'out',
                $user->getBalance(),
                abs($amount)
            );

            // add payment transaction
            $paymentsStorage->add($this->toArray($payment, 'underscore'));
            // var_dump($paymentsStorage->getStorage());

            // refresh a balance amount
            $user->setBalance($user->getBalance() + $amount);

            // update user balance in db
            $usersStorage->update($this->toArray($user));

            // send email
            $this->sendEmail($user->getEmail());
        } catch (\Exception $e) {
            return
                sprintf('User balance NOT updated. Exception: %s', $e->getMessage());
        }

        return true;
    }


    /**
     * UserPaymentsService constructor.
     * Is not allowed to call from outside
     * to prevent from creating multiple instances. To use instance, call
     * Kl\UserPaymentsService::getUserPaymentsService() instead.
     */
    private function __construct() {}

    /**
     * Prevent the instance from being cloned.
     */
    private function __clone() {}

    /**
     * Prevent from being un serialized.
     */
    private function __wakeup() {}

}
