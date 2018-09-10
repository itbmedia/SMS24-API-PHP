<?php
require_once("../vendor/autoload.php");

$apiKey = 'cdfe548635c31cbb6556f1debf22a0b2';

$client = new \Sms24\Api\Client($apiKey);

$groupId = 3;

$sms = new \Sms24\Api\Models\Sms();
$sms->setMessage('Hello world!');

$contact = new \Sms24\Api\Models\Contact('0731525291', 'SE');
$sms->addContact($contact);

$originator = new \Sms24\Api\Models\Originator('Anonymous', 'alpha');
$sms->setOriginator($originator);

$sms = $client->sendSmsToGroup($sms, $groupId);

print_r($sms);