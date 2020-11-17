<?php

declare (strict_types=1);
/**
 *
 */
require_once 'vendor/autoload.php';

//$testData = require_once 'test-data.php';
$testData = require_once 'mock-payments-data.php';

$userPaymentService = Kl\UserPaymentsService::getUserPaymentsService();

foreach ($testData as $key => $testDataRow) {
    try {
        list($userData, $amount) = $testDataRow;
        $expectedBalance = $userData['balance'] + $amount;

        $user = new Kl\User(
            $userData['id'],
            $userData['balance'],
            $userData['email']
        );

        $userPaymentService->updateBalance($user, $amount);

        $info = sprintf('User balance should be updated: %g [amount: %g], [before: %g], [current: %g]',
            $user->getBalance(),
            $amount,
            $userData['balance'],
            $user->getBalance() === $expectedBalance ? $user->getBalance() : null
        );

        $result = assert($expectedBalance === $user->getBalance(), $info);
    } catch (\Exception $e) {
        $result = null;
        $info = sprintf('User balance should be updated, exception: %s', $e->getMessage());
    }

    echo sprintf("[%s] %s\n", $result ? 'SUCCESS' : 'FAIL', $info)."<br />";
}

$users = $userPaymentService::getUserPaymentsDbTable();
var_dump($users);