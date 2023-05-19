<?php
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

// define('CLIENT_ID', '');
// define('CLIENT_SECRET', '');

// $client_id = env('PAYPAL_CLIENT_ID');
// $client_secret=env('PAYPAL_SECRET');

// loading dotenv in the application
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// define the client id variable using the $_ENV superglobal variable
$client_id = $_ENV['PAYPAL_CLIENT_ID'];
$client_secret = $_ENV['PAYPAL_SECRET'];

define('PAYPAL_RETURN_URL', 'http://localhost/Shopping%20cart%20project/success.php');
define('PAYPAL_CANCEL_URL', 'http://localhost/Shopping%20cart%20project/cancel.php');
define('PAYPAL_CURRENCY', 'USD'); 

// connect to the database
require __DIR__ . '/config/database.php';

// create and initialiaze the gateway
$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId($client_id);
$gateway->setSecret($client_secret);
$gateway->setTestMode(true); //for sandbox
