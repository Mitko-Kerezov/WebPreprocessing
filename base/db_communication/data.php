<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('dbconnect.php');

$query = $MySQLi_CON->query('SELECT * FROM users WHERE user_id='.$_SESSION['user-id']);
$user_row=$query->fetch_array();

$query = $MySQLi_CON->query('SELECT * FROM variables WHERE user_id='.$_SESSION['user-id']);
while ($variables_row=$query->fetch_assoc()) {
    $variables[] = $variables_row;
}
?>