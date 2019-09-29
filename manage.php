<?php
  session_start();
  if (empty($_SESSION['uname']) || $_SESSION['level'] != 'organiser')
  {
    header('Location: ./index.html');
  }
  @ $db = new mysqli('localhost', 'root', '', 'alien');

  if (mysqli_connect_error())
  {
    echo mysqli_connect_error();
    exit;
  }

  $query = "SELECT * FROM tasks WHERE 1 ORDER BY task_name ASC;";
  $result = $db->query($query);
  if($db->errno)
  {
    header('Location: ./result.php');
    $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #".$db->errno."</p><p>".$db->error."</p>";
    $_SESSION['redirect'] = "index.html";
    $_SESSION['redirect_msg'] = "Home";
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
<body background="./img/bg_2.jpg" onload="document.getElementById('focus_point').focus()">
<div class="header">
        <img id="icon" width='50px' height='50px' src = './img/icon.jpg' role='img' style="border-radius: 4pc">
        <div class="header-right">
            <a href='./organiser.php'><button class="active">
                Allocate Tasks
            </button></a>
            <a href="./logout.php">
            <button style="font-style: normal"id="resetbtn">
              Logout
            </button>
            </a>
            <button  class="about">About</button>
        </div>
    </div>
    <div id='id02' class='register' style="display: block">
        <form method="post" action="./organiser.php" class="register-content animate" style="width: 60%">
            <div class="imgcontainer">
                <a href="./organiser.php"><span class="close" title="Close Login">&times;</span></a>
                <h2>Current Tasks:</h2>
            </div>
            <div class="container">
                <table>
                    <tr class="titles" style="width: 33%">
                        <th>Task Name</th>
                        <th class="remove"></th>
                        <th class="remove"></th>
                    </tr>
                    <?php
                        for($i=0; $i<$result->num_rows; $i++)
                        {
                            $row = $result->fetch_assoc();
                            echo '<tr>';
                            echo '<td>'.$row["task_name"];
                            echo '</td>';
                            echo '<td style="text-align: left" class=remove>
                            <button style="color: #4CAF50" type="submit" class="addbtn" id="resetbtn" name="edit_task" value='.$row['task_id'].'>
                            Edit
                            </button></td>';
                            echo '<td style="text-align: left" class=remove><button class="addbtn" type="submit" name="remove_task" id="resetbtn" value='.$row['task_id'].'>
                            Remove
                            </button></td>';
                            echo '</tr>';
                        }
                    ?>