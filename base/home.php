<?php
require_once('db_communication/auth.php');
$title = 'Welcome - '.$user_row['email'];
require_once('layout/header.php');
?>
	<h1>Heading</h1>
<?php
require_once('layout/footer.php');
?>