<?php
    include("base.php");
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/agenda_recepcionista.css">
    <title>Lista de pacientes</title>
</head>

<body class="agenda-body"> 
    
    <section class="container">
        <?php
        $pesquisa_paciente = "SELECT paciente_cpf FROM paciente";
        $resultado_pesquisa_paciente = $conn->query($pesquisa_paciente);
        if ($resultado_pesquisa_paciente->num_rows > 0){
            while($linha_pesquisa_paciente = $resultado_pesquisa_paciente->fetch_assoc()){
                $pesquisa_nome_paciente = "SELECT nome 
                                         FROM usuario 
                                         WHERE cpf='$linha_pesquisa_paciente[paciente_cpf]'";
                $resultado_pesquisa_nome_paciente = $conn->query($pesquisa_nome_paciente);
                $linha_pesquisa_nome_paciente = $resultado_pesquisa_nome_paciente->fetch_assoc(); 
                echo"<section class='result-box'>
                    <a href='../php/lista_paciente_php.php?crm=$linha_pesquisa_paciente[paciente_cpf]'>$linha_pesquisa_nome_paciente[nome]</a>
                </section>";
            }
        }
        else {
            echo "<section class='container'>
                    <section class='message-box'>
                        Ainda não há pacientes cadastrados
                    </section>
                </section>";
        }
        ?>
    </section>

    
</body>
</html>