<?php

namespace FourLabs\HostsBundle\Service;

use Propeo\UserBundle\Entity\User;
use FourLabs\HostsBundle\Model\DomainRepository;

class UserMatcher
{
    /**
     * @var DomainRepository
     */
    private $domainRepository;

    public function __construct(DomainRepository $domainRepository)
    {
        $this->domainRepository = $domainRepository;
    }

    public function matchDomain(User $user, $currentHost)
    {
        $designatedDomain = $this->domainRepository->findByCountry($user->getCountry());
        // on correct TLD already
        if($currentHost === $designatedDomain->getHost()) {
            return;
        }

        return $designatedDomain;
    }
}
