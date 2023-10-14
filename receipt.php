<?php
session_start();
require_once __DIR__ . '/config/database.php';

// you can't access this page if you are not logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
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
                        <h3>Payment ID: <?php echo $results['payment_id']?></h3>
                        <h3>Payer ID: <?php echo $results['payer_id']?></h3>
                        <h3>Payer Email: <?php echo $results['payer_email']?></h3>
                        <h3>Amount: <?php echo $results['amount']?></h3>
                        <h3>Currency: <?php echo $results['currency']?></h3>
                        <h3>Payment Status: <?php echo $results['payment_status']?></h3>     
                    <?php endif?>
                    <?php endif?>     
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php';?>


