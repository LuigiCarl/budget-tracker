<?php

namespace App\Mail;

use Illuminate\Mail\Transport\Transport;
use Mailtrap\Config;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

class MailtrapApiTransport extends AbstractTransport
{
    protected MailtrapClient $client;

    public function __construct()
    {
        parent::__construct();
        
        $apiKey = config('services.mailtrap.token');
        $this->client = new MailtrapClient(
            new Config($apiKey)
        );
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        $mailtrapEmail = (new MailtrapEmail())
            ->from(new Address(
                $email->getFrom()[0]->getAddress(),
                $email->getFrom()[0]->getName() ?? ''
            ))
            ->subject($email->getSubject() ?? '');

        // Add recipients
        foreach ($email->getTo() as $to) {
            $mailtrapEmail->addTo(new Address($to->getAddress(), $to->getName() ?? ''));
        }

        // Add CC if present
        foreach ($email->getCc() as $cc) {
            $mailtrapEmail->addCc(new Address($cc->getAddress(), $cc->getName() ?? ''));
        }

        // Add BCC if present
        foreach ($email->getBcc() as $bcc) {
            $mailtrapEmail->addBcc(new Address($bcc->getAddress(), $bcc->getName() ?? ''));
        }

        // Set email body
        if ($email->getHtmlBody()) {
            $mailtrapEmail->html($email->getHtmlBody());
        }
        
        if ($email->getTextBody()) {
            $mailtrapEmail->text($email->getTextBody());
        }

        // Send via Mailtrap API
        $this->client->sending()->emails()->send($mailtrapEmail);
    }

    public function __toString(): string
    {
        return 'mailtrap+api';
    }
}
