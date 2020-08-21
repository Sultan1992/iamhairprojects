<?php
session_start();
if ($_SESSION['password']==""){
header("Location: ../lib/login.php"); 
exit;
}
?>