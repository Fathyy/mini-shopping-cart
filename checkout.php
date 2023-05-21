<?php
require_once __DIR__ . '/config2.php';

if (isset($_GET['grand_total'])) {
    try {
        $response = $gateway->purchase(array(
           'amount'=>$_GET['grand_total'], 
           'currency'=>PAYPAL_CURRENCY, 
           'returnUrl'=>PAYPAL_RETURN_URL, 
           'cancelUrl'=>PAYPAL_CANCEL_URL,
            //send product information to paypal
             'item'=> array(
                array(
                    'name' => 'Product purchase',
                    'price'=>$_GET['grand_total'],
                    'description'=>'Get free products today',
                    'quantity'=>1
                    
                )
             )
        ))->send();

        if ($response->isRedirect()) {
            # forward customer to paypal
            $response->redirect();
        }
        else {
            // not successful
            echo $response->getMessage();
        }
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>