<?php
    session_destroy();
    unset($_SESSION['cpf']);
    
    header("Location: index.php");
    exit();

?>