<?php

session_start();

$pwd = "0987";

$password=addslashes($_POST['password']);

if($pwd == $password) {
$_SESSION['password']=$password;
header("Location: index.php"); 
exit;
} else {
header("Location: login.php"); 
exit;
}

?>