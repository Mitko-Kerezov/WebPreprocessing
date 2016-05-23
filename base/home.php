<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$query = $MySQLi_CON->query("SELECT * FROM users WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$MySQLi_CON->close();

$title = 'Welcome - '.$userRow['email'];
require_once('layout/header.php');
?>
	<h1>Heading</h1>
<?php
require_once('layout/footer.php');
?>