<?php

namespace FourLabs\HostsBundle\Service;

class LocaleProvider extends AbstractProvider
{
	public function getLocale()
    {
		return $this->getDomainConfig()->getLocale();
	}

    public function getCountryCode()
    {
        $locale = explode('_', $this->getDomainConfig()->getLocale());
        return array_pop($locale);
    }

    public function getAlternateTags()
    {
        $html = '';
        foreach($this->domainRepository->findAll() as $domain) {
            if(!$domain->equals($this->getDomainConfig())) {
                $html .= sprintf(
                    '<link rel="alternate" hreflang="%s" href="%s" />'."\r\n",
                    str_replace('_', '-', $domain->getLocale()),
                    $domain->getUrl()
                );
            }
        }
        return $html;
    }

    public function getOgLocaleTags()
    {
        $html = '';
        foreach($this->domainRepository->findAll() as $domain) {
            $html .= sprintf(
                '<meta property="og:locale%s" content="%s" />'."\r\n",
                $domain->equals($this->getDomainConfig()) ? '' : ':alternate',
                $domain->getLocale()
            );
        }
        return $html;
    }
}
