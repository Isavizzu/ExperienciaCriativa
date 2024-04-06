<?php
    include("conexao.php");
    include("base.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Dados do Médico</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
   <?php
        
        if(isset($_GET['verifica'])){
            $verifica = $_GET['verifica'];
        }
        if(isset($_POST['verifica'])){
            $verifica = $_POST['verifica'];
        }

        if(isset($_GET['Cpf'])){
            $Cpf = $_GET['Cpf'];
        }
        if(isset($_POST['Cpf'])){
            $Cpf = $_POST['Cpf'];
        }

        
        
        
        
        if($verifica == 1){
            $sql = "DELETE FROM usuario WHERE cpf = '$Cpf'";
            $conn->query($sql);
            echo '<section class="success-message">
            <h2>Cadastro foi deletado com sucesso!</h2>
            <p>O cadastro do médico foi deletado com sucesso em nosso sistema.</p>
            <a href="../php/agenda_recepcionista.php" class="btn">Voltar à Agenda</a>
            </section>';
        }
        else{
            $CPF = $_POST['cpf'];
            $CRM = $_POST['crm'];
            $Nome = $_POST['nome'];
            $dat = $_POST['data'];
            $Senha = $_POST['Senha'];
            $Especialidade = $_POST['especialidade_id'];
            $datformat = date('Y-m-d',strtotime($dat));
            $sql = "UPDATE usuario SET nome = '$Nome', data_nascimento = '$datformat', senha = '$Senha' WHERE cpf = '$CPF'";
            $sql1 = "UPDATE medico SET crm = '$CRM', especialidade_id = '$Especialidade' WHERE medico_cpf = '$CPF'";
            $conn->query($sql);
            $conn->query($sql1);
            echo '<section class="success-message">
            <h2>Cadastro foi atualizado com sucesso!</h2>
            <p>O cadastro do médico foi atualizado com sucesso em nosso sistema.</p>
            <a href="../php/lista_medico.php" class="btn">Voltar para lista de médicos</a>
            </section>';
         
        }

    ?>
</body>
</html>