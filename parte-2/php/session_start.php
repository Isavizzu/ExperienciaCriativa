<?php
    if (session_id() == ""){
        session_start();
    }
    if (!isset($_SESSION['cpf'])) {
        header('Location: index.php');
        exit();
    }
?>