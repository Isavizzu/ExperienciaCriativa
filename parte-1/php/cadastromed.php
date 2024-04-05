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
    <link rel="stylesheet" href="../css/cadastro_teste.css">
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

        <form class="form" id="form" name="form" action="criar_cadastro.php" method="post">

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
            <input type="submit" id="Enviar" class="cadbot" value="Cadastrar">
        </form>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $data = $_POST['data'];
        $crm = $_POST['crm'];
        $especialidade = $_POST['especialidade'];
        $senha = $_POST['senha'];
        $confirmaSenha = $_POST['confirmaSenha'];

        if (strlen($senha) < 6 || strlen($senha) > 30 || $senha !== $confirmaSenha) {
            echo "<div class='message-box error'><span>A senha deve ter entre 6 e 30 caracteres e as senhas devem ser iguais!</span></div>";
        } elseif (!preg_match("/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}-?[0-9]{2}$/", $cpf)) {
            echo "<div class='message-box error'><span>CPF inválido! Digite no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx</span></div>";
        } elseif (!preg_match("/^[0-9]{7}$/", $crm)) {
            echo "<div class='message-box error'><span>CRM inválido! Digite exatamente 7 dígitos.</span></div>";
        } elseif (verifica_crm($crm)) {
            echo "<div class='message-box error'><span>CRM já cadastrado!</span></div>";
        } else {
            echo "<div class='message-box success'><span>Médico cadastrado com sucesso!</span></div>";
        }
    }
    ?>

</body>
</html>
