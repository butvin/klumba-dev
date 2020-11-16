<?php
//declare (strict_types=1);

use Kl\User;
use Kl\UserPaymentsService;

require_once 'vendor/autoload.php';

$userPaymentService = new UserPaymentsService();

$testData = require_once 'test-data.php';
var_dump($testData);
echo "<hr>";

foreach ($testData as $testDataRow) {
    var_dump($testDataRow);
    list($userData, $userAmount) = $testDataRow;

    $userModel = new User($userData['id'], $userData['balance'], $userData['email']);
    var_dump($userModel);
    try {
        $userPaymentService->changeBalance($userModel, $userAmount);
        $expectedBalance = $userData['balance'] + $userAmount;
        $resultBalance = $userModel->balance;
        $info = sprintf('User balance should be updated %s: %s', $expectedBalance, $expectedBalance);

        $result = assert($expectedBalance === $resultBalance, $info);
    } catch (\Exception $e) {
        $result = false;
        $info = sprintf('User balance should be updated, exception: %s', $e->getMessage());
    }

    echo sprintf("[%s] %s\n", $result ? 'SUCCESS' : 'FAIL', $info);
}