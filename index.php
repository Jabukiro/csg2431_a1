<!--
  Set as php and check for session cookies. redirect to correct Volounteer/Organiser menu.

  <?php
  session_start();
  
  @ $db = new mysqli('localhost', 'root', '', 'alien');

  if (mysqli_connect_error())
  {
    echo mysqli_connect_error();
    exit;
  }
  
  if ( isset($_SESSION['uname']) && $_SESSION['uname'] != '' )
  {
	  header('Location: '.$_SESSION['level'].'.php');
	  exit;
  }
?>
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area51 RAID!</title>
    <link rel="stylesheet" href="./style.css">
    <link id="icon" rel="icon" href="./img/icon.jpg">

    <script language="JavaScript" type="text/javascript">

      function ValidateLogin()
      {
        if(document.loginForm.uname.value=='' || document.loginForm.pwd.value=='')
        {
          alert('Both Username and Password field cannot be blank');
          document.loginForm.uname.focus();
          return false;
        }
      }

      function ValidateForm()
      {
        var dob_regex = /^[0-9]+-[0-1][0-9]-[0-3][0-9]/ //Matches: 'months' 00, 13-19. 'Days' 33-39!
        var email_regex = /^\w+([\.\-\+\$]?\w+)*@\w+(\.\w+)+/
        
        if (document.registerForm.email.value=='')
        {
          alert('Email Address field cannot be blank');
          document.registerForm.email.focus();
          return false;
        }
        if (document.registerForm.firstname.value=='')
        {
          alert('Firstname field cannot be blank');
          document.registerForm.firstname.focus();
          return false;
        }
        
        if (document.registerForm.surname.value=='')
        {
          alert('Surname field cannot be blank');
          document.registerForm.surname.focus();
          return false;
        }
        
        if (document.registerForm.address.value=='')
        {
          alert('Address field cannot be blank');
          document.registerForm.address.focus();
          return false;
        }

        if (document.registerForm.suburb.value=='')
        {
          alert('Suburb field cannot be blank');
          document.registerForm.suburb.focus();
          return false;
        }
        
        if (document.registerForm.postcode.value=='')
        {
          alert('PostCode field cannot be blank.');
          document.registerForm.postcode.focus();
          return false;
        }

        if (document.registerForm.dob.value=='')
        {
          alert('Date Of Birth field cannot be blank');
          document.registerForm.dob.focus();
          return false;
        }

        if (document.registerForm.pwd.value=='')
        {
          alert('Password field cannot be blank');
          document.registerForm.pwd.focus();
          return false;
        }

        if (document.registerForm.con_pwd.value=='')
        {
          alert('Confirm Password field cannot be blank');
          document.registerForm.con_pwd.focus();
          return false;
        }
        
        if (isNaN(document.registerForm.postcode.value))
        {
          alert('PostCode must be a number.')
        }

        if (isNaN(document.registerForm.mobile.value))
        {
          alert('Mobile is incorrect.')
        }

        if (string.match(document.registerForm.dob.value, email_regex) == null)
        {
          alert('email is of an invalid format.');
          document.registerForm.email.focus();
          return false;
        }

        if (string.match(document.registerForm.dob.value, dob_regex) == null)
        {
          alert('Please adhere to the format YYYY-MM-DD for the date.');
          document.registerForm.dob.focus();
          return false;
        } else{
          var dob=document.registerForm.dob.value.split('-');
          if(dob[1]>12 || dob[2]>31)
          {
            //Still allows some invalid dates. 
            alert('Invalid date entered.');
            document.registerForm.dob.focus();
            return false;
          }
        }
         
        if (document.registerForm.pwd.value.length <5 || document.registerForm.pwd.value.length >16)
        {
          alert('Password length must be between 5 and 16 characters, inclusive.');
          document.registerForm.pwd.focus();
          return false;
        }
        
        if (document.registerForm.con_pwd.value != document.registerForm.pwd.value)
        {
          alert('Password fields do not match.');
          document.registerForm.con_pwd.focus();
          return false;
        }
        return true;
      }
      </script>
</head>
<body background="./img/bg_2.jpg">
    <div class="header">
        <img id="icon" width='50px' height='50px' src = './img/icon.jpg' role='img' style="border-radius: 4pc">
        <div class="header-right">
            <button class="active" 
                    onclick="document.getElementById('id01').style.display='block'
                              document.loginForm.uname.focus()">
                Login
            </button>
            <button class="reg" 
                    onclick="document.getElementById('id02').style.display='block';
                      document.registerForm.email.focus()">
              Register!
            </button>
            <button  class="about">About</button>
        </div>
    </div>
    <div id="id01" class="login">
        <form name="loginForm" class="login-content animate" action="./login.php" method="post" onsubmit="return ValidateLogin();">
          <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Login">&times;</span>
            <img src="img/icon.jpg" alt="Alien" class="alien">
          </div>
      
          <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" id="login_uname" placeholder="Enter Username" name="uname" required>
      
            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" required>
              
            <button type="submit" >Login</button>
          </div>
      
          <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          </div>
        </form>
    </div>
    <div id='id02' class='register'>
      <form name="registerForm" class = "register-content animate" action="./register.php" method="post" onsubmit='return ValidateForm();'>
        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Login">&times;</span>
            <h1>Fill in your details</h1>
        </div>
        <div class="container">
          
            <label for="email"><b>E-Mail*</b></label>
            <input id = "register_email"type="text" name="email" required>

            <label for="firstname"><b>First Name(s)*</b></label>
            <input type="text" name="firstname" required>

            <label for="surname"><b>Surname*</b></label>
            <input type="text" name="surname" required>

            <label for="address"><b>Address Line*</b></label>
            <input type="text" name="address" required>

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
              
            <button type="submit" name="register">Register</button>
            <button id="resetbtn"type="reset">Reset</button>
          </div>
      
          <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
          </div>
      </form>

    </div>
</body>
</html>