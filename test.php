<?php
require_once("vendor/autoload.php");

$apiKey = 'cdfe548635c31cbb6556f1debf22a0b2';

$client = new \Sms24\Api\Client($apiKey);

$sms = new \Sms24\Api\Models\Sms();
$sms->setMessage('Hello');

$contact = new \Sms24\Api\Models\Contact('0731525291', 'SE');
$sms->addContact($contact);

$originator = new \Sms24\Api\Models\Originator('Hejhej', 'alpha');
$sms->setOriginator($originator);

$client->sendSmsToGroup($sms, 3);