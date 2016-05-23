<?php
if(!isset($_SESSION))
{
    session_start();
}

if(!isset($_SESSION['user-id']))
{
	header('Location: index.php');
}
else if(isset($_SESSION['user-id'])!='')
{
	header('Location: home.php');
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user-id']);
	header('Location: index.php');
}
?>