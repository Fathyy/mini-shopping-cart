<?php
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (!$fname || !$lname || !$email || !$password || !$cpassword) {
        echo "This field cannot be empty";  
    }

    // validate the email
    if (! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    }

    // check if the password contains 8 characters and has letters and numbers.
    if (! preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/',$_POST["password"])) {
        echo  "Password must contain numbers and letters and must be at least 8 characters long!";
    }
    if ($password !== $cpassword) {
        echo "Passwords should match";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    require __DIR__ . '/config/database.php';
    $statement = $dbh->prepare("INSERT INTO users (fname, lname, email, password)
    VALUES(:fname, :lname, :email, :password)");
    $statement->bindValue(':fname', $fname, PDO::PARAM_STR);
    $statement->bindValue(':lname', $lname, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':password', $password_hash, PDO::PARAM_STR);
    $user = $statement->execute();
    if ($user) {
        header("Location: index.php");
        exit;
    }
    // $user = $statement->fetch(PDO::FETCH_ASSOC);
}
?> 