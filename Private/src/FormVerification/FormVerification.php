<?php

namespace Library\FormVerification;

/*
 * In order to use swiftmailer the below is needed....
 */

use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;

class FormVerification {

    public $comment = \NULL;
    public $confirmationNumber = \NULL;

    private function generate_confirmation_number() {
        $bytes = random_bytes(12); // length in bytes
        return bin2hex($bytes);
    }

    public function __construct() {
        
    }

    public function getConfirmationCode() {
        return $this->generate_confirmation_number();
    }

    public function sendEmailVerification(array $data) {
        /* Setup swiftmailer using your email server information */
        if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
            $transport = Swift_SmtpTransport::newInstance(EMAIL_HOST, EMAIL_PORT); // 25 for remote server 587 for localhost:
        } else {
            $transport = Swift_SmtpTransport::newInstance(EMAIL_HOST, 25);
        }

        $transport->setUsername(EMAIL_USERNAME);
        $transport->setPassword(EMAIL_PASSWORD);

        /* Setup To, From, Subject and Message */
        $message = Swift_Message::newInstance();

        $this->confirmationNumber = $this->generate_confirmation_number();


        if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") {
            /* Local Server (Testing Purposes) */
            $this->comment = "Thank you for taking your time and registering at Slice of Pi website.\n Please click or copy the full URL and paste it in your browser: http://localhost:8888/sliceofpi06212017/public/confirm.php?confirm_number=" . $this->confirmationNumber;
        } else {
            /* Web Server */
            $this->comment = "Thank you for taking your time and registering at Slice of Pi website.\n Please click or copy the full URL and paste it in your browser: https://www.pepster.com/confirm.php?confirm_number=" . $this->confirmationNumber;
        }


        $username = $data['username'];
        $email_to = $data['email'];
        $subject = "Email Account Verification Notice!";


        /*
         * Email Address message is going to
         */
        $message->setTo([
            $email_to => $username // Verification Email Address:
        ]);

        $message->setSubject($subject); // Subject:
        $message->setBody($this->comment); // Message:
        $message->setFrom('jrpepp@pepster.com', 'John Pepp'); // From and Name:

        $mailer = Swift_Mailer::newInstance($transport); // Setting up mailer using transport info that was provided:
        $result = $mailer->send($message, $failedRecipients);

        if ($result) {
            return TRUE;
        } else {
            echo "<pre>" . print_r($failedRecipients, 1) . "</pre>";
            return FALSE;
        }
    }

}
