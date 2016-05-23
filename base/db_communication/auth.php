<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('dbconnect.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'redirecting.php');

if(!isset($_SESSION['user-id'])) {
	redirect_to_index();
}

require_once('data.php');
?>