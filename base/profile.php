#ifdef PROFILE
    <?php
        if(!isset($_SESSION))
        {
            session_start();
        }

        require_once('db_communication/auth.php');
        $title = 'Variables';
        require_once('layout/header.php');
    ?>
    <div class="jumbotron">
        <h1>You are awesome!</h1>
    </div>
    <?php
        require_once('layout/footer.php');
    ?>
#else
    <?php
        require_once('../redirecting.php');
        redirect_to_index();
    ?>
#endif