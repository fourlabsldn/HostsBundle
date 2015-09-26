<?php

namespace FourLabs\HostsBundle\EventListener;

use FourLabs\HostsBundle\Service\GeoMatcher;
use FourLabs\HostsBundle\Service\UserMatcher;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CountryListener
{
    /**
     * @var GeoMatcher
     */
    private $geoMatcher;

    /**
     * @var UserMatcher
     */
    private $userMatcher;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * if enabled, correct TLD for country is asserted
     * @var boolean
     */
    private $assertCountry;

    /**
     * @var integer
     */
    private $testIp;

    public function __construct(
        GeoMatcher $geoMatcher,
        UserMatcher $userMatcher,
        TokenStorageInterface $tokenStorage,
        $assertCountry,
        $testIp
    ) {
        $this->geoMatcher = $geoMatcher;
        $this->userMatcher = $userMatcher;
        $this->tokenStorage = $tokenStorage;
        $this->assertCountry = $assertCountry;
        $this->testIp = $testIp;
    }

    public function onKernelRequest(GetResponseEvent $event) {
        if(HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        if($this->assertCountry === false) {
            return;
        }

        $request = $event->getRequest();

        // Allow certain crawlers
        // TODO: Make this config param with sensible default
        foreach(['Googlebot', 'facebookexternalhit', 'Facebot', 'bingbot', 'msnbot', 'slurp'] as $agent) {
            if(strpos($request->headers->get('User-Agent'), $agent) !== false) {
                return;
            }
        }

        $request_uri = parse_url($request->getUri());

        // Prevent redirection loops
        $requestMatcher = new RequestMatcher('^/register|resetting|login|logout');
        if($requestMatcher->matches($request)) {
            return;
        }

        // if logged in country set in user preferences is determinant
        // otherwise client IP
        $user = $this->tokenStorage->getToken()->getUser();
        if($user instanceof UserInterface) {
            $redirect = $this->userMatcher->matchDomain($user, $request_uri['host']);
        } else {
            $ip = $this->testIp ? $this->testIp : $request->getClientIp();
            $redirect = $this->geoMatcher->matchDomain($ip, $request_uri['host']);
        }

        if(!is_null($redirect) && $redirect !== $request_uri['host']) {
            // Logout to prevent redirection loops when user logs out from designated TLD
            // $request->getSession()->invalidate();

            $response = new RedirectResponse($request_uri['scheme'].'://'.$redirect->getHost().$request_uri['path'], Response::HTTP_TEMPORARY_REDIRECT);
            $event->setResponse($response);
        }
    }
}
