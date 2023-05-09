<?php
 require_once __DIR__ . '/includes/header.php';
?>
<?php require_once __DIR__ . '/includes/navbar.php';?>
<div class="container">
    <div class="row" >
<?php
// display all products from the database
    require_once __DIR__ . '/config/database.php';
    $statement = $dbh->prepare("SELECT * FROM product_details");
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($results):?>
    <?php foreach ($results as $result) :?>   
        <div class="col-md-4 my-3">
            <form action="cart.php?id=<?php echo $result['id']?>" method="post">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo $result['image']?>" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title"><?php echo $result['name']?></h5>
                    <p class="card-text">Ksh <?php echo $result['price']?></p>
                    <input type="hidden" name="name" value="<?php echo $result['name']?>">
                    <input type="hidden" name="price" value="<?php echo $result['price']?>">
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