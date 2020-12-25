<?php

    session_start();
    if (!isset($_SESSION["nomeAdmin"]) == true) {
        header("Location: index.php");
        exit();
    }
