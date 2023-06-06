<?php
require __DIR__ . '/config/database.php';
require __DIR__ . '/flash.php';
require_once __DIR__ . '/includes/navbar.php'; //to use the existing session

// you can't access this page if you are not logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}

else {
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
            // show a flash message to show product is already in the cart
            flash('InTheCart', 'Product is already in the cart', FLASH_WARNING);
            flash('InTheCart');
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
                flash('recordInserted', 'Record inserted successfully', FLASH_SUCCESS);
                flash('recordInserted');
            } else {
                flash('recordNotInserted', 'Record not inserted', FLASH_ERROR);
                flash('recordNotInserted');
            }
        }
    
    }
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<div class="py-5">
    <div class="container"> 
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
                        <div class="col-md-2">
                            <h4>Quantity</h4>
                        </div>
                        <div class="col-md-2">
                            <h4>Action</h4>
                        </div>

                        <div class="col-md-2">
                            <h4>Total</h4>
                        </div>
                    </div>
                
                <?php
                $user_id = $_SESSION['auth_user']['id'];
                $statement = $dbh->prepare("SELECT p.name, p.image, p.price, c.id, c.quantity FROM cart c, 
                products p WHERE c.product_id=p.product_id AND c.user_id ='$user_id'");
                $statement->execute();
                while($row = $statement->fetch(PDO::FETCH_ASSOC)):
                    if ($row) :
                    $total = 0;
                    ?>

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
                                <h5>$<?php echo number_format($row['price'], 2)?></h5>
                            </div>
                            <!-- cart quantity -->
                            <div class="col-md-2">
                                <h5><?php echo $row['quantity']?></h5>
                            </div>
                            <!-- remove button -->
                            <div class="col-md-2">
                                <a href="cart.php?action=remove&id=<?php echo $row['id']?>">
                                    <button class="btn btn-danger">Remove</button>
                                </a>
                            </div>

                            <div class="col-md-2">
                                <h5>
                                    <?php 
                                        $total = $total + $row['price'] * $row['quantity'];
                                        echo $total;
                                    ?>
                                </h5>
                            </div> 
                            
                            <!-- process the remove button -->
                            <?php 
                            if (isset($_GET['action'])) {
                                if ($_GET['action'] == 'remove') {
                                    $id = $_GET['id'];
                                    $statement = $dbh->prepare("DELETE FROM cart WHERE id = '$id'");
                                    $statement->execute();
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                        $grand_total = 0;
                        $grand_total += $total;
                    ?>
                
                    <?php else : 
                        echo "There are no items in the cart";
                    ?> 
                <?php endif ?>
                <?php endwhile ?>
            </div>

            <!-- total -->
            <div>
                <h5 class="float-end">
                    <b>Grand Total:</b>
                    <?php 
                        echo number_format($grand_total, 2);
                    ?></h5>
                </div>
                <!-- total -->
                
                <!-- checkout button -->
                <div>
                    <button class="btn btn-success float-end btn-large checkout-btn">
                        <a href="checkout.php?grand_total=<?php if (isset($grand_total)) {
                            echo $grand_total;
                        }?>">Checkout</a>
                    </button>
                </div>
                <!-- checkout button -->
            </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php';?>

