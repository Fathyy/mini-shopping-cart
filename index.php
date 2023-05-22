<?php
session_start();
// you can't access this page if you are not logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}
 require_once __DIR__ . '/includes/header.php';
?>
<?php require_once __DIR__ . '/includes/navbar.php';?>
<div class="container">
    <div class="row" >
        <?php
        // display all products from the database
        require_once __DIR__ . '/config/database.php';
        $statement = $dbh->prepare("SELECT * FROM products");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($results):?>
            <?php foreach ($results as $result) :?>   
                    <div class="col-md-4 my-3">
                        <form action="cart.php?pid=<?php echo $result['product_id']?>" method="post">
                            <div class="card" style="width: 18rem;">
                                <img src="<?php echo $result['image']?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $result['name']?></h5>
                                    <p class="card-text">Ksh <?php echo $result['price']?></p>
                                    
                                    <!-- send the user_id as a hidden input field -->
                                    <input type="hidden" name="userid" value="<?php 
                                    if (isset($_SESSION['auth_user'])) {
                                        echo $_SESSION['auth_user']['id'];
                                    }
                                    ?>">
                                    <input type="number" name="quantity" value="1" class="form-control">
                                    <input type="submit" value="Add to Cart" name ="add_to_cart" class="btn btn-warning mt-3">
                                </div>
                            </div>
                        </form>
                    </div>    
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>