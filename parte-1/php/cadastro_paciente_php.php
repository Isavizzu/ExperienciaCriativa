<?php
    include("base.php");
    include("session_start.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Mensagem de confirmação</title>
</head>
<body>

    <?php

    $VerificaBotao = $_GET['val'];

    if($VerificaBotao == 1){
        echo '<section class="success-message">
            <h2>Cadastro realizado com sucesso!</h2>
            <p>O paciente foi cadastrado com sucesso em nosso sistema.</p>
            <a href="../php/agenda_recepcionista.php" class="btn">Voltar à Agenda</a>
            </section>';
    }
    else if($VerificaBotao == 2){
        echo '<section class="success-message">
            <h2>Cadastro foi atualizado com sucesso!</h2>
            <p>O cadastro do paciente foi atualizado com sucesso em nosso sistema.</p>
            <a href="../php/lista_paciente.php" class="btn">Voltar para lista de pacientes</a>
            </section>';
    }
    else{
        echo '<section class="success-message">
            <h2>Cadastro foi deletado com sucesso!</h2>
            <p>O cadastro do paciente foi deletado com sucesso em nosso sistema.</p>
            <a href="../php/agenda_recepcionista.php" class="btn">Voltar à Agenda</a>
            </section>';
    }

    ?>
    
    
</body>
</html>