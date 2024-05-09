<?php
    include("base.php");
    include("conexao.php");
    include("session_start.php");

    if($_SESSION['pagina_visitada'] == false || !isset($_SESSION['pagina_visitada'])){
        $_SESSION['nome_medico'] = '';
        $_SESSION['cpf_medico'] = '';
        $_SESSION['senha_medico'] = '';
        $_SESSION['conf_senha_medico'] = '';
        $_SESSION['data_medico'] = '';
        $_SESSION['crm_medico'] = '';
        $_SESSION['especialidade_medico'] = 'Selecione a especialidade';
        $_SESSION['valor_especialidade_medico'] = '';
        $_SESSION['pagina_visitada'] = true;
    }
    if(isset($_POST['Cadastrar'])){
        mudar_variaveis();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Médico</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
<body>
    <section class="caixa">
        <h1>Formulário de Cadastro de Médico</h1>
        <br>
    
        <form class="form" id="form" name="form" method="post">
        <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" value="<?php echo $_SESSION['nome_medico']; ?>" placeholder="Digite o nome completo" pattern="^[A-Za-zÀ-úçÇ ]{3,100}$" required="">
        </div>
        <div class="input-box">
                <label>CPF</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $_SESSION['cpf_medico']; ?>" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx" required="">
        </div>
        <div class="input-box">
                <label>Data de Nascimento</label>
                <input type="date" id='data' name="data" value="<?php echo $_SESSION['data_medico']; ?>" placeholder="Digite a data de nascimento">
        </div>
        <div class="input-box">
                <label>CRM</label>
                <input type="number" id="crm" name="crm" value="<?php echo $_SESSION['crm_medico']; ?>" placeholder="Digite o CRM no formato xxxxxxx" required="">
        </div>
        
        <div class="input-box">
            <label>Especialidade</label>
            <div class="column">
            <div class="select-box">
                <select id="especialidade" name="especialidade" required="">
                    <?php 
                    echo "<option value='{$_SESSION['valor_especialidade_medico']}'>{$_SESSION['especialidade_medico']}</option>";
                    $sql = "SELECT * FROM especialidade";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo "<option value='{$row['id']}'>{$row['nome_especialidade']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            </div>
            </div>
            
            <div class="input-box">
                <label>Senha</label>
                <input type="password" id="senha" name="senha" value="<?php echo $_SESSION['senha_medico']; ?>" placeholder="Digite uma senha com 6 a 30 caracteres" required="">
                <span onclick="showPassword()"></span>
            </div>

            <div class="input-box">
                <label>Confirme a senha</label>
                <input type="password" id="confirmaSenha" name="confirmaSenha" value="<?php echo $_SESSION['conf_senha_medico']; ?>" placeholder="Confirme sua senha" required="">
            </div>
            <br>

            <?php

            if (isset($_POST['Cadastrar'])) {
                botao_cadastrar();
            }

            function verifica_cpf($cpf){
                global $conn;
                $pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
                $resultado_pesquisa = $conn->query($pesquisa_cpf);
                $row = $resultado_pesquisa->fetch_assoc();
                if ($row == null) {
                    return false;
                } else {
                    return true;
                }
            }

            function verifica_crm($crm) {
                global $conn;
                $pesquisa_crm = "SELECT crm FROM medico WHERE crm = '$crm'";
                $resultado_pesquisa_crm = $conn->query($pesquisa_crm);
                $row = $resultado_pesquisa_crm->fetch_assoc();
                if ($row == null) {
                    return false;
                } else {
                    return true;
                }
            }

            function mudar_variaveis(){

                include("conexao.php");
                $especialidade = $_POST['especialidade'];

                $sql = "SELECT * FROM especialidade";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        if ($especialidade == $row['id']){
                            $_SESSION['especialidade_medico'] = $row['nome_especialidade'];
                        }
                    }
                }

                $_SESSION['nome_medico'] = $_POST['nome'];
                $_SESSION['cpf_medico'] = $_POST['cpf'];
                $_SESSION['senha_medico'] = $_POST['senha'];
                $_SESSION['conf_senha_medico'] = $_POST['confirmaSenha'];
                $_SESSION['data_medico'] = $_POST['data'];
                $_SESSION['crm_medico'] = $_POST['crm'];
                $_SESSION['valor_especialidade_medico'] = $_POST['especialidade'];
            }

            function calcularIdade($datformat) {
                $datformat = new DateTime($datformat);
                $agora = new DateTime();
                $idade = $agora->diff($datformat);
                return $idade->y;
            }

            function validaCPF($cpf) {
                // Remove caracteres não numéricos
                $cpf = preg_replace('/[^0-9]/', '', $cpf);
            
                // Verifica se o CPF possui 11 dígitos
                if (strlen($cpf) != 11) {
                    return false;
                }
            
                // Verifica se todos os dígitos são iguais, o que torna o CPF inválido
                if (preg_match('/(\d)\1{10}/', $cpf)) {
                    return false;
                }
            
                // Calcula o primeiro dígito verificador
                $sum = 0;
                for ($i = 0; $i < 9; $i++) {
                    $sum += $cpf[$i] * (10 - $i);
                }
                $remainder = $sum % 11;
                $digit1 = ($remainder < 2) ? 0 : (11 - $remainder);
            
                // Calcula o segundo dígito verificador
                $sum = 0;
                for ($i = 0; $i < 10; $i++) {
                    $sum += $cpf[$i] * (11 - $i);
                }
                $remainder = $sum % 11;
                $digit2 = ($remainder < 2) ? 0 : (11 - $remainder);
            
                // Verifica se os dígitos verificadores estão corretos
                if ($cpf[9] != $digit1 || $cpf[10] != $digit2) {
                    return false;
                }
            
                return true;
            }

            function botao_cadastrar(){

                global $conn;

                $cpf = $_POST['cpf'];
                $Nome = $_POST['nome'];
                $dat = $_POST['data'];
                $crm = $_POST['crm'];
                $Senha = $_POST['senha'];
                $confirmasenha = $_POST['confirmaSenha'];
                $especialidade = $_POST['especialidade'];

                $datformat = date('Y-m-d', strtotime($dat));

                if (verifica_cpf($cpf) == true) {
                    echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
                }
                else if($datformat > date('Y-m-d')){
                    echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
                }
                else if(calcularIdade($datformat) < 25){
                    echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
                }
                else if (verifica_crm($crm) == true) {
                    echo "<section class='section_invalido'><p>Esse CRM já foi cadastrado anteriormente!</p></section>";
                } 
                else if (empty($crm) || !preg_match('/^\d{7}$/', $crm)) {
                    echo "<section class='section_invalido'><p>Digite um CRM válido (7 dígitos)!</p></section>";
                } 
                else if ($Senha != $confirmasenha) {
                    echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
                } 
                else if (!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $cpf)) {
                    echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
                }
                else if (!validaCPF($_POST['cpf'])) {
                    echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
                }
                else if (!preg_match('/^.{6,30}$/', $Senha)) {
                    echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 6 caracteres!</p></section>";
                } 
                else {
                    $sqlInsertUsuario = "INSERT INTO usuario(cpf, nome, data_nascimento, senha) VALUES ('$cpf', '$Nome', '$datformat', '$Senha')";
                    $sqlInsertMedico = "INSERT INTO medico(crm, medico_cpf, especialidade_id, ativo) VALUES ('$crm', '$cpf', '$especialidade', 1)";
                    $conn->query($sqlInsertUsuario);
                    $conn->query($sqlInsertMedico);
                    $_SESSION['pagina_visitada'] = false;
                    echo '<meta http-equiv="refresh" content="0; URL=cadastro_med_php.php?val=1">';
                }
        }
            ?>

            <input type="submit" id="Enviar" class="cadbot" name="Cadastrar" value="Cadastrar" onclick="">

        </form>
    </section>    

    </section>

</body>

</html>


    
</body>
</html>