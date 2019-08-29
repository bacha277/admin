<?php
session_start();
unset($_SESSION["admin_name"]);
setcookie ("member_login", "", time() - 3600);
header("location:index.php");
?>
