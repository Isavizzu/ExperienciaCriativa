@ -1,121 +0,0 @@
<?php
include("base.php");
include("conexao.php");

function verifica_crm($crm){
    global $conn;
    $sql = "SELECT crm FROM medico WHERE crm = '$crm'";
    $resultado = $conn->query($sql);
    $row = $resultado->fetch_assoc();
    return ($row != null);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Médico</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <script>
        function showPassword() {
            var senhaInput = document.getElementById("senha");
            if (senhaInput.type === "password") {
                senhaInput.type = "text";
            } else {
                senhaInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <br>
    <h1>Formulário de Cadastro de Médico</h1>
    <br>
    <section class="caixa">

        <form class="form" id="form" name="form" action="criar_cadastro_med.php" method="post">

            <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" required="">
            </div>
            <div class="input-box">
                <label>CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx" required="">
            </div>
            <div class="input-box">
                <label>Data de Nascimento</label>
                <input type="date" id='data' name="data" placeholder="Digite a data de nascimento">
            </div>
            <div class="input-box">
                <label>CRM</label>
                <input type="text" id="crm" name="crm" placeholder="Digite o CRM" required="">
            </div>
            <div class="input-box">
                <label>Especialidade</label>
                <select id="especialidade" name="especialidade" required="">
                    <option value="">Selecione a especialidade</option>
                    <option value="1">Cardiologia</option>
                    <option value="2">Dermatologia</option>
                    <option value="3">Pediatria</option>
                    <option value="4">Neurologia</option>
                    <option value="5">Ortopedia</option>
                    <option value="6">Endocrinologia</option>
                </select>
            </div>
            <div class="input-box">
                <label>Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite uma senha com 6 a 30 caracteres" required="">
                <span onclick="showPassword()"></span>
            </div>
            <div class="input-box">
                <label>Confirme a senha</label>
                <input type="password" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme sua senha" required="">
            </div>
        </form>
    </section>

    <?php

        if(isset($_POST['Cadastrar'])) {
            botao_cadastrar();
        }

        function verifica_cpf($cpf){
            global $conn;
            $pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
            $resultado_pesquisa = $conn->query($pesquisa_cpf);
            $row = $resultado_pesquisa->fetch_assoc();
            if ($row == null){
                return false;
            }
            else{
                return true; 
            } 
        } 

        function botao_cadastrar(){

            $cpf = $_POST['cpf'];
            $Nome = $_POST['nome'];
            $dat = $_POST['data'];
            $crm = $_POST['crm'];
            $especialidade = $_POST['especialidade'];
            $Senha = $_POST['Senha'];
            $confirmasenha = $_POST['confirmaSenha'];

            if(verifica_cpf($cpf) == true){
                echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
            }
            else if($Senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
        }
        ?>

        <input type="submit" id="Enviar" class="cadbot" name="Cadastrar" value="Cadastrar" onclick="confirm()">

</body>
</html>