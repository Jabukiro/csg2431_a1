<?php
  session_start();
  header('Location: ./index.html');
  unset($_SESSION['uname']);
  unset($_SESSION['level']);
?>