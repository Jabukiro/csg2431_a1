<?php
    session_name();
    if(empty($_POST['edit_task']) || $_SESSION('level') = 'organiser')
    {
        header('Location: ./index.html');
    }
?>