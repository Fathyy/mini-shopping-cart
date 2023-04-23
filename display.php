<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config/database.php';
$statement = $dbh->prepare("SELECT * FROM product_details WHERE id = {$_GET['id']}");
$statement->execute();
$result = $statement->fetch();
if ($result) :?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="<?php echo $result['image']?>" class="card-img-top" alt="...">
            </div>

            <div class="col-sm-6">
                <h5 class="card-title"><?php echo $result['name']?></h5>
                <p class="card-text">Ksh <?php echo $result['price']?></p>
                <input type="text" placeholder="quantity" class="form-control">
                <a href="#" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
    <?php endif ?>

<?php require_once __DIR__ . '/includes/footer.php'?>