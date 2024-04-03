<?php
    include("base.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/agenda_recepcionista_php.css">
    <title>Lista de Médicos</title>
</head>

<body class="agenda-body"> 
    
    <section class="container">
        <?php
        $pesquisa_medico = "SELECT crm, medico_cpf FROM medico";
        $resultado_pesquisa_medico = $conn->query($pesquisa_medico);
        if ($resultado_pesquisa_medico->num_rows > 0){
            while($linha_pesquisa_medico = $resultado_pesquisa_medico->fetch_assoc()){
                $pesquisa_nome_medico = "SELECT nome 
                                         FROM usuario 
                                         WHERE cpf='$linha_pesquisa_medico[medico_cpf]'";
                $resultado_pesquisa_nome_medico = $conn->query($pesquisa_nome_medico);
                $linha_pesquisa_nome_medico = $resultado_pesquisa_nome_medico->fetch_assoc(); 
                echo"<section class='result-box'>
                    <a href='../php/lista_medico_php.php.php?crm=$linha_pesquisa_medico[crm]'>$linha_pesquisa_nome_medico[nome]</a>
                </section>";
            }
        }
        else {
            echo "<section class='container'>
                    <section class='message-box'>
                        Ainda não há médicos cadastrados
                    </section>
                </section>";
        }
        ?>
    </section>

    
</body>
</html>
