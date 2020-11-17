<?php
declare (strict_types=1);

require_once 'vendor/autoload.php';

$testData = require_once 'test-data.php';
$userPaymentService = new Kl\UserPaymentsService();

foreach ($testData as $key => $testDataRow) {
    try {
        list($userData, $amount) = $testDataRow;

        $user = new Kl\User($userData['id'], $userData['balance'], $userData['email']);

        $expectedBalance = $userData['balance'] + $amount;

        $userPaymentService->calculateBalance($user, $amount);

        $resultBalance = $user->balance;

        $info = sprintf('
            User balance should be updated: %g
            [amount: %g],
            [before: %g],
            [current: %g]',
            $expectedBalance,
            $amount,
            $userData['balance'],
            $expectedBalance === $resultBalance ? $resultBalance : null
        );

        $result = assert($expectedBalance === $resultBalance, $info);
    } catch (\Exception $e) {
        $result = null;
        $info = sprintf('User balance should be updated, exception: %s', $e->getMessage());
    }

    echo sprintf("[%s] %s\n", $result ? 'SUCCESS' : 'FAIL', $info)."<br />";
}