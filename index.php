<?php
require_once('redirecting.php');
require_once('preprocessing.php');

if (!file_exists(_WEBSITE_DIRECTORY.DIRECTORY_SEPARATOR.'index.php')) {
    create_website();
}


redirect_to_index();
?>