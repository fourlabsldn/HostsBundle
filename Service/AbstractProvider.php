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

    public function __construct(RequestStack $requestStack, DomainRepository $domainRepository)
    {
        $this->requestStack = $requestStack;
        $this->domainRepository = $domainRepository;
    }

    protected function getDomainConfig()
    {
        $request = $this->requestStack->getCurrentRequest();

        if(is_null($request)) {
            return;
        }

        $host = parse_url($request->getUri())['host'];

        if(!($domain = $this->domainRepository->findByHost($host))) {
            throw new NotConfiguredException('Domain configuration for '.$host.' missing');
        }

        return $domain;
    }
}
