<?php 
// session_start();
require_once __DIR__ . '/header.php'; ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
            <!-- shopping cart icon with number of items inside -->
        </div>
        <div class="nav-item ms-auto">
            <a class="nav-link" href="cart.php">
                <i class="fa-solid fa-cart-shopping fa-lg" style="color: #de731b; position:relative;">
                    <span class="badge" style="color:white; position:absolute; left:15px; bottom:0.5px; background-color:black;
                    border-radius:50%;" >
                <?php
                if (isset($_SESSION['cart'])) {
                    $count = count($_SESSION['cart']);
                    echo $count;
                }
                ?>
                </span>
                </i>
            </a>
        </div>
    </div>
</nav>
<?php require_once __DIR__ . '/footer.php'; ?>
