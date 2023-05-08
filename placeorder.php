<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/config/database.php';
    $fname = trim($_POST['fname']); 
    $lname = trim($_POST['lname']); 
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $payment = $_POST['payment'];
    
    $stmt = $dbh->prepare("INSERT INTO orders(first name, last name, phone, email, address, mode of payment)
    VALUES(?, ?, ?, ?, ?, ?)"); 
    $stmt->bindParam(1, $fname, PDO::PARAM_STR); 
    $stmt->bindParam(2, $lname, PDO::PARAM_STR); 
    $stmt->bindParam(3, $phone, PDO::PARAM_STR); 
    $stmt->bindParam(4, $email, PDO::PARAM_STR); 
    $stmt->bindParam(5, $address, PDO::PARAM_STR); 
    $stmt->bindParam(6, $payment, PDO::PARAM_STR); 
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($results) {
        echo "Order added successfully";
    }
}

?>