<?php
require __DIR__ . '/config/database.php';

if (isset($_POST['add_to_cart'])) {
    // insert the product_id, users_id and quantity into the carts table
    $productid = $_GET['pid'];
    $userid = $_POST['userid'];
    $quantity = $_POST['quantity'];
    $statement = $dbh->prepare("INSERT INTO cart (user_id, product_id, quantity)
    VALUES(:user_id, :product_id, :quantity)");
    $statement->bindValue(':user_id', $userid, PDO::PARAM_STR);
    $statement->bindValue(':product_id', $productid, PDO::PARAM_STR);
    $statement->bindValue(':quantity', $quantity, PDO::PARAM_STR);
    $statement->execute();
    $lastInsertId=$dbh->lastInsertId();
    if ($lastInsertId) {
        echo "Record inserted successfully";
    } else {
        echo "Record not inserted";
    }
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<?php require_once __DIR__ . '/includes/navbar.php';?>

<table class='table table-bordered'>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Product name</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <!-- select all items from the carts table for the
    logged in user -->
        <?php
        $user_id = $_SESSION['auth_user']['id'];
        $statement = $dbh->prepare("SELECT * FROM cart c, products p, users u WHERE c.user_id=u.user_id
         AND c.product_id=p.product_id AND c.user_id ='$user_id'");
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) :?>
           <tr>
            <td><?php echo $row['id']?></td>
            <td><?php echo $row['fname']?></td>
            <td><?php echo $row['name']?></td>
            <td><?php echo $row['quantity']?></td>
           </tr> 
        <?php endwhile ?>
        
    </tbody>
<?php require_once __DIR__ . '/includes/footer.php';?>

