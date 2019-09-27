<?php
    #session_name();
    #if(empty($_POST['edit_task']) || $_SESSION('level') = 'organiser')
    #{
     #   header('Location: ./index.html');
    #}
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
        <form method="post" action="./edit.php" class="register-content animate">
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
                    <tr>
                        <td>Bla</td>
                        <td><select name="" id="">
                            <option value="">foo</option>
                            <option value="">bar</option>
                        </select></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</html>
</body>