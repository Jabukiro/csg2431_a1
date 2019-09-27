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

  $query = "SELECT vol_time_id,time_slot_name,full_name,task_name, description FROM vol_time_full_details WHERE 1 ORDER BY time_id ASC;";
  $result = $db->query($query);
  if($db->errno)
  {
    echo '<p> An Error happened fetching results #1: '.$query.' '.$db->error;
    echo '</p>';
  }

  /**
   * Implement a view that colates the vol_time_id with the corresponding details associated with the volounteer name.
   */
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
        <div class="login-content animate" id="organiserContainer">
          <div class="welcome">
              <?php
                echo '<p><strong><em>Welcome, '.$_SESSION['uname'].'. Organise these minions well. They must <u>serve</u> our purpose.</em></strong></p>';
              ?>
          <div class="container">
            <h2>Current Volounteer Time Slots:</h2>
            <form method="post" action="./edit.php">
            <table>
              <tr class="titles" style="width: 100%">
                  <th>Time Slot</th>
                  <th>Volounteer Name</th>
                  <th>Allocated Task</th>
                  <th>Deets</th>
                  <th class="remove"></th>
              </tr>
              <?php
                if(!$result->num_rows)
                {
                  echo '<tr>';
                  echo '<td style="text-align: center"><em>No</em></td>';
                  echo '<td style="text-align: center"><em>Volounteer</em></td>';
                  echo '<td style="text-align: center">Yet</td>';
                  echo '<td style="text-align: center">:(</td>';
                  echo '</tr>';
                }
                else
                {
                  for($i=0; $i<$result->num_rows; $i++)
                  {
                    $row = $result->fetch_assoc();
                    $task_name = (empty($row['task_id']) ? '<em>No Task alocated...</em>' : $row['task_name']);
                    echo '<tr>';
                    echo '<td>'.$row['time_slot_name'].'</td>';
                    echo '<td>'.$row['full_name'].'</td>';#Volounteer full name from to be inserted here
                    echo '<td>'.$task_name.'</td>';#Task Name to be inserted here
                    echo '<td>'.$row['description'].'</td>';
                    echo '<td style="text-align: left" class=remove>
                          <button style="color: #4CAF50" type="submit" class="addbtn" id="resetbtn" name="edit_task" value='.$row['vol_time_id'].'>
                          Edit
                          </button></td>';#Make it popup like the register form.
                    echo '</tr>';
                  }
                  unset($row);
                  unset($i);
                }
              ?>
            </table>
            </form>
          </div>
        </div>
    </div>
</body>
</html>