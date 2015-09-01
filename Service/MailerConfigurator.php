<?php

namespace FourLabs\HostsBundle\Service;

class MailerConfigurator
{
    private $mailerProvider;

    public function __construct(MailerProvider $mailerProvider)
    {
        $this->mailerProvider = $mailerProvider;
    }

    public function configure(IntlMailerAwareInterface $mailer)
    {
        $mailer->setMailer(
            $this->mailerProvider->getMailer()
        );

        $mailer->setMailerSenderAddress(
            $this->mailerProvider->getMailerSenderAddress()
        );
    }
}
