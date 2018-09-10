<?php
require_once("../vendor/autoload.php");

$apiKey = 'cdfe548635c31cbb6556f1debf22a0b2';

$client = new \Sms24\Api\Client($apiKey);

$groups = $client->listGroups();

print_r($groups);