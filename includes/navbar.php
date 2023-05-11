<?php 
session_start();
require_once __DIR__ . '/header.php';
 ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <?php
            if (isset($_SESSION['auth'])) :?>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item mt-2">
                    <p><b>Hello <?php echo $_SESSION['auth_user']['name']?></b></p>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">logout</a>
                </li>
            </ul>
            <!-- shopping cart icon with number-->
            <div class="nav-item ms-auto">
            <a class="nav-link" href="cart.php">
                <i class="fa-solid fa-cart-shopping fa-lg cart-icon">
                    <span class="badge">
                <?php
                if (isset($_SESSION['cart'])) {
                    $count = count($_SESSION['cart']);
                    echo $count;
                }
                else {
                    echo "0";
                }
                ?>
                </span>
                </i>
            </a>
        </div>
        <!-- shopping cart icon -->

        <?php else: ?>
            <!-- register and login links if someone is not logged in -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
        
        
        <?php endif ?>
    </div>
</nav>
<?php require_once __DIR__ . '/footer.php'; ?>
