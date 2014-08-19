<?php

    if(isset($_POST['vermili']) && $_POST['vermili'] == "external") {
        $_SESSION['newlink'] = $_POST;
        // header('Location: ');
        echo $_SERVER['PHP_SELF'] . '/../login';
    }

?>
