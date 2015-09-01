# GAMP Bundle
Symfony2 bundle handling geo location, locale, currency and emailers across multiple domains/hosts.

[![Total Downloads](https://poser.pugx.org/fourlabs/gamp-bundle/downloads)](https://packagist.org/packages/fourlabs/hosts-bundle)
[![License](https://poser.pugx.org/fourlabs/gamp-bundle/license)](https://packagist.org/packages/fourlabs/hosts-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/65a665f5-d868-40e4-9cee-1981958f018a/mini.png)](https://insight.sensiolabs.com/projects/65a665f5-d868-40e4-9cee-1981958f018a)

## Installation
### Download the Bundle
Open a command console, enter your project directory and execute the following command to download the latest version of this bundle:

``` bash
$ composer require fourlabs/hosts-bundle dev-master
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.

### Enable the Bundle

Then, enable the bundle by adding the following line in the *app/AppKernel.php* file of your project:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FourLabs\HostsBundle\FourLabsHostsBundle(),
    );
}
```

## Usage




### Configuration

``` yaml
four_labs_hosts:
    test_ip: 85.13.144.228
    assert_country: false
    default_domain: "acme.com"
    domains:
        "acme.com":
            locale: en_GB
            countries: [GB]
            currency: GBP
            mailer: mailer_gb
        "acme.de":
            locale: de_DE
            countries: [DE, AT, CH, LI]
            currency: EUR
            mailer: mailer_de
        "acme.ie":
            locale: en_IE
            countries: [IE, BE, CY, EE, FI, FR, GR, IT, LV, LT, LU, MT, NL, PT, SK, SI, ES]
            currency: EUR
            mailer: mailer_ie
```

``` yaml
swiftmailer:
    default_mailer: mailer_gb
    mailers:
        mailer_gb:
            # ...
        mailer_de:
            # ...
        mailer_ie:
            # ...
```

## To Do
- Unit tests

## License

[MIT](LICENSE)
