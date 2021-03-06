<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('../redirecting.php');

if(isset($_SESSION['user-id'])!='') {
	redirect_to_index();
}

require_once('db_communication/dbconnect.php');

if(isset($_POST['btn-signup']))
{
	$uname = $MySQLi_CON->real_escape_string(trim($_POST['user_name']));
	$email = $MySQLi_CON->real_escape_string(trim($_POST['email']));
	$upass = $MySQLi_CON->real_escape_string(trim($_POST['password']));

	$new_password = password_hash($upass, PASSWORD_DEFAULT);

	$check_email = $MySQLi_CON->query("SELECT email FROM users WHERE email='$email'");

	if(!$check_email->num_rows) {
		$query = "INSERT INTO users(username, email, password) VALUES('$uname','$email','$new_password')";
		if($MySQLi_CON->query($query)){
			$msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					</div>";
		} else {
			$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
					</div>";
		}
	} else{
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Email already taken !
				</div>";
	}

	}

$title = 'Registration';
$hide_menu = true;
require_once('layout/header.php');
?>
<div class="signin-form">

	<form method="post" id="register-form">

		<h2>Sign Up</h2><hr />

		<?php
		if(isset($msg)){
			echo $msg;
		}
		else{
			?>
			<div class='alert alert-info'>
				<span class='glyphicon glyphicon-asterisk'></span> &nbsp; all the fields are mandatory !
			</div>
			<?php
		}
		?>

		<div class="form-group">
		<input type="text" class="form-control" placeholder="Username" name="user_name" required  />
		</div>

		<div class="form-group">
		<input type="email" class="form-control" placeholder="Email address" name="email" required  />
		<span id="check-e"></span>
		</div>

		<div class="form-group">
		<input type="password" class="form-control" placeholder="Password" name="password" required  />
		</div>

		<hr />

		<div class="form-group">
			<button type="submit" class="btn btn-default" name="btn-signup">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
			</button>

			<a href="index.php" class="btn btn-default" style="float:right;">Log In Here</a>

		</div>

	</form>

</div>

<?php
require_once('layout/footer.php');
?>