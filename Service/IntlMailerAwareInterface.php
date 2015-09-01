<?php

namespace FourLabs\HostsBundle\Service;

interface IntlMailerAwareInterface
{
    public function setMailer(\Swift_Mailer $mailer);

    public function setMailerSenderAddress($fromEmail);
}
