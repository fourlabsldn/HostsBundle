<?php

namespace FourLabs\HostsBundle\Model;

class DomainRepository
{
    private $domains;

    public function __construct(array $domains, $defaultDomain)
    {
        foreach($domains as $host => $config) {
            $this->domains[] = new Domain(
                $host,
                $config['locale'],
                $config['currency'],
                $config['countries'],
                $config['mailer'],
                $host === $defaultDomain
            );
        }
    }

    public function findAll()
    {
        return $this->domains;
    }

    public function findByHost($host)
    {
        foreach($this->domains as $domain) {
            if($domain->getHost() === $host) {
                return $domain;
            }
        }
        return null;
    }

    public function findByCountry($countryCode)
    {
        foreach($this->domains as $domain) {
            if($domain->hasCountry($countryCode)) {
                return $domain;
            }
        }
        return null;
    }

    public function findDefault()
    {
        foreach($this->domains as $domain) {
            if($domain->isDefault()) {
                return $domain;
            }
        }
        return null;
    }
}
