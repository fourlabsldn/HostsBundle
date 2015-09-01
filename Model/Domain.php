<?php

namespace FourLabs\HostsBundle\Model;

class Domain
{
    private $host;

    private $locale;

    private $currency;

    private $countries;

    private $mailer;

    private $isDefault;

    public function __construct($host, $locale, $currency, array $countries, $mailer, $isDefault)
    {
        $this->host = $host;
        $this->locale = $locale;
        $this->currency = $currency;
        $this->countries = $countries;
        $this->mailer = $mailer;
        $this->isDefault = $isDefault;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUrl()
    {
        return sprintf('https://%s/', $this->getHost());
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getCountries()
    {
        return $this->countries;
    }

    public function getMailer()
    {
        return $this->mailer;
    }

    public function hasCountry($countryCode)
    {
        return in_array($countryCode, $this->countries);
    }

    public function isDefault()
    {
        return $this->isDefault;
    }

    public function equals(Domain $domain)
    {
        return $domain->getHost() === $this->host;
    }
}
