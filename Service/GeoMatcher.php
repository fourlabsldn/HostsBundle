<?php

namespace FourLabs\HostsBundle\Service;

use Maxmind\Bundle\GeoipBundle\Service\GeoipManager;
use FourLabs\HostsBundle\Model\DomainRepository;

class GeoMatcher
{
	/**
	 * @var GeoipManager
	 */
	private $geoip;

	/**
	 * @var DomainMatcher
	 */
	private $domainRepository;


	public function __construct(GeoipManager $geoip, DomainRepository $domainRepository)
	{
		$this->geoip = $geoip;
		$this->domainRepository = $domainRepository;
	}

	public function getCountryCode($ip)
	{
		$geoip = $this->geoip->lookup($ip);
		if($geoip === false) {
			return;
		}
		return $geoip->getCountryCode();
	}

	public function matchDomain($ip, $currentHost)
	{
		$originCountry = $this->getCountryCode($ip);
		// look up failed
		if($originCountry === false) {
			return;
		}

		$designatedDomain = $this->domainRepository->findByCountry($originCountry);
		// no domain configured for country of origin -> default domain
		if(!$designatedDomain) {
			$designatedDomain = $this->domainRepository->findDefault();
		}

		// on correct TLD already
		if($currentHost === $designatedDomain->getHost()) {
			return;
		}

		return $designatedDomain;
	}
}
