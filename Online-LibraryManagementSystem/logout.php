<?php
	session_start();
    //Unset All session
    session_destroy();

	/*if(isset($_SESSION['login_user']))
	{
		unset($_SESSION['login_user']);
	}
    if(isset($_SESSION['user']))
	{
		unset($_SESSION['user']);
	}*/
    //redirect
	header("location:index.php");
?>