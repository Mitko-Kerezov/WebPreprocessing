<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('db_communication/auth.php');
$title = 'Variables';
require_once('layout/header.php');
if (isset($variables)) {
    $variables_result = '<h1>Your variables:</h1>
    <table class="table table-striped table-hover ">
    <thead>
        <tr>
        <th>#</th>
        <th>Key</th>
        <th>Value</th>
        <th>Edit</th>
        <th>Delete</th>
        </tr>
    </thead>
    <tbody>';
    foreach ($variables as $index => $var_arr) {
        $key = $var_arr['var_key'];
        $value = $var_arr['var_value'];
        $id = $var_arr['id'];
        $variables_result .= '<tr>
            <td>'.($index + 1).'</td>
            <td>'.$key.'</td>
            <td>'.$value.'</td>
            <td><a class="glyphicon glyphicon-pencil" href="/webpreprocessing/website/variable_form.php?id='.$id.'"></a></td>
            <td><a class="glyphicon glyphicon-trash" href="/webpreprocessing/website/db_communication/management.php?operation=delete&id='.$id.'"></a></td>
        </tr>';
    }

    $variables_result .= '</tbody></table>';
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    echo $variables_result;
} else {
    echo '<h1>You don\'t have any variables yet :(</h1>';
}
?>
<a class="glyphicon glyphicon-plus-sign text-success pull-right" href="/webpreprocessing/website/variable_form.php"></a>
<?php
require_once('layout/footer.php');
?>