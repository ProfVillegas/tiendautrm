<?php
    session_start();
    ?>
    <h1>Cerrando sesión</h1>
    <?php

    session_destroy();
    header('location:../index.php');


?>