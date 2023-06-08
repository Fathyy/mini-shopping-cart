<?php
session_start();
unset($_SESSION['auth_user']);
session_destroy();
header("Location: login.php");
exit;
?>
