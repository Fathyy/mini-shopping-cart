<?php
require_once __DIR__ . '/config/database.php';
require __DIR__ . '/flash.php';

require_once __DIR__ . '/includes/navbar.php';

// you can't access this page if you are not logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<div class="py-5">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
            <?php
            // show payment success message
            flash('successfulPayment', 'Your payment is successful', FLASH_SUCCESS);
            flash('successfulPayment');
            ?>
                <div class="card">
                    <div class="card-header">
                        <h2>Payment Details</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        // Get the id session
                        if (isset($_SESSION['lastInsertedId'])) :
                            $lastInsertId = $_SESSION['lastInsertedId'];
                        
                        // Get the payment details from the database
                        $statement = $dbh->prepare("SELECT * FROM payments WHERE id = '$lastInsertId'");
                        $statement->execute();
                        
                        if ($results = $statement->fetch(PDO::FETCH_ASSOC)) :?>
                            <p><strong>Payment ID:</strong> <?php echo $results['payment_id']?></p>
                            <p><strong>Payer ID:</strong> <?php echo $results['payer_id']?></p>
                            <p><strong>Payer Email:</strong> <?php echo $results['payer_email']?></p>
                            <p><strong>Amount:</strong> <?php echo $results['amount']?></p>
                            <p><strong>Currency:</strong> <?php echo $results['currency']?></p>
                            <p><strong>Payment Status:</strong> <?php echo $results['payment_status']?></p>     
                        <?php endif?>
                        <?php endif?>     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php';?>


