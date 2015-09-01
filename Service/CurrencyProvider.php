<?php

namespace FourLabs\HostsBundle\Service;

use Money\Currency;

class CurrencyProvider extends AbstractProvider
{
	public function getCurrencyCode()
    {
		return $this->getDomainConfig()->getCurrency();
	}

	public function getCurrency()
    {
		return new Currency($this->getCurrencyCode());
	}
}
