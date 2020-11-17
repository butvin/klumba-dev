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
}