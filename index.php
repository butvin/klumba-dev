<?php

declare (strict_types=1);

/**
 * Composer
 */
require_once 'vendor/autoload.php';

/**
 * Test file with transactions data.
 */
$testData = require_once 'test-data.php';

/**
 * Get payment service instance
 * @var Kl\UserPaymentsService
 */
$userPaymentService = Kl\UserPaymentsService::getUserPaymentsService();

$transactions = $userPaymentService::getUserPaymentsDbTable()->getStorage();

//var_dump($transactions);
//foreach ($transactions as $transactionItem) {
//    var_dump($transactionItem);
//}

/**
 * Fetch test transactions data.
 */
foreach ($testData as $key => $testDataRow) {
    try {
        list($userData, $amount) = $testDataRow;

        $balanceBefore = $userData['balance'] ? $userData['balance'] : null;

        $expectedBalance = $balanceBefore + $amount;

        /**
         * Create users object from input test transaction data.
         */
        $user = new Kl\User(
            $userData['id'],
            $userData['balance'],
            $userData['email']
        );

        $userPaymentService->changeBalance($user, $amount);

        $info = sprintf('User balance should be updated: %g [amount: %g, before: %g, current: %g]',
            $user->getBalance(),
            $amount,
            $balanceBefore,
            $user->getBalance() === $expectedBalance ? $user->getBalance() : null
        );

        $result = assert($expectedBalance === $user->getBalance(), $info);
    } catch (\Exception $e) {
        $result = null;
        $info = sprintf('User balance should be updated, exception: %s', $e->getMessage());
    }

    echo sprintf("[%s] %s\n", $result ? 'SUCCESS' : 'FAIL', $info)."<br />";
}

$transactions = $userPaymentService::getUserPaymentsDbTable()->getStorage();
$userPaymentService->drawTransTable($transactions);
