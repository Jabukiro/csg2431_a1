<?php
/**
 * TODO:
 *--- Implement validation code
 *--- https://www.php.net/manual/en/mysqli-stmt.get-result.php
 *    Use that style to only insert updated fields
 */

	session_start();
	if (!isset($_POST['register']))
	{
		header('Location: index.php');
		exit;
	}

	@ $db = new mysqli('localhost', 'root', '', 'alien');

	if (mysqli_connect_error())
	{
		echo mysqli_connect_error();
		exit;
	}

	
	//create short variable names from the data received from the form
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$dob = $_POST['dob'];
    $address = $_POST['address'];
    $suburb = $_POST['suburb'];
    $postcode = $_POST['postcode'];
    $addressln2 = $_POST['address_l2'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$pwd = $_POST['pwd']; 
	$conPwd = $_POST['con_pwd'];
	
	$error_message = '';
    if (empty($firstname) || empty($surname) || empty($dob) || empty($address) ||  empty($email) 
        || empty($pwd) || empty($conPwd) || empty($suburb) || empty($postcode) || empty($conPwd)
		)
	{
		$error_message = 'One of the required values was blank.';	
	}
	elseif (!is_numeric($postcode))
		$error_message = 'PostCode must be a number';
	
	elseif ($pwd != $conPwd)
		$error_message = 'Passwords do not match.';

	elseif (strlen($pwd) <5 )
		$erro_message = 'Password length must be between 5 and 16 characters, inclusive.';

	if ($error_message != '')
	{
		echo 'Error: '.$error_message.' <a href="javascript: history.back();">Go Back</a>.';
		echo '</body></html>';
		exit;
	}

	$pk_query = "SELECT email FROM volounteers WHERE email=?";
	$pk_query_stmt = $db->stmt_init();
	$email_exists=true;
	if($pk_query_stmt->prepare($pk_query))
	{
		$stmt_ok = $pk_query_stmt->bind_param("s", $email);
		if($stmt_ok && $pk_query_stmt->execute())
		{
			$email_exists = ($pk_query_stmt->fetch()==null ? false:true);

			if(!$email_exists)
			{
				$erro_message = "Email Already Exists.";
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
	
	if ($error_message != '')
	{
		echo 'Error: '.$error_message.' <a href="javascript: history.back();">Go Back</a>.';
		echo '</body></html>';
		exit;
	}
	elseif (!$email_exists)
	{
		$query = "INSERT INTO volounteers (email, first_name, surname, mobile, address, suburb, 
		postcode, address_2, dob, password)
		VALUES(?,?,?,?,?,?,?,?,?,?)";
		$query_stmt = $db->stmt_init();
		if($query_stmt->prepare($query))
		{
			$stmt_ok = $query_stmt->bind_param("ssssssssss", $email, $firstname, $surname, $mobile, $address, $suburb, 
			$postcode, $addressln2, $dob, $pwd);
			if($stmt_ok && $query_stmt->execute())
			{
				$registered = true;
				header('Location: ./result.php');
				$_SESSION['message'] = "Registered successfully! Please Login using your email and password";
				$_SESSION['redirect'] = "index.php";
				$_SESSION['redirect_msg'] = "Home";
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
			$_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #2".$stmt_ok->errno."</p><p>".$stmt_ok->error."</p>";
			$_SESSION['redirect'] = "index.php";
			$_SESSION['redirect_msg'] = "Home";
			exit;
		}
	}
?>