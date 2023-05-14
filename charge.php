<?php
require_once __DIR__ . '/config2.php';

if (isset($_POST['submit'])) {
    try {
        $response = $gateway->purchase(array(
           'amount'=>$_POST['amount'], 
           'currency'=>PAYPAL_CURRENCY, 
           'returnUrl'=>PAYPAL_RETURN_URL, 
           'cancelUrl'=>PAYPAL_CANCEL_URL 
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