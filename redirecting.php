<?php
require_once('constants.php');

function redirect($location) {
    header('Location: http://'.$_SERVER[HTTP_HOST].'/'._WEBPREPROCESSING.'/'.$location);
    die();
}

function redirect_to_home() {
    redirect(_HOME);
}

function redirect_to_index() {
    redirect(_WEBSITE);
}

function redirect_to_variables() {
    redirect(_VARIABLES);
}
?>
