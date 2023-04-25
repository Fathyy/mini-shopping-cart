<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $product_id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // check if product exists in the DB b4 adding to the cart
    require_once __DIR__ . '/config/database.php';
    $statement = $dbh->prepare("SELECT * FROM product_details
    WHERE id=?");
    $statement->bindValue(1, $product_id, PDO::PARAM_STR);
    $statement->execute();
    $products = $statement->fetch(PDO::FETCH_ASSOC);
    // if the product and quantity exist in the DB
    if ($product && $quantity > 0) {
        // then create/update a session for the cart
        if (isset($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                # product exists by checking the product_id, so just update quantity
                $_SESSION['cart'][$product_id] += $quantity;
            }
            else {
                // product is not in the cart so just add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }
        else {
            // Add the first item to the cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // prevent form resubmission
    header('location: cart.php');
    exit;
}

// removing cart item
if (isset($_GET['remove'])) {
    // remove product from shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}
// updating cart items
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // loop through the data so that we can update the quantities for every product in cart
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $key);
            $quantity = (int)$value;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
// prevent form resubmission
header('location: cart.php');
exit;
}

// Send the user to order page if the click the placeorder button, also the cart should not be empty
 if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('location: placeorder.php');
    exit;
 }

//  check the session variable for products in cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// if there are products in the cart, select from DB
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart)));
    $statement = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks .')');
    $statement->execute(array_keys($products_in_cart));
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    // calculate the total
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<form action="cart.php" method="post">
    <table class="table">
        <thead>
            <tr>
            <td colspan ='2'>Product</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Total</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($products)) :?>
                <tr>
                    <td colspan='5' style="text-align:center;">You have no products added in your shopping Cart</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class ="image">
                                <a href="product.php?id=<?php $product['id']?>">
                                <img src="<?php $product['image']?>" alt="<?php $product['name']?>">
                            </a>
                            </td>
                            <td>
                                <a href="product.php?id=<?php $product['id']?>"><?php $product['name']?></a>
                                <br>
                                <a href="cart.php?remove=<?php $product['id']?>">Remove</a>
                            </td>
                            <td class="price"><?php $product['price']?></td>
                            <td class="quantity">
                                <input type="number" name="quantity-<?php $product['id']?>" value="<?php $products_in_cart[$product['id']]?>" min='1' max="<?php $product['quantity']?>">
                            </td>
                            <td class="price"><?php $product['price'] * $products_in_cart[$product['id']]?></td>
                        </tr>
                        <?php endforeach ?>
                        <?php endif ?>
        </tbody>
    </table>

    <div class="subtotal">
        <span class ="text">Subtotal</span>
        <span class ="price"><?php $subtotal?></span>
    </div>

    <div class="buttons">
        <input type="submit" value="Update" name ="update">
        <input type="submit" value="Place Order" name ="placeorder">
    </div>
</form>
<?php require_once __DIR__ . '/includes/header.php';?>