<?php
session_start();
require_once __DIR__ . '/includes/header.php';
require __DIR__ . '/config/database.php';
?>
<table class='table table-bordered'>
    <thead>
     <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>First name</th>
        <th>Quantity</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $user_id = $_SESSION['auth_user']['id'];
    $statement = $dbh->prepare("SELECT p.image, p.name, p.price, u.fname, c.quantity
    FROM cart c, products p, users u WHERE c.user_id=u.user_id and c.product_id=p.product_id
    and c.user_id='$user_id'");
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) :?>
        <tr>
            <td><img src="<?php echo $row['image']?>" alt="" style="width:10%;"></td>
            <td><?php echo $row['name']?></td>
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['fname']?></td>
            <td><?php echo $row['quantity']?></td>
        </tr>
    <?php endif ?>
    
    </tbody>
    </table>


<?php require_once __DIR__ . '/includes/footer.php';?>