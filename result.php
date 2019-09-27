<?php
    session_start();
    if(empty($_SESSION['message']))
    {   
        header('Location: index.html');
        exit;
    }
    $message = $_SESSION['message'];
    $redirect = $_SESSION['redirect'];
    $redirect_msg = $_SESSION['redirect_msg'];
    echo '<html><body>';
    echo '<p>'.$message.'<a href="'.$redirect.'">'.$redirect_msg.'</a></p>';
    echo '</body></html>';
?>