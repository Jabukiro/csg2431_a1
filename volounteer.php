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

  if(isset($_POST['add_time']))
  {
    #echo 'Form name available. Begin:'.$_POST["add_time"].'end';
    $add_time_query = $db-> PREPARE("INSERT INTO volounteer_times
                      VALUES (NULL,?,?,'remember to set this column to be able to be null')");
    if (mysqli_connect_error()){
      echo mysqli_connect_error();
      exit;
    }
    $task_id = 1;
    $add_time_query->bind_param('ii', $_POST['add_time'], $task_id);
    if(!$add_time_query->execute())
    {
      echo'<p>time_id=='.$_POST['add_time'].'</p>';
      echo'<p> task_id=='.$task_id.'</p>';
      echo'<p>Error inserting details. Error message: <p>';
		  echo'<p>'.$db->error.'</p>';
		  exit;
    }
  
  if(isset($_POST['remove_time_slot']))
  {
    #echo 'Form name available. Begin:'.$_POST["add_time"].'end';
    $remove_time_query = $db-> PREPARE("DELETE FROM volounteer_times
                      WHERE vol_time_id = ?");
    if (mysqli_connect_error())
    {
      echo mysqli_connect_error();
      exit;
    }
  $remove_time_query->bind_param('i', $_POST['remove_time_slot']);
  if(!$remove_time_query->execute())
  {
    echo '<p>Error inserting details. Error message: <p>';
    echo '<p>'.$db->error.'</p>';
    exit;
  }
  header('Location: ./volounteer.php');
  }

  $query = "SELECT * FROM volounteer_times WHERE vol_time_id = '".$_SESSION['uname']."' ORDER BY time_id ASC";
  $result = $db->query($query);
  if($db->errno)
  {
    echo '<p> An Error happened fetching results #1: '.$query.' '.$db->error;
    echo '</p>';
  }

  $time_query = "SELECT * FROM time_slots WHERE 1 ORDER BY time_slot_id ASC";
  $time_result = $db->query($time_query);
  if($db->errno)
  {
    echo '<p> An Error happened fetching results #2: '.$db->error;
    echo '</p>';
  }
  echo '<p>1st PHP block run</p>'
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
                echo '<p><strong><em>Welcome, '.$_SESSION['uname'].'. The Raid awaits your help!</em></strong></p>';
              ?>
          </div>
      
          <div class="container">
            <h2>Your Time Slots:</h2>
            <form method="post" action=>
                <table>
                    <tr class="titles" style="width: 100%">
                        <th>Time Slot</th>
                        <th>Allocated Task</th>
                        <th>Details</th>
                        <th id="remove"><em></em></th>
                    </tr>
                    <tr>
                    <?php
                      $volounteer_times_id = [null];
                      if(!$result->num_rows)
                      {
                        echo '<td><em>No Time slot selected...</em></td>';
                        echo '<td><em>No Task selected...</em></td>';
                        echo '<button class="addbtn">
                              Add Time Slot
                              </button>';
                      }
                      else
                      {
                        for($i=0; $i<$result->num_rows; $i++)
                        {
                          $row = $result->fetch_assoc();
                          $volounteer_times_id[i] = $row['time_id'];
                          echo '<td>'.$row['time_id'].'</td>';
                          echo '<td>'.$row['task_id'].'</td>';
                          echo '<td>'.$row['description'].'</td>';
                          echo '<button type="submit" name="remove_time_slot" id=resetbtn value='.$row['vol_time_id'].'>
                                Remove
                                </button>';
                        }
                        unset($row);
                        unset($i);
                      }
                    ?>
                </table>
            </form>
          </div>
      
          <div class="container">
              <form method= "post" name = "add_time" action="">
              <h2>Add Time Slot:</h2>
                <?php
                  if($time_result->num_rows == $result->num_rows)
                  {
                    echo'<select name="add_time" id="add_time" default="You Legend! You\'ve booked all time slots!">';
                  }
                  else
                  { 
                    echo '<select name="add_time" id="add_time">';
                    for($i=0; $i<$time_result->num_rows; $i++ )
                    {
                      $row = $time_result->fetch_assoc();
                      if (!in_array($row["time_slot_id"], $volounteer_times_id))
                      {
                        echo'<option value="'.$row["time_slot_id"].'">'.$row["time_slot_name"].'</option>';
                      }
                    }
                  }
                ?>
              </select>
              <button type="submit" class="addbtn">Add</button>
              </form>
          </div>
    </div>
                }
    </div>
</body>
</html>