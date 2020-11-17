<?php

namespace Kl;

class UserPaymentsService
{
    private ?object $userPaymentsDbTable = null;
    private ?object $userDbTable = null;

    private static ?UserDbTable $_userDbTable = null;
    private static ?UserPaymentDbTable $_userPaymentsDbTable = null;
    private static ?UserPaymentsService $UserPaymentsService = null;

    /**
     * Get UserDbTable instance.
     */
    public static function getUserDbTableInstance()
    {
        return
            static::$_userDbTable === null ?
                new static() : static::$_userDbTable;
    }

    /**
     * Get UserPaymentsDbTable instance.
     */
    public static function getUserPaymentsDbTableInstance()
    {
        return
            static::$_userPaymentsDbTable === null ?
                new static() : static::$_userPaymentsDbTable;
    }

    /**
     * Gets the UserPaymentsService instance (created on first usage).
     */
    public static function getUserPaymentsServiceInstance(): UserPaymentsService
    {
        if (static::$UserPaymentsService === null) {
            static::$UserPaymentsService = new static();
        }

        return static::$UserPaymentsService;
    }

    public function getUserPaymentsDbTable()
    {
        return $this->userPaymentsDbTable ?? new UserPaymentDbTable();
    }

    public function getUserDbTable()
    {
        return $this->userDbTable ?? new UserDbTable();
    }

    public function calculateBalance(User $user, float $amount)
    {
        $userDbTable = $this->getUserDbTable();
        $userPaymentsDbTable = $this->getUserPaymentsDbTable();

        $userId = $user->id;
        $userBalance = $user->balance;
        $paymentType = $amount >= 0 ? 'in' : 'out';
        $paymentAmount = abs($amount);

        $payment = new UserPayment($userId, $paymentType, $userBalance, $paymentAmount);

        // add payment transaction
        if ( !$userPaymentsDbTable->add($payment->toArray()) ) {
            error_log(sprintf('Failed to add user balance'));
        }

        // refresh a balance amount
        $user->balance += $amount;

        try {
            // update user balance in db
            $userDbTable->update($user->toArray());
            // send email
            $this->sendEmail($user->email);
        } catch (\Exception $e) {
            return
                sprintf('User balance NOT updated, exception: %s', $e->getMessage());
        }

        return true;
    }

    /**
     * @param  string  $toEmail
     * @return bool
     */
    public function sendEmail(string $toEmail)
    {
        $from = 'admin@test.com';
        $subject = 'Balance update';
        $message = 'Hello! Your balance has been successfully updated!';
        $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($toEmail, $subject, $message, $headers);

        return true;
    }

//    private function __construct() {}
//    private function __clone() {}
//    private function __wakeup() {}

}
