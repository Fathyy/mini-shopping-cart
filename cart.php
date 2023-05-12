<?php
require __DIR__ . '/config/database.php';

if (isset($_POST['add_to_cart'])) {
    // insert the product_id, users_id and quantity into the carts table
    $productid = $_GET['pid'];
    $userid = $_POST['userid'];
    $quantity = $_POST['quantity'];

    // before inserting into cart, check if the product exists
    $query = $dbh->prepare("SELECT * FROM cart WHERE product_id='$productid' and user_id='$userid'");

    $query->execute();
    $existingRecord = $query->fetch(PDO::FETCH_ASSOC);
    if ($existingRecord) {
        echo "Product already exists in the cart";
    }

    else {
    // if product doesn't exist in the cart, add to cart
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

}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<?php require_once __DIR__ . '/includes/navbar.php';?>
<div class="py-5">
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <!-- display all items from the carts table for the
                    logged in user -->
                        <div class="row align-items-center">
                            <!-- products image -->
                            <div class="col-md-2">
                                <h4>Image</h4>
                            </div>
                            <!-- product name -->
                            <div class="col-md-2">
                                <h4>Product name</h4>
                            </div>
                            <!-- product price -->
                            <div class="col-md-2">
                                <h4>Price</h4>
                            </div>
                            <!-- cart quantity -->
                            <div class="col-md-3">
                                <h4>Quantity</h4>
                            </div>
                            <div class="col-md-3">
                                <h4>Action</h4>
                            </div>
                        </div>
                    
                    <?php
                    $user_id = $_SESSION['auth_user']['id'];
                    $statement = $dbh->prepare("SELECT p.name, p.image, p.price, c.quantity FROM cart c, 
                    products p WHERE c.product_id=p.product_id AND c.user_id ='$user_id'");
                    $statement->execute();
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) :?>
                        <div class="card shadow mb-3">
                            <div class="row align-items-center">
                                <!-- products image -->
                                <div class="col-md-2">
                                    <img src="<?php echo $row['image']?>" width="80px" alt="">
                                </div>
                                <!-- product name -->
                                <div class="col-md-2">
                                    <h5><?php echo $row['name']?></h5>
                                </div>
                                <!-- product price -->
                                <div class="col-md-2">
                                    <h5>$<?php echo $row['price']?></h5>
                                </div>
                                <!-- cart quantity -->
                                <div class="col-md-3">
                                    <h5><?php echo $row['quantity']?></h5>
                                </div>
                                <!-- remove button -->
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger?pid=<?php echo $row['product_id'] ?>">Remove</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// remove individual cart item
if ($_GET['pid']) {
    $pid = $_GET['pid'];
    $statement = $dbh->prepare("DELETE FROM cart WHERE id = '$pid'");
    $statement->execute();
}
?>

<?php require_once __DIR__ . '/includes/footer.php';?>

