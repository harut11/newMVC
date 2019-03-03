<?php

namespace root;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mailer
{
    private $user_email;
    private $token;

    public function __construct($email, $token)
    {
        $this->user_email = $email;
        $this->token = $token;
    }

    public function sendEmail()
    {
        require BASE_PATH . SEPARATOR . 'vendor/autoload.php';
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '2d3a8fd5f267af';
            $mail->Password = 'c05b56ef0a416d';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Recipients
            $mail->setFrom('admin@newmvc.local', 'Admin');
            $mail->addAddress($this->user_email);

//            //Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');
//            $mail->addAttachment('/tmp/image.jpg');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Verification Email';
            $mail->Body    = 'Please verify your email <a href="http://newmvc.local/verify?token='. $this->token .'" >there</a> on this link!';
            return $mail->send();
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: ';
        }
    }
}