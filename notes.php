$statement = $dbh->prepare("INSERT INTO payments (payment_id, payer_id, payer_email, amount, currency, payment_status)
        VALUES(:payment_id, :payer_id, :payer_email, :amount, :currency, :payment_status)");
        $statement->bindValue(':payment_id', $payment_id, PDO::PARAM_STR);
        $statement->bindValue(':payer_id', $payer_id, PDO::PARAM_STR);
        $statement->bindValue(':payer_email', $payer_email, PDO::PARAM_STR);
        $statement->bindValue(':amount', $amount, PDO::PARAM_STR);
        $statement->bindValue(':currency', $currency, PDO::PARAM_STR);
        $statement->bindValue(':payment_status', $payment_status, PDO::PARAM_STR);
        $statement->execute();

        $lastInsertId=$dbh->lastInsertId();
            if ($lastInsertId){
                echo "Payment is successful, Your transaction ID is " .$payment_id;
            }