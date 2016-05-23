<?php
require_once('constants.php');

function redirect_to_home() {
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"._WEBSITE);
    die();
}

if (!file_exists(_WEBSITE_DIRECTORY.DIRECTORY_SEPARATOR.'index.php')) {
    require_once('preprocessing.php');
}


redirect_to_home();
?>