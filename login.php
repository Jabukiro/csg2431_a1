<?php
  session_start();
  /*Uncomment once u implement logout
  if (isset($_SESSION['uname']) & $_SESSION['uname'] != '')
  {
    header('Location: '.$_SESSION['level'].'.php');
  }
  */
  @ $db = new mysqli('localhost', 'root', '', 'alien');

  if (mysqli_connect_error())
  {
    echo mysqli_connect_error();
    exit;
  }
  

  //create short variable names from the data received from the form
	$uname = $_POST['uname'];
	$pwd = $_POST['pwd'];
	
	$error_message = '';
  if (empty($uname) || empty($pwd))
	{
		$error_message = 'Either the username or Password field was blank';	
  }
  
  $volounteer_query = $db->prepare("SELECT email FROM volounteers WHERE email = ? AND password = ?");
  $organiser_query = $db->prepare("SELECT username FROM organisers WHERE username = ? AND password = ?");

  if(!$volounteer_query || !$organiser_query)
  {
    echo "Prepare failed: (" . $db->errno . ") " . $db->error;
    exit;
  }


	$volounteer_query->bind_param("ss", $uname, $pwd);
	$volounteer_query->execute();
	if ($volounteer_query->execute())
	{
    if($volounteer_query->fetch() != null) #Check if it's a volounteer login
    {
      #Continue to volounteer section
      $_SESSION['uname'] = $uname;
      $_SESSION['level'] = 'volounteer';
      header('Location: '.$_SESSION['level'].'.php');

    }
    else
    { 
      $organiser_query->bind_param("ss", $uname, $pwd);
	    $organiser_query->execute();
      if ($organiser_query->execute())
      {
        if($organiser_query->fetch() != null)#Check if it's an organiser login
        {
          #Continue to organiser section
          $_SESSION['uname'] = $uname;
          $_SESSION['level'] = 'organiser';
          header('Location: '.$_SESSION['level'].'.php');
          
        }
        else
        {
          #Must be a false login
          $error_message = "Incorrect Login Attempt! Either the Username or Password is incorrect.";
        }
      }
      else
      {
        echo '<p>Error retrieving details. Error message: <p>';
			  echo '<p>'.$db->error.'</p>';
			  exit;
      }      
    }

	}
	else
	{
		echo '<p>Error retrieving login details. Error message: <p>';
		echo '<p>'.$db->error.'</p>';
		exit;
  }
?> 

<!DOCTYPE html>
<html>
<head>
  <title>Loging In...</title>
</head>

<body>

<?php

if ($error_message != '')
{
  echo 'Error: '.$error_message.' <a href="javascript: history.back();">Go Back</a>.';
  echo '</body></html>';
  exit;
}
else
{
  $query->bind_param("ssssssssss", $uname, $firstname, $surname, $mobile, $address, $suburb, 
                  $postcode, $addressln2, $dob, $pwd);
  if($query->execute())
  {
    echo '<p><strong>Registered successfully! Please Login using your uname and password</strong></p>';
    echo "</body></html>";
    exit;
  }
  else
  {
    echo '<p>Error inserting details. Error message: <p>';
    echo '<p>'.$db->error.'</p>';
    exit;
  }
}

?>