<?php
if(!isset($_SESSION))
{
    session_start();
}

require_once('dbconnect.php');
require_once('auth.php');
require_once('../../preprocessing.php');
require_once('../layout/messages.php');

function delete_variable($MySQLi_CON, $id) {
    $MySQLi_CON->query('DELETE FROM variables WHERE user_id='.$_SESSION['user-id'].' and id='.$MySQLi_CON->real_escape_string(trim($id)));
    if ($MySQLi_CON->affected_rows) {
        $_SESSION['msg'] = get_success('Successfully deleted variable!');
    }
}

function add_variable($MySQLi_CON, $key, $value) {
    $query = $MySQLi_CON->query('INSERT INTO variables(`var_key`, `var_value`, `user_id`) VALUES ("'.$MySQLi_CON->real_escape_string(trim($key)).'", "'.$MySQLi_CON->real_escape_string(trim($value)).'", '.$_SESSION['user-id'].')');
    $_SESSION['msg'] = $query ? get_success('Successfully set variable '.$key.' to '.$value.'!') : get_error('Could not set variable '.$key.' to '.$value.'!');
}

function edit_variable($MySQLi_CON, $id, $key, $value) {
    $query = $MySQLi_CON->query('UPDATE variables SET var_key = "'.$MySQLi_CON->real_escape_string(trim($key)).'", var_value = "'.$MySQLi_CON->real_escape_string(trim($value)).'"  WHERE id = '.$MySQLi_CON->real_escape_string(trim($id)).' and user_id = '.$_SESSION['user-id']);
    $_SESSION['msg'] = $query ? get_success('Successfully modified variable '.$key.' to '.$value.'!') : get_error('Could not set variable '.$key.' to '.$value.'!');
}

if (isset($_GET['operation'])) {
    switch ($_GET['operation']) {
        case 'delete':
            if (!isset($_GET['id'])) {
                break;
            }
            delete_variable($MySQLi_CON, $_GET['id']);
            break;
        case 'add':
            if (!isset($_GET['key']) || !isset($_GET['value'])) {
                break;
            }
            add_variable($MySQLi_CON, $_GET['key'], $_GET['value']);
            break;
        case 'edit':
            if (!isset($_GET['id']) || !isset($_GET['key']) || !isset($_GET['value'])) {
                break;
            }
            edit_variable($MySQLi_CON, $_GET['id'], $_GET['key'], $_GET['value']);
    }
}

create_website();
redirect_to_variables();
?>