wicket-sdk-php
==============

A PHP library for the Wicket Core API. https://wicket.io/technology

## Wicket

> Wicket is an open source member data solution

Imagine a platform that can

- store your core member data
- uses open source software
- has no licensing fees
- is built to integrate with any third-party application

No more walls around your data.

Wicket makes this dream a reality.
No longer do non-profits and associations need to put their data into bloated, over-priced, locked down proprietary software applications.
With Wicket, take back your data, and provide your members with the best possible user experience across your entire digital footprint.

## Installing Wicket SDK

The recommended way to install Guzzle is through
[Composer](http://getcomposer.org).

```bash
# Install Composer, unless installed
curl -sS https://getcomposer.org/installer | php
```

Write the Composer file to install the latest development version of Wicket:

```json
cat > composer.json
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/industrialdev/wicket-sdk-php.git"
    }
  ],
  "require": {
    "industrialdev/wicket-sdk-php": "dev-master"
  }
}
```

Next, install the packages:

```bash
php composer.phar install
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update Wicket using composer:

```bash
composer.phar update
```

## Using the SDK

```php
<?php
require_once "vendor/autoload.php";

$client = new Wicket\Client(env('API_APP_KEY'), env('API_JWT_SECRET'));
$client->authorize(env('PERSON_ID'));

$orgs = $client->organizations->all();
```
