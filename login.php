<?php
  session_start();
  
  if (isset($_SESSION['uname']) & $_SESSION['uname'] != '')
  {
    header('Location: '.$_SESSION['level'].'.php');
  }

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
  elseif($pwd < 5 || $pwd>20)
  {
    $error_message = "Password must be between 5 and 20 characters";
  }
  
  $volounteer_query = "SELECT email FROM volounteers WHERE email = ? AND password = ?";
  $volounteer_stmt = $db->stmt_init();

  $organiser_query = "SELECT username FROM organisers WHERE username = ? AND password = ?";
  $organiser_stmt = $db->stmt_init();

	if($volounteer_stmt->prepare($volounteer_query))
	{
    $vol_ok = $volounteer_stmt->bind_param("ss", $uname, $pwd);
		if($vol_ok && $volounteer_stmt->execute())
		{
			if($volounteer_stmt->fetch() != null) #
			{
        #Continue to volounteer section
        $_SESSION['uname'] = $uname;
        $_SESSION['level'] = 'volounteer';
        header('Location: '.$_SESSION['level'].'.php');
      } else{
        #Check if login is organiser
        if($organiser_stmt->prepare($organiser_query))
        {
          $org_ok = $organiser_stmt->bind_param("ss", $uname, $pwd);
          if($org_ok && $organiser_stmt->execute())
          {
            if($organiser_stmt->fetch() != null) #
            {
              #Continue to volounteer section
              $_SESSION['uname'] = $uname;
              $_SESSION['level'] = 'organiser';
              header('Location: '.$_SESSION['level'].'.php');
            } else{ #login detais incorect.
              echo "<p>Incorrect Login Attempt! Either the Username or Password is incorrect.<p>";
              echo '<a href="javascript: history.back();">Go Back</a>.';
            }
          } else{
            header('Location: ./result.php');
            $_SESSION['message'] = "There was an error with your input.";
            $_SESSION['redirect'] = "index.php";
            $_SESSION['redirect_msg'] = "Home";
            exit;
          }
        } else{
          header('Location: ./result.php');
          $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #1".$stmt_ok->errno."</p><p>".$stmt_ok->error."</p>";
          $_SESSION['redirect'] = "index.php";
          $_SESSION['redirect_msg'] = "Home";
          exit;
        }
      }
		} else{
			$registered = false;
			header('Location: ./result.php');
			$_SESSION['message'] = "There was an error with your input.";
			$_SESSION['redirect'] = "index.php";
			$_SESSION['redirect_msg'] = "Home";
			exit;
		}
	} else{
		header('Location: ./result.php');
		$_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #1".$stmt_ok->errno."</p><p>".$stmt_ok->error."</p>";
		$_SESSION['redirect'] = "index.php";
		$_SESSION['redirect_msg'] = "Home";
		exit;
  }
?>