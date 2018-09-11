SMS24 - Api Client for PHP
========================================

In your admin screen of [http://www.sms24.se/](http://www.sms24.se/) you can generate an API Key for your account to send SMS


Installation through composer
--------------------

This package can be installed through composer

See [https://getcomposer.org/](https://getcomposer.org/) for more information and documentation.

Install it by running `composer require itbmedia/sms24-api-php`

Usage through regular PHP
--------------------

```
<?php 
	require_once("path/to/dir/vendor/autoload.php");

	$client = new \Sms24\Api\Client('YOUR_API_KEY');
	$sms = new \Sms24\Api\Models\Sms('Hello world!');
	$sms->addContact(new \Sms24\Api\Models\Contact('0731525291', 'SE'));
	$sms->setOriginator(new \Sms24\Api\Models\Originator('Anonymous', 'alpha'));

	$sms = $client->sendSms($sms);
```