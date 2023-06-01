<?php 
session_start();
require_once __DIR__ . '/includes/header.php' 
 ?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-sm-10 col-md-6">
                <!-- Bootstrap Alert -->
            <?php
                 if (isset($_SESSION['success'])) :?>
                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <?php echo $_SESSION['success']?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success'])?>
                 <?php endif ?>
                
                <!-- Bootstrap Alert -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="heading">Login Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="action.php" method="post">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                               </div> 

                            </div>

                            <div>
                                <input type="submit" class="btn btn-primary" value ="Login" name="login-btn">
                                <p>Don't have an account? Signup<a href="register.php">here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php' 
 ?>