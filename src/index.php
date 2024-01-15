<?php

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..' . '')->load();

use BRI\Balance\Balance;
use BRI\Token\AccessToken;
use BRI\Util\RandomNumber;
use BRI\Signature\Signature;

// env values
$clientId = $_SERVER['BRI_CLIENT_KEY']; // customer key
$clientSecret = $_SERVER['BRI_CLIENT_SECRET']; // customer secret
$pKeyId = $_ENV['PRIVATE_KEY']; // private key

// url path values
$baseUrl = 'https://sandbox.partner.api.bri.co.id'; //base url
$path = '/snap/v1.0/bank-statement'; //informasi mutasi api path
$accessTokenPath = '/snap/v1.0/access-token/b2b'; //access token path

// change the variables accordingly
$account = '234567891012348'; //account
$startDate = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->modify('-1 day')->format('Y-m-d\TH:i:sP');; //start date
$endDate = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i:sP'); //end date || current date
$partnerId = ''; //partner id
$channelId = ''; // channel id

//external id
$externalId = (new RandomNumber())->generateRandomNumber(9);;

//timestamp
$timestamp = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d\TH:i:s.000P');

//access token
$accessToken = (new AccessToken(new Signature()))->getAccessToken(
  $clientId,
  $pKeyId,
  $timestamp,
  $baseUrl,
  $accessTokenPath,
);

echo (new Balance())->statement($account, $startDate, $endDate, $clientSecret, $partnerId, $baseUrl, $path, $accessToken, $channelId, $externalId, $timestamp);