<?php
session_start();
if ($_SESSION['password']==""){
header("Location: login.php"); 
exit;
}
?>