<?php 
session_start();
require_once __DIR__ . '/includes/header.php' 
 ?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Bootstrap Alert -->
            <?php
                 if (isset($_SESSION['error'])) :?>
                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <?php echo $_SESSION['error']?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error'])?>
                 <?php endif ?>
                
                <!-- Bootstrap Alert -->

                <div class="card">
                    <div class="card-header">
                        <h4 class="heading">Registration Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="action.php" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control" name="fname" id="fname">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control" name="lname" id="lname">
                                </div>
                            </div>
                
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                               </div> 

                                <div class="col-md-6  mb-3">
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" class="form-control" name="cpassword" id="cpassword">
                                </div>
                            </div>

                            <div>
                                <input type="submit" class="btn btn-primary" value ="Signup" name="signup-btn">
                                <p>Already have an account? login<a href="login.php">here</a></p>
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