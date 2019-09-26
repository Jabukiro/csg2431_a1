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
  $query = "SELECT * FROM volounteers WHERE email = '".$_SESSION['uname']."'";
  $result = $db->query($query);
  if($db->errno)
  {
    echo '<p> An Error happened fetching results #2: '.$db->error;
    echo '</p>';
  }

  $volounteer_details = $result->fetch_assoc();

  $firstname = $volounteer_details['first_name'];
	$surname = $volounteer_details['surname'];
	$dob = $volounteer_details['dob'];
  $address = $volounteer_details['address'];
  $suburb = $volounteer_details['suburb'];
  $postcode = $volounteer_details['postcode'];
  $addressln2 = $volounteer_details['address_2'];
	$mobile = $volounteer_details['mobile'];
	$email = $volounteer_details['email'];
	$pwd = $volounteer_details['pwd'];
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
            <p id = "register_email"type="text" name="email"><?php echo$email; ?></p>

            <label for="firstname"><b>First Name(s)*</b></label>
            <p type="text" name="firstname"><?php echo$firstname; ?></p>

            <label for="surname"><b>Surname*</b></label>
            <p type="text" name="surname"><?php echo$surname; ?></p>

            <label for="address"><b>Address Line*</b></label>
            <input type="text" name="address" placeholder = "<?php echo$address; ?>">

            <label for="suburb"><b>Suburb*</b></label>
            <input type="text" name="suburb" placeholder="<?php echo$suburb; ?>">

            <label for="postcode"><b>PostCode*</b></label>
            <input type="text" name="postcode" placeholder="<?php echo$postcode; ?>">

            <label for="address_l2"><b>Address Line 2</b></label>
            <input type="text" name="address_l2" placeholder="<?php echo$addressln2; ?>">

            <label for="mobile"><b>Mobile*</b></label>
            <input type="text" name="mobile" placeholder="<?php echo$mobile; ?>">

            <label for="dob"><b>Date Of Birth* (YYYY-MM-DD)</b></label>
            <p type="text" name="dob"><?php echo$dob;?></p>
      
            <label for="pwd"><b>Password(Please first enter your current password if you want to change it)</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" >

            <label for="con_pwd"><b>New Password()</b></label>
            <input type="password" placeholder="Enter New Password" name="new_pwd">

            <label for="con_pwd"><b>Confirm New Password</b></label>
            <input type="password" placeholder="Confirm New Password" name="new_pwd">
              
            <button type="submit" onclick="alert('Are you sure you want to update any changed field?')" name="edit_profile" value="true">Register</button>
            <button id="resetbtn"type="reset" onlick="alert('Empty fields will simply be ignored.')">Reset</button>
          </div>
      
          <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>

          </div>
      </form>

    </div>
</body>
</html>