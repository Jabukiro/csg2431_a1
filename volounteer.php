<?php
  session_start();
  if (empty($_SESSION['uname']) || $_SESSION['level'] != 'volounteer')
  {
    header('Location: ./index.php');
  }
  @ $db = new mysqli('localhost', 'root', '', 'alien');

  if (mysqli_connect_error())
  {
    echo mysqli_connect_error();
    exit;
  }
  /**
   * Receives the added time slot and inserts it into the DataBase
   */

  if(isset($_POST['add_time']))
  {

    $add_time_stmt = $db->stmt_init();
    $add_time_stmt-> prepare("INSERT INTO volounteer_times 
                                                      (vol_time_id, vol_email, time_id, task_id, description)
                                                VALUES (DEFAULT, ?, ?, NULL, NULL)");
    if ($add_time_stmt->errno){
      echo '<p>Please contact me about this Error #'.$add_time_stmt->errno.':</p>';
      echo '<p>'.$add_time_stmt->error.'</p>';
      exit;
    }
    $add_time_stmt->bind_param('si', $_SESSION['uname'], $_POST['add_time']);
    if ($add_time_stmt->errno)
    {
      echo '<p>Invalid form data. Error #'.$add_time_stmt->errno.':</p>';
      echo '<p>'.$add_time_stmt->error.'</p>';
      exit;
    }
    if(!$add_time_stmt->execute())
    {
      echo'<p>Error inserting details. Error message: <p>';
		  echo'<p>'.$add_time_stmt->error.'</p>';
		  exit;
    }
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
  
  $time_query = "SELECT * FROM time_slots WHERE 1 ORDER BY time_slot_id ASC";
  $time_result = $db->query($time_query);
  if($db->errno)
  {
    echo '<p> An Error happened fetching results #2: '.$db->error;
    echo '</p>';
    exit;
  }

  /**
   * Get The full details regarding the volunteer time slots.
   */
  $full_details = "SELECT * FROM vol_time_full_details WHERE vol_email = '".$_SESSION['uname']."' ORDER BY time_id ASC";
  $full_details_result = $db->query($full_details);
  if($db->errno)
  {
    echo '<p> An Error happened fetching results: '.$query.' '.$db->error;
    echo '</p>';
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
          <a href="./profile.php">
            <button style="background: none"class="active">
                Profile
            </button>
          </a>
          <a href="./logout.php">
            <button style="font-style: normal"id="resetbtn">
              Logout
            </button>
          </a>
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
            <form method="post" action="">
                <table>
                  <tr class="titles" style="width: 100%">
                      <th>Time Slot</th>
                      <th>Allocated Task</th>
                      <th>Details</th>
                      <th class="remove"></th>
                  </tr>
                  <?php
                    $volounteer_times_id = [null];
                    if(!$full_details_result->num_rows)
                    {
                      echo '<tr>';
                      echo '<td><em>No Time slot selected...</em></td>';
                      echo '<td><em>No Task selected...</em></td>';
                      echo '<td></td>';
                      echo '<td class=remove><button type="button" class="addbtn" 
                            onclick="document.getElementById(\'id01\').focus()">
                            Add Time Slot
                            </button></td>';
                      echo '</tr>';
                    }
                    else
                    {
                      for($i=0; $i<$full_details_result->num_rows; $i++)
                      {
                        echo '<tr>';
                        $row = $full_details_result->fetch_assoc();
                        $volounteer_times_id[$i] = $row['time_id'];
                        echo '<td>'.$row['time_slot_name'].'</td>';
                        $task_name = (empty($row['task_id']) ? '<em>No Task alocated...</em>' : $row['task_name']);
                        echo '<td>'.$task_name.'</td>';
                        echo '<td>'.$row['description'].'</td>';
                        echo '<td style="text-align: left"class=remove><button class="addbtn" type="submit" name="remove_time_slot" id="resetbtn" value='.$row['vol_time_id'].'>
                              Remove
                              </button></td>';
                        echo '</tr>';
                      }
                      unset($row);
                      unset($i);
                    }
                  ?>
                </table>
            </form>
          </div>
      
          <div class="container">
              <form id="" method= "post" name = "add_time" action="">
              <h2>Add Time Slot:</h2>
                <?php
                  if($full_details_result->num_rows==$time_result->num_rows)
                  {
                    echo'<h3 style="color: #4CAF50">'.'You Legend! You\'ve booked all time slots!'.'</h3>';
                  }
                  else
                  { 
                    echo '<select name="add_time" id="id01">';
                    for($i=0; $i<$time_result->num_rows; $i++ )
                    {
                      $row = $time_result->fetch_assoc();
                      if (!in_array($row["time_slot_id"], $volounteer_times_id))
                      {
                        echo'<option value='.$row["time_slot_id"].' >'.$row["time_slot_name"].'</option>';
                      }
                    }
                    echo '</select>';
                    echo '<button type="submit" class="addbtn">Add</button>';
                  }
                ?>
              </form>
          </div>
    </div>
    </div>
</body>
</html>