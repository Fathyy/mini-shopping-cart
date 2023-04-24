<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';
$statement = $dbh->prepare("SELECT * FROM product_details WHERE id = {$_GET['id']}");
$statement->execute();
$result = $statement->fetch();
if ($result) :?>
    <div class="container">
        <div class="row mt-5">
            <!-- display image -->
            <div class="col-sm-6">
                <img src="<?php echo $result['image']?>" class="card-img-top" alt="...">
            </div>

            <!-- then display details -->
            <div class="col-sm-6">
                <h5 class="card-title mt-3"><?php echo $result['name']?></h5>
                <p class="card-text">Ksh <?php echo $result['price']?></p>
                <form action="cart.php" method="post">
                    <!-- Have the quantity field fetched from the DB and then display it here -->
                    <input type="number" name="quantity" min="1" max="<?php $result['quantity']?>" class="form-control">
                    <input type="hidden" name="product_id" value="<?php $result['id']?>">
                    <input type="submit" value="Add to Cart">
                </form>
            </div>
            
        </div>
    </div>
    <?php endif ?>

<?php require_once __DIR__ . '/includes/footer.php'?>