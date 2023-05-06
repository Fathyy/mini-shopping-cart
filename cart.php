<?php
session_start();
if (isset($_POST['add_to_cart'])) {

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
                'id' => $_GET['id'], 
                'name'=>$_POST['name'],
                'price'=>$_POST['price'],
                'quantity'=>$_POST['quantity']
                
            );
            $_SESSION['cart'][$count]=$session_array;
        }
    }
    else{
        // if the shopping cart is empty
        $session_array = array(
            'id' => $_GET['id'],
            'name'=>$_POST['name'],
            'price'=>$_POST['price'],
            'quantity'=>$_POST['quantity']
        );
        // create a new session variable
        $_SESSION['cart'][] = $session_array;
    } 
}
?>

<?php require_once __DIR__ . '/includes/header.php';?>
<?php require_once __DIR__ . '/includes/navbar.php';?>
<div class="container">
    <div class="row">
        <div class="heading">
            <h3>Shopping cart items</h3>
        </div>
        <?php
        $total = 0;

        $output = '';

        $output .= "
        <table class='table table-bordered'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
        ";
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {
                $output .="
                <tr>
                    <td>".$value['id']."</td>
                    <td>".$value['name']."</td>
                    <td>".$value['price']."</td>
                    <td>".$value['quantity']."</td>
                    <td>".number_format($value['price'] * $value['quantity'], 2)."</td>
                    <td>
                    <a href='cart.php?action=remove&id=".$value['id']."'>
                    <button class='btn btn-danger btn-block'>Remove</button>
                    </a>
                    </td>
                </tr>
                ";

                $total = $total + $value['quantity'] * $value['price']; 
    
            }

            $output .= "
            <tr>
            <td colspan='3'></td>
            <td>Total Price</td>
            <td>".number_format($total, 2)."</td>
            <td>
                <a href='cart.php?action=clearall'>
                <button class='btn btn-warning btn-block'>Clear</button>
                </a>
            </td>
            </tr>
            <tr>
            <td colspan='5'></td>
            <td>
                <a href='checkout.php'>
                <button class='btn btn-success btn-block'>Checkout</button>
                </a>
            </td>
            </tr>
            </table>
            ";
        }

        echo "$output";

        ?>
    </div>
</div>

<?php
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'clearall') {
        unset($_SESSION['cart']);
    }

    if ($_GET['action'] === 'remove') {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['id'] == $_GET['id']) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }
}
?>
<?php require_once __DIR__ . '/includes/footer.php';?>