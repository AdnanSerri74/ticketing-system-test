<?php

namespace app\Notifications\Drivers;

use app\Notifications\Driver;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailDriver extends Driver
{
    protected PHPMailer $mailer;

    public function setup(): MailDriver
    {
        $this->mailer = new PHPMailer();

        $this->mailer->SMTPDebug = 0;
        $this->mailer->SMTPAuth = true;
        $this->mailer->isSMTP();

        $this->mailer->Host = env('MAIL_HOST');
        $this->mailer->Username = env('MAIL_USERNAME');
        $this->mailer->Password = env('MAIL_PASSWORD');
        $this->mailer->SMTPSecure = env('MAIL_SMTP_SECURE');
        $this->mailer->Port = env('MAIL_PORT');
        $this->mailer->isHTML(true);

        return $this;
    }

    public function content(array $attributes): MailDriver
    {
        $this->mailer->setFrom(
            $attributes['from_address'],
            $attributes['from_name']
        );

        foreach ($attributes['to_address'] as $address)
            $this->mailer->addAddress($address);

        $this->mailer->Subject = $attributes['subject'];
        $this->mailer->Body = $attributes['body'];

        return $this;
    }

    public function process(): bool
    {
        try {
            $this->mailer->send();
            return true;
        } catch (Exception) {
            return false;
        }
    }
}