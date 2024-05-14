<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Login - Clínica Médica</title>
</head>

<body>

    <?php 
        include("conexao.php");

        if(isset($_POST['botao_login'])) {
            $SESSION['cpf_login'] = $_POST["cpf"];
        }
    ?>
    <!-- É o formulário de entrado do cpf e senha -->
    <div class="login-container">
        <h1>Clinical Here</h1>
        <form method="post">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Seu CPF" value="<?php echo $SESSION['cpf_login']?>">

            <label for="id">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Sua senha">
            <span onclick="showPassword()"></span>

    <!-- É a função em php para validar o login -->
    <?php
        if(isset($_POST['botao_login'])) {
            botao_login();
        }

        function botao_login(){

            include("conexao.php"); 

            $senha = $_POST['senha'];
            $senha_hash = md5($senha);
            $cpf = $_POST["cpf"];

            $pesquisa_login = "SELECT cpf, nome FROM usuario WHERE senha = '$senha' AND cpf = '$cpf'";

            $resultado_pesquisa = $conn->query($pesquisa_login);
            $row = $resultado_pesquisa->fetch_assoc();

            if ($row !== null){
                $pesquisa_tipo_recepcionista = "SELECT recepcionista_cpf FROM recepcionista WHERE recepcionista_cpf= '$cpf'";
                $resultado_tipo_recepcionista = $conn->query($pesquisa_tipo_recepcionista);
                $row_recepcionista = $resultado_tipo_recepcionista->fetch_assoc();
                
                $pesquisa_tipo_medico = "SELECT medico_cpf FROM medico WHERE medico_cpf= '$cpf'";
                $resultado_tipo_medico = $conn->query($pesquisa_tipo_medico);
                $row_medico = $resultado_tipo_medico->fetch_assoc();

                session_start();
                $_SESSION['cpf'] = $cpf;
                $_SESSION['nome'] = $row['nome'];

               
                if ($row_recepcionista !== null){
                    header('location: agenda_recepcionista.php');
                    $_SESSION['tipo_usuario'] = 'Recepcionista';
                }
                else if ($row_medico !== null){
                    header('location: medico.php');
                    $_SESSION['tipo_usuario'] = 'Médico(a)';
                }
                else {
                    header('location: inicio_paciente.php');
                    $_SESSION['tipo_usuario'] = 'Paciente';
                }

            }
            else {
                echo "<section class='section_invalido'><p>Senha ou/e CPF inválidos!</p></section>";
            }
        }
    ?>
            <input type="submit" value="Entrar" name="botao_login">
        </form>
        <p>Não tem uma conta? <a href="#">Crie aqui!</a></p>
    </div>
 
</body>
</html>
