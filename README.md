# Belt.`Soshare`

[![Latest Version](http://img.shields.io/packagist/v/belt/soshare.svg?style=flat-square)](https://github.com/beltphp/soshare/releases)
[![Software License](http://img.shields.io/packagist/l/belt/soshare.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/beltphp/soshare/master.svg?style=flat-square)](https://travis-ci.org/beltphp/releases)
[![Coverage Status](http://img.shields.io/scrutinizer/coverage/g/beltphp/soshare.svg?style=flat-square)](https://scrutinizer-ci.com/g/beltphp/soshare/code-structure)
[![Quality Score](http://img.shields.io/scrutinizer/g/beltphp/soshare.svg?style=flat-square)](https://scrutinizer-ci.com/g/beltphp/soshare/)

> Shared URLs

Belt.`Soshare` is an utility library that allows you to easily check the number
of shares an URL has for a given social network (or all social networks).

Supported networks:

 - Twitter
 - Facebook
 - LinkedIn
 - reddit
 - Pinterest

## Installation

Via Composer.

```shell
$ composer require belt/soshare
```

## Usage

Usage is really simple (as usual).

```php
use Belt\Soshare;
use Belt\Soshare\Reddit;
use Belt\Soshare\Twitter;
use Belt\Soshare\Facebook;
use Belt\Soshare\LinkedIn;
use Belt\Soshare\Pinterest;

$soshare = new Soshare();
$soshare->addNetwork(new Reddit());
$soshare->addNetwork(new Twitter());
$soshare->addNetwork(new Facebook());
$soshare->addNetwork(new LinkedIn());
$soshare->addNetwork(new Pinterest());

$soshare->getShares('http://apple.com');
$soshare->getShares('http://apple.com', ['twitter']); // Only get shares on Twitter
$soshare->getShares('http://apple.com', ['facebook', 'reddit']); // Only get shares on Facebook and Reddit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/beltphp/soshare/blob/master/CONTRIBUTING.md).

## Credits

This library is based on [social-shares](https://github.com/Timrael/social_shares)
for Ruby. If you're building something in Ruby and you need functionality like
this, I recommend you check this library out!

## License

Please see [LICENSE](https://github.com/beltphp/soshare/blob/master/LICENSE).
