<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['userSession'])!="")
{
	header("Location: home.php");
	exit;
}

if(isset($_POST['btn-login']))
{
	$email = $MySQLi_CON->real_escape_string(trim($_POST['email']));
	$upass = $MySQLi_CON->real_escape_string(trim($_POST['password']));

	$query = $MySQLi_CON->query("SELECT user_id, email, password FROM users WHERE email='$email'");
	$row=$query->fetch_array();

	if(password_verify($upass, $row['password'])) {
		$_SESSION['userSession'] = $row['user_id'];
		header("Location: home.php");
	} else {
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; email or password does not exists !
				</div>";
	}

	$MySQLi_CON->close();

}

$title = 'Login';
$hide_menu = true;
require_once('layout/header.php');
?>


<div class="signin-form">


	<form class="form-signin" method="post" id="login-form">

	<h2 class="form-signin-heading">Sign In.</h2><hr />

	<?php
	if(isset($msg)){
		echo $msg;
	}
	?>

	<div class="form-group">
	<input type="email" class="form-control" placeholder="Email address" name="email" required />
	<span id="check-e"></span>
	</div>

	<div class="form-group">
	<input type="password" class="form-control" placeholder="Password" name="password" required />
	</div>

	<hr />

	<div class="form-group">
		<button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
		</button>

		<a href="register.php" class="btn btn-default" style="float:right;">Sign UP Here</a>

	</div>



	</form>

</div>

<?php
require_once('layout/footer.php');
?>