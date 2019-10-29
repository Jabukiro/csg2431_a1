<?php
  session_start();
  if (empty($_SESSION['uname']) || $_SESSION['level'] != 'organiser')
  {
    header('Location: ./index.php');
  }
  @ $db = new mysqli('localhost', 'root', '', 'alien');

  if (mysqli_connect_error())
  {
    echo mysqli_connect_error();
    exit;
  }
  
  #Day slots in reverse order
  $query = "SELECT * FROM time_slots WHERE 1 ORDER BY time_slot_day Desc;";
  $query_result = $db->query($query);
  if($db->errno)
  {
      header('Location: ./result.php');
      $_SESSION['message'] = '<p> An Error happened fetching results #1: '.$db->errno.' '.$db->error;
      $_SESSION['redirect'] = "organiser.php";
      $_SESSION['redirect_msg'] = "Organiser section.";
  }
  $time_slot_count = mysqli_num_rows($query_result);
  $query_rows = $query_result->fetch_all(MYSQLI_ASSOC);
  #set constants
  $last_day = $query_rows[1];
  static $MAXDAYS = 14;
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
            <a href="./logout.php">
            <button style="font-style: normal"id="resetbtn">
              Logout
            </button>
            </a>
        </div>
    </div>
    <div id='id02' class='register' style="display: block">
        <div class="register-content animate" style="width: 60%">
            <div class="imgcontainer">
                <a href="./organiser.php"><span class="close" title="Close Login">&times;</span></a>
                <h2>Increase Event Duration</h2>
            </div>

        <div class="container">
            <?php
            if(!isset($_POST['add_time']))
            {
                echo'<form id="" method= "post" name = "add_time" action="">';
                echo'<label for="new_time"><h3>Add Day(s)</h3></label>';
                echo'<select name="new_time" id="focus_point" >';
                
                #Display Day options based on how many days already set
                for($i=$time_slot_count; $i<=$MAXDAYS; $i++)
                {
                    echo'<option value= 1">'.$i.'</option>';
                }
                echo'</select>';
                echo'<button type="submit" name="new_day" class="addbtn" title="Add Full Day(s)" value="full">Add FD</button>';
                echo'/';
                echo'<button type="submit" name="new_day" class="addbtn" title="Add Half day or Morning only..." value="half">Add HD...</button>';
                echo'</form>';

                #Set up table and headers
                echo'<label for="current_time"><h3>Current Event Set-Up</h3></label>';
                echo'<table name="current_time" style="width:400px">';
                echo'<tr class="titles">';
                echo'<th>Day</th>';
                echo'<th>Day Length</th>';
                echo'</tr>';
                $curr_day = 1;
                $yesterday;
                $count = 0;
                $length = 'Morning only';
                for($i=$time_slot_count-1; $i>=-1; $i--)
                {
                    if ($i != -1 && $curr_day == $query_rows[$i]['time_slot_day']){
                        $count++;
                        $ii = ($i == $time_slot_count-1 ? $i : $i+1); #previous row if not at begining
                        $yesterday = $query_rows[$ii]['time_slot_day'];
                        if ($count == 3){
                            #3 time slots. Means full day
                            $length = 'Full Day';
                        } else{
                            #count will be 1 or 2 hence 1 or 2 time slots
                            #Hence morning only or with afternoon
                            $length = ($count == 1 ? 'Morning only':'Morning & Afternoon');
                        }
                        continue;
                        
                    }elseif ($i == -1){
                        $yesterday = $query_rows[0]['time_slot_day'];
                        $count++;

                        if ($count == 3){
                            #3 time slots. Means full day
                            $length = 'Full Day';
                        } else{
                            #count will be 1 or 2 hence 1 or 2 time slots
                            #Hence morning only or with afternoon
                            $length = ($count == 1 ? 'Morning only':'Morning & Afternoon');
                        }                        
                    }
                    echo '<tr>';
                    echo '<td> '.'Day '.$yesterday.'</td>';
                    echo '<td>'.$length.'</td>';
                    $curr_day++;
                    $count = 0;
                    $length = 'Morning only';
                }
                echo'</tr>';
                echo'</table>';
            }
            ?>
        </div>
        </div>
    </div>
</body>
</html>