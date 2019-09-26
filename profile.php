<?php
/**
 * Allows Volounteers, only, to edit Profile information
 */
  session_start();
  if ($_SESSION['level'] != 'volounteer')
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
            <button  class="about">About</button>
        </div>
    </div>
    <div id='id02' class='register' style="display: block">
      <form name="registerForm" class = "register-content animate" action="" method="post" onsubmit='return ValidateForm();'>
        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Login">&times;</span>
            <h1>Fill in your details</h1>
        </div>
        <div class="container">
          
            <label for="email"><b>E-Mail*</b></label>
            <p id = "register_email"type="text" name="email">email</p>

            <label for="firstname"><b>First Name(s)*</b></label>
            <p type="text" name="firstname" required></p>

            <label for="surname"><b>Surname*</b></label>
            <p type="text" name="surname" required>

            <label for="address"><b>Address Line*</b></label>
            <input type="text" name="address" required default="<?php?>">

            <label for="suburb"><b>Suburb*</b></label>
            <input type="text" name="suburb" required>

            <label for="postcode"><b>PostCode*</b></label>
            <input type="text" name="postcode" required>

            <label for="address_l2"><b>Address Line 2</b></label>
            <input type="text" name="address_l2">

            <label for="mobile"><b>Mobile*</b></label>
            <input type="text" name="mobile" required>

            <label for="dob"><b>Date Of Birth* (YYYY-MM-DD)</b></label>
            <input type="text" name="dob" required>
      
            <label for="pwd"><b>Password*</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" required>

            <label for="con_pwd"><b>Confirm Password*</b></label>
            <input type="password" placeholder="Enter Password" name="con_pwd" required>
              
            <button type="submit" onclick="alert('Are you sure you want to update any changed field?')">Register</button>
            <button id="resetbtn"type="reset" onlick="alert('Empty fields will simply be ignored.')">Reset</button>
          </div>
      
          <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>

          </div>
      </form>

    </div>
</body>
</html>