<!DOCTYPE html>
<html>
<head>
  <title>User Registration Results</title>
</head>

<body>
<?php
    
	$db = new mysqli('localhost', 'root', '', 'alien');


	$query = $db->prepare("INSERT INTO volounteers
	VALUES(?,?,?,?,?,?,?,?,?,?)");
    if ($query){
        echo mysqli_connect_error();
        exit;
	}

	$pk_query = $db->prepare("SELECT email FROM volounteers WHERE email = ?");
	if (mysqli_connect_error()){
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

	$pk_query->bind_param("s", $email);
	if ($pk_query->execute())
	{
		if($pk_query->fetch() != null)
			$error_message = "Email-Address already exists in DataBase";

	}
	else
	{
		echo '<p>Error inserting details. Error message: <p>';
		echo '<p>'.$db->error.'</p>';
		exit;
	}
	if ($error_message != '')
	{
		echo 'Error: '.$error_message.' <a href="javascript: history.back();">Go Back</a>.';
		echo '</body></html>';
		exit;
	}
	else
	{
		$query->bind_param("ssssssssss", $email, $firstname, $surname, $mobile, $address, $suburb, 
										$postcode, $addressln2, $dob, $pwd);
		if($query->execute())
		{
			echo '<p><strong>Registered successfully! Please Login using your email and password</strong></p>';
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
