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
    $product = $statement->fetch(PDO::FETCH_ASSOC);
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
}