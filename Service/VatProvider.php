<?php

namespace FourLabs\HostsBundle\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class VatProvider
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var LocaleProvider
     */
    private $localeProvider;

    /**
     * Constructor.
     * 
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage, LocaleProvider $localeProvider)
    {
        $this->tokenStorage = $tokenStorage;
        $this->localeProvider = $localeProvider;
    }

    public function getVat()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $country = $user instanceof UserInterface ? $user->getCountry() : $this->localeProvider->getCountryCode();

        if($country === 'GB') {
            return 20;
        }

        return 0;
    }
}
