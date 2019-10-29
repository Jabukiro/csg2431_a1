<?php
  session_start();
  if (empty($_SESSION['uname']) || $_SESSION['level'] != 'organiser')
  {
    header('Location: ./index.php');
  }
  @ $db = new mysqli('localhost', 'root', '', 'alien');

  if (mysqli_connect_error())
  {
    echo mysqli_connect_error();
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area51 RAID!</title>
    <link rel="stylesheet" href="./style.css">
    <link id="icon" rel="icon" href="./img/icon.jpg">
</head>
<body background="./img/bg_2.jpg">
    <div class="header">
        <img id="icon" width='50px' height='50px' src = './img/icon.jpg' role='img' style="border-radius: 4pc">
        <div class="header-right">
            <a href="./logout.php">
            <button style="font-style: normal"id="resetbtn">
              Logout
            </button>
            </a>
        </div>
    </div>
    <div id='id02' class='register' style="display: block">
        <div class="register-content animate" style="width: 80%">
            <div class="imgcontainer">
                <a href="./organiser.php"><span class="close" title="Close Login">&times;</span></a>
                <h2>Increase Event Duration</h2>
            </div>
        </div>
    </div>
</body>
</html>