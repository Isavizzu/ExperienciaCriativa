<?php
    include("conexao.php");
    include("base.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Cadastro</title>
</head>
<body>
    <?php
        if(isset($_POST['verifica'])){
            $verifica = $_POST['verifica'];
        }

        if(isset($_POST['CRM'])){
            $CRM = $_POST['CRM'];
        }

        if($verifica == 1){
            $sql = "DELETE FROM usuario WHERE cpf = '$CRM'";
            $conn->query($sql);
            echo '<section class="success-message">
            <h2>Cadastro foi deletado com sucesso!</h2>
            <p>O cadastro do médico foi deletado com sucesso em nosso sistema.</p>
            <a href="../php/agenda_recepcionista.php" class="btn">Voltar à Agenda</a>
            </section>';
        } else {
            $CPF = $_POST['cpf'];
            $Nome = $_POST['nome'];
            $data_nascimento = $_POST['data'];
            $Senha = $_POST['Senha'];
            $telefone = $_POST['telefone'];
            $especialidade_id = $_POST['especialidade'];

            $data_nascimento_format = date('Y-m-d',strtotime($data_nascimento));

            $sql_usuario = "UPDATE usuario SET nome = '$Nome', data_nascimento = '$data_nascimento_format', senha = '$Senha' WHERE cpf = '$CPF'";
            $sql_medico = "UPDATE medico SET telefone = '$telefone', especialidade_id = '$especialidade_id' WHERE medico_cpf = '$CPF'";
            
            $conn->query($sql_usuario);
            $conn->query($sql_medico);

            echo '<section class="success-message">
            <h2>Cadastro foi atualizado com sucesso!</h2>
            <p>O cadastro do médico foi atualizado com sucesso em nosso sistema.</p>
            <a href="../php/lista_medico.php" class="btn">Voltar para lista de médicos</a>
            </section>';
        }
    ?>
</body>
</html>
