<?php require_once __DIR__ . '/includes/header.php'; ?>
<div class="container">
    <div class="row" >
<?php
    require_once __DIR__ . '/config/database.php';
    $statement = $dbh->prepare("SELECT * FROM product_details");
    $statement->execute();
    $results = $statement->fetchAll();
    if ($results) :?>
    <?php foreach ($results as $result) :?>
             <div class="col-md-4 my-3">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo $result['image']?>" class="card-img-top" alt="...">
                    <div class="card-body">
                    <h5 class="card-title"><?php echo $result['name']?></h5>
                    <p class="card-text"><?php echo $result['price']?></p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
             </div>
    <?php endforeach ?>
    <?php endif ?>

    </div>
    </div>
    <?php require_once __DIR__ . '/includes/footer.php'; ?>