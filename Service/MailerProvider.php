<?php

namespace FourLabs\HostsBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MailerProvider extends AbstractProvider implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the Container associated with this service.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    private function getContainer()
    {
        if(!($this->container instanceof ContainerInterface)) {
            throw new \RuntimeException('Container is missing');
        }
        return $this->container;
    }

    private function getMailerNameByCountryCode($countryCode)
    {
        if($domain = $this->domainRepository->findByCountry($countryCode)) {
            return $domain->getMailer();
        }

        return $this->domainRepository->findDefault()->getMailer();
    }

    public function getMailer()
    {
        if(!($name = $this->getDomainConfig()->getMailer())) {
            return;
        }

        return $this->getContainer()->get(
            sprintf('swiftmailer.mailer.%s', $name)
        );
    }

    public function getMailerByCountryCode($countryCode)
    {
        return $this->getContainer()->get(
            sprintf('swiftmailer.mailer.%s', $this->getMailerNameByCountryCode($countryCode))
        );
    }

    public function getMailerSenderAddress()
    {
        if(!($name = $this->getDomainConfig()->getMailer())) {
            return;
        }

        return $this->getContainer()->getParameter(
            sprintf('swiftmailer.mailer.%s.sender_address', $name)
        );
    }

    public function getMailerSenderAddressByCountryCode($countryCode)
    {
        return $this->getContainer()->getParameter(
            sprintf('swiftmailer.mailer.%s.sender_address', $this->getMailerNameByCountryCode($countryCode))
        );
    }
}
