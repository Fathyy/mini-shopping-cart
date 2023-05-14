<?php
namespace Payment;
use Omnipay\Omnipay;
class Payment
{
   /**
    * @return mixed
    */
   public function gateway()
   {
       $gateway = Omnipay::create('PayPal_Express');
    // when you come back compare the below against the documentation in the omnipay
    // Initialise the gateway
        // $gateway->initialize(array(
        //     'clientId' => 'MyPayPalClientId',
        //     'secret'   => 'MyPayPalSecret',
        //     'testMode' => true, // Or false when you are ready for live transactions
        // ));
        
       $gateway->setUsername("sb-7j4hl606677@personal.example.com");
       $gateway->setPassword("ARySNgUCvyU9tEBp-zsd0WbbNO_7Nxxxxoi3xxxxh2cTuDxRh7xxxxVu9W5ZkIBGYqjqfzHrjY3wta");
       $gateway->setSignature("EOEwezsNWMWQM63xxxxxknr8QLoAOoC6lD_-kFqjgKxxxxxwGWIvsJO6vP3syd10xspKbx7LgurYNt9");
       $gateway->setTestMode(true); //for sandbox
       return $gateway;
   }
   /**
    * @param array $parameters
    * @return mixed
    */
   public function purchase(array $parameters)
   {
       $response = $this->gateway()
           ->purchase($parameters)
           ->send();
       return $response;
   }
   /**
    * @param array $parameters
    */
   public function complete(array $parameters)
   {
       $response = $this->gateway()
           ->completePurchase($parameters)
           ->send();
       return $response;
   }
   /**
    * @param $amount
    */
   public function formatAmount($amount)
   {
       return number_format($amount, 2, '.', '');
   }
   /**
    * @param $order
    */
   public function getCancelUrl($order = "")
   {
       return $this->route('http://phpstack-275615-1077014.cloudwaysapps.com/cancel.php', $order);
   }
   /**
    * @param $order
    */
   public function getReturnUrl($order = "")
   {
       return $this->route('http://phpstack-275615-1077014.cloudwaysapps.com/return.php', $order);
   }
   public function route($name, $params)
   {
       return $name;
   }
}