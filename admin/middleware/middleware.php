<?php
// check if someone is logged in 
if (isset($_SESSION['auth'])) {
    if ($_SESSION['role_as'] != 1) {

        $_SESSION['message'] = "You are not authorised to access this page ";
        header("Location: ../index.php");
        exit;
    }
}
else {
    $_SESSION['message'] = "Log in to continue";
    header("Location: ../login.php");
    exit;
}


?>