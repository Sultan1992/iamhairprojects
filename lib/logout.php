<?php

session_start();

  $password = "";
  session_register("password");
  session_destroy();
header("Location: login.php"); 

?>