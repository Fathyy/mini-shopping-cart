<?php
session_start();
if (isset($_POST['add_to_cart'])) {
    // print_r($_POST['id']);
    if (isset($_SESSION['cart'])) {

        $session_array_id = array_column($_SESSION['cart'], 'id');
        // check if the product is already in the cart
        if (in_array($_GET['id'], $session_array_id)) {
            echo "<script>alert('Product is already in the cart!')</script>";
            echo "<script>window.location ='index.php'</script>"; 
        }
        else {
            // if the product is not in the cart, add in the session variable
            $count = count($_SESSION['cart']);
            $session_array = array(
                'id' => $_GET['id'] 
            );
            $_SESSION['cart'][$count]=$session_array;
            print_r($_SESSION['cart']);
         
        }
    }
    else{
        // if the shopping cart is empty
        $session_array = array(
            'id' => $_GET['id']
        );
        // create a new session variable
        $_SESSION['cart'][0] = $session_array;
        print_r($_SESSION['cart']);
    }
    
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<?php require_once __DIR__ . '/includes/navbar.php';

?>

<?php require_once __DIR__ . '/includes/header.php';?>