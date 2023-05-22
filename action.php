<?php
session_start();
// process the signup form
require __DIR__ . '/config/database.php';
if (isset($_POST['signup-btn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // if inputs is empty, display error
    if (!$fname || !$lname || !$email || !$phone || !$password || !$cpassword) {
        $_SESSION['message'] = "This field cannot be empty";  
    }

    // else validate the inputs
    else {
        // validate the email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Invalid email format";
        }

        // check if the password contains 8 characters and has letters and numbers.
        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/',$_POST["password"])) {
            $_SESSION['message'] =  "Password must contain numbers and letters and must be at least 8 characters long!";
        }
        if ($password !== $cpassword) {
            $_SESSION['message'] = "Passwords should match";
        }
        
    }

    // insert into db if $_SESSION['message'] is empty or there is no error
    if (empty($_SESSION['message'])) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $statement = $dbh->prepare("INSERT INTO users (fname, lname, email, password, phone)
        VALUES(:fname, :lname, :email, :password, :phone)");
        $statement->bindValue(':fname', $fname, PDO::PARAM_STR);
        $statement->bindValue(':lname', $lname, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', $password_hash, PDO::PARAM_STR);
        $statement->bindValue(':phone', $phone, PDO::PARAM_STR);
        $statement->execute();
        // redirect to login page after successful registration
        $lastInsertId=$dbh->lastInsertId();
            if ($lastInsertId){
                $_SESSION['success'] = "Successful registration. You may now log in";
                header('Location: login.php');
                exit;
            }
    }
    // // otherwise, redirect to the register.php and show the errors there
    // else {
    //     header("Location: register.php");
    //     exit;
    // }
}

// process the login form here
elseif (isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // check if the user exists in the DB
    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = '$email'");
    $stmt->execute();
    $loggedUser = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($loggedUser) {
        $username = $loggedUser['fname'];
        $userid =$loggedUser['user_id'];
        $_SESSION['auth_user'] = [
            'name'=>$username,
            'id'=>$userid
        ];
        header("Location: index.php");
        exit;
    }

}
?> 