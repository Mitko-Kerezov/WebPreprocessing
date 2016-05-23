<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('db_communication/auth.php');
require_once('db_communication/dbconnect.php');
require_once('../redirecting.php');

$title = 'Manage variables';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$submit_class = 'success';
$submit_text = 'Add';
$operation = 'add';
$key = '';
$value = '';
if (!empty($id)) {
	$submit_class = 'warning';
	$submit_text = 'Modify';
	$operation = 'edit';
	$query = $MySQLi_CON->query('SELECT * FROM variables WHERE user_id='.$_SESSION['user-id'].' and id='.$MySQLi_CON->real_escape_string(trim($id)));
	if (!$query || !$query->num_rows) {
		redirect_to_index();
	}

	$variable = $query->fetch_assoc();
	$id = $variable['id'];
	$key = $variable['var_key'];
	$value = $variable['var_value'];
}

require_once('layout/header.php');
?>
	<form method="get" id="login-form" action="/webpreprocessing/website/db_communication/management.php">

	<h2>Manage variables</h2><hr />

	<div class="form-group">
		<label for="key">Key:</label>
		<input type="text" id="key" class="form-control" placeholder="Key" name="key" value="<?php echo $key; ?>" required />
	</div>

	<div class="form-group">
		<label for="value">Value:</label>
		<input type="text" id="value" class="form-control" placeholder="Value" name="value" value="<?php echo $value; ?>" required />
	</div>

	<input type="hidden" name="operation" value="<?php echo $operation; ?>" />
	<input type="hidden" name="id" value="<?php echo $id; ?>" />

	<hr />

	<div class="form-group">
		<button type="submit" class="btn btn-<?php echo $submit_class; ?>"><?php echo $submit_text; ?></button>
	</div>

	</form>
<?php
require_once('layout/footer.php');
?>