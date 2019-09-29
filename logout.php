<?php
  session_start();
  header('Location: ./index.php');
  unset($_SESSION['uname']);
  unset($_SESSION['level']);
?>