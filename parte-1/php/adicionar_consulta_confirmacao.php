<?php
    include("base_paciente.php");
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

    $verifica = $_GET['verifica'];

    if($verifica == 1){
        echo '<section class="success-message">
            <h2>Agendamento realizado com sucesso!</h2>
            <p>A consulta foi marcada com sucesso em nosso sistema.</p>
            <a href="../php/inicio_paciente.php" class="btn">Voltar ao inicio</a>
            </section>';
    }
    else if($verifica == 2){
        echo '<section class="success-message">
            <h2>Agendamento atualizado com sucesso!</h2>
            <p>A consulta foi atualizada com sucesso em nosso sistema.</p>
            <a href="../php/inicio_paciente.php" class="btn">Voltar ao inicio</a>
            </section>';
    }
    else{
        echo '<section class="success-message">
            <h2>Agendamento deletado com sucesso!</h2>
            <p>A consulta foi deletada com sucesso em nosso sistema.</p>
            <a href="../php/inicio_paciente.php" class="btn">Voltar ao inicio</a>
            </section>';
    }

    ?>
    
    
</body>
</html>