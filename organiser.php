<?php
  header('Location: ./index.html');
  session_start();
  if (isset($_SESSION['level']) != 'volounteer')
  {
    header('Location: ./index.html');
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
            <button class="active" 
                    onclick="document.getElementById('id01').style.display='block'
                              document.loginForm.uname.focus()">
                Profile
            </button>
            <button id="resetbtn" 
                    onclick="document.getElementById('id02').style.display='block';
                      document.registerForm.email.focus()">
              Logout
            </button>
            <button  class="about">About</button>
        </div>
    </div>
    <div id="id03" class='mainContainer'>
        <div class="login-content animate">
          <div class="welcome">
              <?php
                echo '<p><strong><em>Welcome, '.$_SESSION['uname'].'. Please organise these minions.</em></strong></p>';
              ?>
          </div>
        </div>
    </div>
</body>
</html>