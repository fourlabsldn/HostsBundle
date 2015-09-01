<?php

namespace FourLabs\HostsBundle\EventListener;

use FourLabs\HostsBundle\Service\GeoMatcher;
use FourLabs\HostsBundle\Service\LocaleProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use FOS\UserBundle\Event\UserEvent;

class SignupListener
{
    /**
     * @var GeoMatcher
     */
    private $geoMatcher;

    /**
     * @var LocaleProvider
     */
    private $localeProvider;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(GeoMatcher $geoMatcher, LocaleProvider $localeProvider, RequestStack $requestStack)
    {
        $this->geoMatcher = $geoMatcher;
        $this->localeProvider = $localeProvider;
        $this->requestStack = $requestStack;
    }

    public function onRegistrationInitialize(UserEvent $event)
    {
        $countryCode = $this->geoMatcher->getCountryCode($this->requestStack->getCurrentRequest()->getClientIp());
        // If country can't be determined by IP, use TLD's default country
        if(!$countryCode) {
            $countryCode = $this->localeProvider->getCountryCode();
        }
        $event->getUser()->setCountry($countryCode);
    }
}
