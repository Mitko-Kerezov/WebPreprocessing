<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        #ifdef CYBORG
        <link href="bootstrap/css/bootstrap-cyborg.min.css" rel="stylesheet" media="screen">
        #else
        <link href="bootstrap/css/bootstrap-default.min.css" rel="stylesheet" media="screen">
        #endif
        <link href="layout/style.css" rel="stylesheet" media="screen">
    </head>



    <body>
<?php
    if (!isset($hide_menu) || !$hide_menu) {
?>
        <div class="navbar navbar-default">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/webpreprocessing/website">Web preprocessing</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/webpreprocessing/website/variables.php">Variables</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $user_row['username']; ?></a></li>
                    <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
                </ul>
                </div>
        </div>
<?php
    }
?>
        <div class="container">