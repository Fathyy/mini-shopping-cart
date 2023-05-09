<?php
session_start();
unset($_SESSION['auth']);
unset($_SESSION['auth_user']);
session_destroy();
header("Location: index.php");
exit;
?>
