<?php

namespace Kl;

trait AppHelper
{
    /**
     * Send email to address.
     *
     * @param  string  $toUserEmail
     * @return bool
     */
    public function sendEmail(string $toUserEmail)
    {
        $from = 'admin@test.com';
        $subject = 'Balance update';
        $message = 'Hello! Your balance has been successfully updated!';
        $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($toUserEmail, $subject, $message, $headers);

        return true;
    }

    /**
     * Draw transactions table
     *
     * @param $transactions
     *
     * @return void
     */
    public function drawTransactionsTable(array $transactions) :void
    {
        echo "<br><hr>";

        if (empty($transactions)) {
            echo "<p>There are no transactions</p>";
            return;
        }

        echo "
        <table id='result'>
            <thead>
                <tr>
                    <th>id</th>
                    <th>user id</th>
                    <th>payment type</th>
                    <th>balance, before transaction</th>
                    <th>bill, decimal</th>
                </tr>
            </thead>
            <tbody>
    ";

        foreach ($transactions as $transactionItem) {
            echo '<tr class="transaction-row">';
            echo "<td>".$transactionItem['id']."</td>";
            echo "<td>".$transactionItem['user_id']."</td>";
            echo "<td>".$transactionItem['payment_type']."</td>";
            echo "<td>".$transactionItem['user_balance_before']."</td>";
            echo "<td>".$transactionItem['incoming_amount']."</td>";
            echo '</tr>';
        }

        echo "</tbody></table>";
        echo "<hr><br>";
    }
}