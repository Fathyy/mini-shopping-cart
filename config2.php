<?php
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

define('CLIENT_ID', 'AdWRvrPYLgTwf_2c76Gv0x2PuKoo54b-9nlCP2d2qLTvwi607sVAc1lTRcchHc-rU8y_XvR8etYD8feL');
define('CLIENT_SECRET', 'ENua4dBboBTQksE5t0wFjIWZZec_7fRIN29wpFkoeV-PCmNI9cYS9AYy2za3Cavf1WDh9qTLak9BeQJi');

define('PAYPAL_RETURN_URL', 'http://localhost/Shopping%20cart%20project/success.php');
define('PAYPAL_CANCEL_URL', 'http://localhost/Shopping%20cart%20project/cancel.php');
define('PAYPAL_CURRENCY', 'USD'); //change this one later

// connect to the database
require __DIR__ . '/config/database.php';

// create and initialiaze the gateway
$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId('AdWRvrPYLgTwf_2c76Gv0x2PuKoo54b-9nlCP2d2qLTvwi607sVAc1lTRcchHc-rU8y_XvR8etYD8feL');
$gateway->setSecret('ENua4dBboBTQksE5t0wFjIWZZec_7fRIN29wpFkoeV-PCmNI9cYS9AYy2za3Cavf1WDh9qTLak9BeQJi');
$gateway->setTestMode(true); //for sandbox
