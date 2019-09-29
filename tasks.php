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
  $updated=false;
  if(isset($_POST['new_task']))
  {
    $add_query = "INSERT INTO tasks (task_id,task_name) VALUES(DEFAULT,?)";
    $add_stmt = $db->stmt_init();
    if($add_stmt->prepare($add_query))
    {
      $stmt_ok = $add_stmt->bind_param('s', $_POST['new_task_name']) ;
      if($stmt_ok && $add_stmt->execute())
      {
        $updated = true;
      } else{
        header('Location: ./result.php');
        $_SESSION['message'] = "There was an error with your input.";
        $_SESSION['redirect'] = "tasks.php";
        $_SESSION['redirect_msg'] = "Manage Tasks";
        exit;
      }
    } else{
      header('Location: ./result.php');
      $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #".$stmt_ok->errno."</p><p>".$stmt_ok->error."</p>";
      $_SESSION['redirect'] = "organisers.php";
      $_SESSION['redirect_msg'] = "Home";
      exit;
    }
    unset($_POST['new_task']);
  }

  if(isset($_POST['Update']))
  {
    $edit_query = "UPDATE tasks SET task_name=? WHERE task_id=?";
    $edit_stmt = $db->stmt_init();
    if($edit_stmt->prepare($edit_query))
    {
      $edited_task_name = 'edited_task_name_'.$_POST['Update']; #targets the correct input field

      $stmt_ok = $edit_stmt->bind_param('si', $_POST[$edited_task_name], $_POST['Update']) ;
      if($stmt_ok && $edit_stmt->execute())
      {
        $updated = true;
      } else{
        header('Location: ./result.php');
        $_SESSION['message'] = "There was an error with your input.";
        $_SESSION['redirect'] = "tasks.php";
        $_SESSION['redirect_msg'] = "Manage Tasks";
        exit;
      }
    } else{
      header('Location: ./result.php');
      $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #".$stmt_ok->errno."</p><p>".$stmt_ok->error."</p>";
      $_SESSION['redirect'] = "organisers.php";
      $_SESSION['redirect_msg'] = "Home";
      exit;
    }
    unset($_POST['Update']);
  }

  if(isset($_POST['remove_task']))
  {
    $del_query = "DELETE FROM tasks WHERE task_id=?";
    $del_stmt = $db->stmt_init();
    if($del_stmt->prepare($del_query))
    {
      $stmt_ok = $del_stmt->bind_param('i', $_POST['remove_task']) ;
      if($stmt_ok && $del_stmt->execute())
      {
        $updated = true;
      } else{
        header('Location: ./result.php');
        $_SESSION['message'] = "There was an error with your input.";
        $_SESSION['redirect'] = "tasks.php";
        $_SESSION['redirect_msg'] = "Manage Tasks";
        exit;
      }
    } else{
      header('Location: ./result.php');
      $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #".$stmt_ok->errno."</p><p>".$stmt_ok->error."</p>";
      $_SESSION['redirect'] = "organisers.php";
      $_SESSION['redirect_msg'] = "Home";
      exit;
    }
    unset($_POST['remove_task']);
  }
  $query = "SELECT * FROM tasks WHERE 1 ORDER BY task_name ASC;";
  $result = $db->query($query);
  if($db->errno)
  {
    header('Location: ./result.php');
    $_SESSION['message'] = "There was an error. Please contact me using the details in the about section.</p><p>Error #".$db->errno."</p><p>".$db->error."</p>";
    $_SESSION['redirect'] = "index.php";
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
<body background="./img/bg_2.jpg">
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
  <div id="id03" class='mainContainer'> 
  <div id='id02' class="register-content animate" style="display: block">
      <div class="imgcontainer">
          <h2>Manage Tasks</h2>
      </div>
      <div class="container">
      <form method="post" action="" style="width: 60%">
        <label for="table"><h3>Current Tasks</h3></label>
        <table name="table" id="manageTasks" style="width: 80%">
          <tr class="titles" >
            <th>Task Name</th>
            <th class="remove"></th>
              
          </tr>
          <?php
            if(isset($_POST['Edit']))
            {
              $edit = "Update";
              $disabled = null;
              $cancel = '<div class="container" style="background:none">
              <a href="./tasks.php"><button type="button" class="cancelbtn">Cancel</button></a>
              </div>';
            } else{
              $edit = "Edit";
              $disabled = 'disabled';
              $cancel = null;
            }
            for($i=0; $i<$result->num_rows; $i++)
            {
              $row = $result->fetch_assoc();
              echo '<tr>';
              echo '<td> <input name="edited_task_name_'.$row['task_id'].'" '.$disabled;
              echo ' value="'.$row["task_name"].'">';
              echo '</input></td>';
              echo '<td style="text-align: left" class=remove>';
              echo '<button style="color: #4CAF50" type="submit" class="addbtn" id="resetbtn" name="';
              echo $edit.'" value='.$row['task_id'].'>';
              echo $edit;
              echo '</button>';
              echo '<button class="addbtn" type="submit" name="remove_task" id="resetbtn" value='.$row['task_id'].'>
              Remove
              </button></td>';
              echo '</tr>';
            }
            echo'</form></table>';
            echo $cancel;
          ?>
        </form>
        </table>
      </div>
    <div class="container">
      <form id="" method= "post" name = "add_task" action="">
        <label for="new_task"><h3>Add Task:</h3></label>
        <input name="new_task_name"id="new_task" type="text" style="width: 50%" placeholder="Task Name">
        <button type="submit" name="new_task" class="addbtn">Add</button>
      </form>
    </div>
  </div>
  </div>

</body>
</html>