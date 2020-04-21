<?php
error_reporting(0);
include('includes/connection.php');
if(isset($_SESSION['pgasuid']))
{
    if((time() -$_SESSION['last_login_timestmp'])>900)
    {
        header("location:../logout.php");
    }
    else
    {
        $_SESSION['last_login_timestmp'] = time();
    }
}
?>