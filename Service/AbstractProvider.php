<?php

namespace FourLabs\HostsBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use FourLabs\HostsBundle\Model\DomainRepository;
use FourLabs\HostsBundle\Exception\NotConfiguredException;

abstract class AbstractProvider
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var DomainRepository
     */
    protected $domainRepository;

    /**
     * @var boolean
     */
    protected $requestActive;

    public function __construct(RequestStack $requestStack, DomainRepository $domainRepository, $requestActive)
    {
        $this->requestStack = $requestStack;
        $this->domainRepository = $domainRepository;
        $this->requestActive = $requestActive;
    }

    protected function getDomainConfig()
    {
        $request = $this->requestStack->getCurrentRequest();

        if(is_null($request) || !$this->requestActive) {
            return;
        }

        $host = parse_url($request->getUri())['host'];

        if(!($domain = $this->domainRepository->findByHost($host))) {
            throw new NotConfiguredException('Domain configuration for '.$host.' missing');
        }

        return $domain;
    }
}
