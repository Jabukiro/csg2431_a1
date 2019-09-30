<?php
    session_start();

    if($_SESSION['level'] != 'organiser' || !isset($_POST['edit_task']) || $_POST['edit_task']=='')
    {
       header('Location: ./index.html');
    }
    @ $db = new mysqli('localhost', 'root', '', 'alien');

    if (mysqli_connect_error())
    {
      echo mysqli_connect_error();
      exit;
    }

    $query = "SELECT vol_time_id,time_slot_name,full_name,task_name, description FROM vol_time_full_details WHERE vol_time_id=? ORDER BY time_id ASC;";
    $edit_time_stmt = $db->stmt_init();
    
    if($edit_time_stmt->prepare($query))
    {
        $stmt_ok = $edit_time_stmt->bind_param('i', $_POST['edit_task']);
        if(!($stmt_ok && $edit_time_stmt->execute()))
        {
            header('Location: ./result.php');
            $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #".$update_stmt->errno."</p><p>".$update_stmt->error."</p>";
            $_SESSION['redirect'] = "index.html";
            $_SESSION['redirect_msg'] = "Edit Profile";
            exit;
        }
        else
        {
            $stmt_result= $edit_time_stmt->get_result();
            $result = $stmt_result->fetch_array(MYSQLI_ASSOC); #Stores the information to edit        
        }

    }
    else
    {
        header('Location: ./result.php');
        $_SESSION['message'] = "There was an error </p><p>Error #".$update_stmt->errno."</p><p>".$update_stmt->error."</p>";
        $_SESSION['redirect'] = "profile.php";
        $_SESSION['redirect_msg'] = "Edit Profile";
        exit;
    }
    $task_query="SELECT * FROM tasks WHERE 1 ORDER BY task_name;";
    $task_result = $db->query($task_query);
    if($db->errno)
    {
        header('Location: ./result.php');
        $_SESSION['message'] = '<p> An Error happened fetching results #1: '.$db->errno.' '.$db->error;
        $_SESSION['redirect'] = "organiser.php";
        $_SESSION['redirect_msg'] = "Organiser section.";
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
            <button  class="about">About</button>
        </div>
    </div>
    <div id='id02' class='register' style="display: block">
        <form method="post" action="./organiser.php" class="register-content animate" style="width: 80%" onsubmit="return confirm('Are you sure you want to perform that action?')";>
            <div class="imgcontainer">
                <a href="./organiser.php"><span class="close" title="Close Login">&times;</span></a>
                <h2>Edit Volounteer Tasks:</h2>
            </div>
            <div class="container">
                <table>
                    <tr class="titles" style="width: 100%">
                        <th>Time Slot</th>
                        <th>Volounteer Name</th>
                        <th>Allocated Task</th>
                        <th>Deets</th>
                        <th class="remove"></th>
                    </tr>
                    <?php
                        echo'<tr>';
                        echo '<td>'.$result['time_slot_name'].'</td>';
                        echo '<td>'.$result['full_name'].'</td>';#Volounteer full name from to be inserted here
                        echo '<td>';
                        echo '<select name="update_vol_task" id="focus_point" >'; #Starts drop down list

                        for($i=0; $i<$task_result->num_rows; $i++)
                        {
                            $row = $task_result->fetch_assoc();
                            $selected = ($row['task_name'] == $result['task_name'] ? 'selected':null);
                            echo '<option value="'.$row["task_id"].'"'.$selected.' >'.$row["task_name"];
                            echo '</option>';
                        }
                        echo'</select></td>';
                        echo '<td>';
                        echo '<textarea name="description" maxlength="240" placeholder="'.$result['description'].'">';
                        echo '</textarea>';
                        echo '<td style="text-align: left" class=remove>
                        <button style="color: #4CAF50" type="submit" class="addbtn" id="resetbtn" name="update_vol_time" value='.$result['vol_time_id'].'>
                        Update
                        </button></td>';
                        echo'</tr>';
                    ?>
                </table>
                <?php
                    echo '<button value="'.$result['vol_time_id'];
                    echo '" style="background:buttonface;color:red" type="submit" name="clear_slot" class="cancelbtn">';
                    echo 'Clear Slot</button>';
                ?>
            </div>
            <div class="container" style="background-color:#f1f1f1">
            <a href="./organiser.php"><button type="button" class="cancelbtn">Cancel</button></a>

          </div>
        </form>
    </div>
</html>
</body>