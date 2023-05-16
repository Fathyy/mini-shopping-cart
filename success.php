<?php
require_once __DIR__ . '/config2.php';

// connect to the database
require __DIR__ . '/config/database.php';

// once the transaction has been approved we need to complete it
if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    $transaction = $gateway->completePurchase(array(
        'payer_id' => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));

    $response = $transaction->send();

    if ($response->isSuccessful()) {
        // the customer has successfully paid
        $arr_body = $response->getData();

        $payment_id = $arr_body['id'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = PAYPAL_CURRENCY;
        $payment_status = $arr_body['state'];

        $statement = $dbh->prepare("INSERT INTO payments (payment_id, payer_id, payer_email, amount, currency, payment_status)
        VALUES('".$payment_id."', '".$payer_id."', '".$payer_email."', '".$amount."',
        '".$currency."', '".$payment_status."')");
        $statement->execute();

        $lastInsertId=$dbh->lastInsertId();
            if ($lastInsertId){
                echo "Payment is successful, Your transaction ID is " .$payment_id;
            }

    }
    else {
        echo $response->getMessage();
    }
}
else {
    echo "transaction is declined";
}
?>