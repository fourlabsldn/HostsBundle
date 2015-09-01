<?php

namespace FourLabs\HostsBundle\EventListener;

use FourLabs\HostsBundle\Service\LocaleProvider;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocaleListener
{
    /**
     * @var LocaleProvider
     */
    private $localeProvider;

	public function __construct(LocaleProvider $localeProvider) {
		$this->localeProvider = $localeProvider;
	}

	public function onKernelRequest(GetResponseEvent $event) {
		if(HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $event->getRequest()->setLocale($this->localeProvider->getLocale());
	}
}
