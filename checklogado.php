<?php

    session_start();
    if (!isset($_SESSION["nome"]) == true) {
        header("Location: index.php");
        exit();
    }
