<?php

namespace Library\Email;
/*
 * In order to use swiftmailer the below is needed....
 */
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;


class Email {

    public $result = \NULL;

    public function __construct(array $data) {
        $this->result = $this->email($data);
    }

    private function email(array $data) {
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

        $name = $data['name'];
        $email_from = $data['email'];
        $subject = $data['reason'] . ' email address ' . $data['email'];
        $comments = $data['phone'] . ' ' . $data['website'] . ' ' . $data['comments'];

        /*
         * Email Address message is going to
         */
        $message->setTo([
           'joesmith@example.com' => 'Joe Smith'// Example email address:
        ]);

        $message->setSubject($subject); // Subject:
        $message->setBody($comments); // Message:
        $message->setFrom($email_from, $name); // From and Name:

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
