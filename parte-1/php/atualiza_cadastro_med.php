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

            if($verifica == 1){
                $CRM = $_POST['CRM'];
                $sql = "DELETE FROM usuario WHERE cpf = (SELECT medico_cpf FROM medico WHERE crm = '$CRM')";
                $conn->query($sql);
                echo '<section class="success-message">
                <h2>Cadastro foi deletado com sucesso!</h2>
                <p>O cadastro do médico foi deletado com sucesso em nosso sistema.</p>
                <a href="../php/lista_medico_php.php" class="btn">Voltar à Lista de Médicos</a>
                </section>';
            } else {
                $CPF = $_POST['cpf'];
                $Nome = $_POST['nome'];
                $dat = $_POST['data'];
                $Senha = $_POST['Senha'];
                $telefone = $_POST['telefone'];
                $datformat = date('Y-m-d',strtotime($dat));

                $sql = "UPDATE usuario SET nome = '$Nome', data_nascimento = '$datformat', senha = '$Senha' WHERE cpf = (SELECT medico_cpf FROM medico WHERE crm = '$CRM')";
                $conn->query($sql);

                $sql1 = "UPDATE medico SET telefone = '$telefone' WHERE crm = '$CRM'";
                $conn->query($sql1);

                echo '<section class="success-message">
                <h2>Cadastro foi atualizado com sucesso!</h2>
                <p>O cadastro do médico foi atualizado com sucesso em nosso sistema.</p>
                <a href="../php/lista_medico_php.php" class="btn">Voltar para Lista de Médicos</a>
                </section>';
            }
        }
    ?>
</body>
</html>
