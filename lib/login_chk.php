<?php

session_start();

$pwd = "7890";

$password=addslashes($_POST['password']);

if($pwd == $password) {
$_SESSION['password']=$password;
header("Location: ../csvproduct/index.php"); 
exit;
} else {
header("Location: ../lib/login.php"); 
exit;
}

?>