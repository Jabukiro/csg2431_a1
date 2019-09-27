<?php
/**
 * TODO:
 *--- Implement validation code
 */
/**
 * Allows Volounteers, only, to edit Profile information
 */
  session_start();
  if ($_SESSION['level'] != 'volounteer')
  {
    header('Location: ./index.html');
    exit;
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
    header('Location: ./result.php');
    $_SESSION['message'] = 'An Error happened fetching results: '.$db->error;
    $_SESSION['redirect'] = 'index.html';
    $_SESSION['redirect_msg'] = ' Home.';
    exit;
  }

  $volounteer_details = $result->fetch_assoc();

  $firstname = $volounteer_details['first_name'];
	$surname = $volounteer_details['surname'];
	$dob = $volounteer_details['dob'];
  $address = $volounteer_details['address'];
  $suburb = $volounteer_details['suburb'];
  $postcode = $volounteer_details['postcode'];
  $address_2 = $volounteer_details['address_2'];
	$mobile = $volounteer_details['mobile'];
  $email = $volounteer_details['email'];
  $pwd = $volounteer_details['password'];

  if(isset($_POST['edit_profile']))
  {
    if ($_POST['mobile'] == $mobile
      && $_POST['address'] == $address
      && $_POST['suburb'] == $suburb
      && $_POST['postcode'] == $postcode
      && $_POST['address_l2'] == $address_2
      && empty($_POST['pwd'])
      )
    {
      header('Location: ./result.php');
      $_SESSION['message'] = 'Your profile information was not changed! Back to';
      $_SESSION['redirect'] = 'volounteer.php';
      $_SESSION['redirect_msg'] = ' volounteer section.';
      exit;
    }
    else
    {
      $parameters_type;
      $parameters = array();
      if($pwd==$_POST['pwd'] && empty($_POST['new_pwd']))
      { 
        
        $update_query = "UPDATE volounteers SET address=?, suburb=?, postcode=?, address_2=?, mobile=? WHERE email=?";
        $update_pwd=false;
      }
      elseif($pwd==$_POST['pwd'] && !empty($_POST['new_pwd']))
      {
        #Add checking that newpassword matches confirm password in validation code.
        $update_query = "UPDATE volounteers SET address=?, suburb=?, postcode=?, address_2=?, mobile=?, password=? WHERE email=?";
        $update_pwd=true;
      }
      else
      {
        header('Location: ./result.php');
        $_SESSION['message'] = "Password is not correct!";
        $_SESSION['redirect'] = "./profile.php";
        $_SESSION['redirect_msg'] = ' Edit Profile';
        exit;
      }

    }
    $update_stmt = $db -> stmt_init();
    if($update_stmt->prepare($update_query) && !$update_pwd)
    {
      $stmt_ok = $update_stmt->bind_param('ssssss', $_POST['address'], $_POST['suburb'], $_POST['postcode'], $_POST['address_2'], $_POST['mobile'], $_SESSION['uname']);
      
      $_SESSION['message'] = "Profile Information updated!";
      $_SESSION['redirect'] = "volounteer.php";
      $_SESSION['redirect_msg'] = " volounteer section.";
    }
    elseif($update_stmt->prepare($update_query) && $update_pwd)
    {
      $stmt_ok = $update_stmt->bind_param('sssssss', $_POST['address'], $_POST['suburb'], $_POST['postcode'], $_POST['address_2'], $_POST['mobile'], $_POST['new_pwd'], $_SESSION['uname']);
      
      $_SESSION['message'] = "Password updated! Please";
      $_SESSION['redirect'] = "index.html";
      $_SESSION['redirect_msg'] = " login again.";
      unset($_SESSION['uname']);
      unset($_SESSION['level']);
    }
    else
    {
      header('Location: ./result.php');
      $_SESSION['message'] = "There was an error </p><p>Error #".$update_stmt->errno."</p><p>".$update_stmt->error."</p>";
      $_SESSION['redirect'] = "profile.php";
      $_SESSION['redirect_msg'] = "Edit Profile";
      exit;
    }
    if($stmt_ok && $update_stmt->execute())
    {
      header('Location: ./result.php');
      exit;
    }
    else
    { 
      header('Location: ./result.php');
      $_SESSION['message'] = "There was an error in your input. </p><p>Error #".$update_stmt->errno."</p><p>".$update_stmt->error."</p>";
      $_SESSION['redirect'] = "profile.php";
      $_SESSION['redirect_msg'] = "Edit Profile";
      exit;
    }
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
<body background="./img/bg_2.jpg" onload="document.getElementById('focus_point').focus()">
    <div class="header">
        <img id="icon" width='50px' height='50px' src = './img/icon.jpg' role='img' style="border-radius: 4pc">

        <div class="header-right">
            <button  class="about">About</button>
        </div>
    </div>
    <div id='id02' class='register' style="display: block">
      <?php
      ?>
      <form name="registerForm" class = "register-content animate" action="" method="post" onsubmit='return ValidateForm();'>
        <div class="imgcontainer">
            <a href="./volounteer.php"><span class="close" title="Close Login">&times;</span></a>
            <h1>Update your details</h1>
        </div>
        <div class="container">
          
            <label for="email"><b>E-Mail</b></label>
            <p id = "register_email"type="text" name="email"><?php echo$email; ?></p>

            <label for="firstname"><b>First Name(s)</b></label>
            <p type="text" name="firstname"><?php echo$firstname; ?></p>

            <label for="surname"><b>Surname</b></label>
            <p type="text" name="surname"><?php echo$surname; ?></p>

            <label for="dob"><b>Date Of Birth (YYYY-MM-DD)</b></label>
            <p type="text" name="dob"><?php echo$dob;?></p>

            <label for="mobile"><b>Mobile</b></label>
            <input type="text" name="mobile" id="focus_point" value="<?php echo$mobile; ?>">

            <label for="address"><b>Address Line</b></label>
            <input type="text" name="address" value = "<?php echo$address; ?>">

            <label for="suburb"><b>Suburb</b></label>
            <input type="text" name="suburb" value="<?php echo$suburb; ?>">

            <label for="postcode"><b>PostCode</b></label>
            <input type="text" name="postcode" value="<?php echo$postcode; ?>">

            <label for="address_l2"><b>Address Line 2</b></label>
            <input type="text" name="address_l2" value="<?php echo$address_2; ?>">
      
            <label for="pwd"><b>Password (Please first enter your current password if you want to change it)<b> </b></label>
            <input type="password" placeholder="Enter Password" name="pwd" >

            <label for="con_pwd"><b>New Password</b></label>
            <input type="password" placeholder="Enter New Password" name="new_pwd">

            <label for="con_pwd"><b>Confirm New Password</b></label>
            <input type="password" placeholder="Confirm New Password" name="con_new_pwd">
              
            <button type="submit" onclick="alert('Are you sure you want to update any changed field?')" name="edit_profile" value="true">Update</button>
            <button id="resetbtn"type="reset" onlick="alert('Empty fields will simply be ignored.')">Reset</button>
          </div>
      
          <div class="container" style="background-color:#f1f1f1">
            <a href="./volounteer.php"><button type="button" onclick="" class="cancelbtn">Cancel</button></a>

          </div>
      </form>

    </div>
</body>
</html>