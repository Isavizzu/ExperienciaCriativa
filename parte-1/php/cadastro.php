<?php
    include("session_start.php");
    include("base.php");
    include("conexao.php");

    if($_SESSION['pagina_visitada'] == false || !isset($_SESSION['pagina_visitada'])){
        $_SESSION['nome_paciente'] = '';
        $_SESSION['cpf_paciente'] = '';
        $_SESSION['senha_paciente'] = '';
        $_SESSION['conf_senha_paciente'] = '';
        $_SESSION['altura_paciente'] = '';
        $_SESSION['peso_paciente'] = '';
        $_SESSION['telefone_paciente'] = '';
        $_SESSION['data_paciente'] = '';
        $_SESSION['sexo_paciente'] = 'Selecione o gênero';
        $_SESSION['valor_sexo_paciente'] = '';
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
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
<br>
<section class="caixa">
<h1>Formulário de Cadastro de Paciente</h1><br>
<form class="form" id="form" name="form" method="post">
      
      <div class="input-box">
          <label>Nome completo</label>
          <input type="text" id="nome" name="nome" value="<?php echo $_SESSION['nome_paciente']?>" placeholder="Digite o nome completo" pattern="^[A-Za-zÀ-úçÇ ]{3,100}$" required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo $_SESSION['cpf_paciente']?>" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" id='data' name="data" value="<?php echo $_SESSION['data_paciente']?>" placeholder="Digite a data de nascimento" required="" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Senha</label>
            <input type="password" id="Senha" name="Senha" value="<?php echo $_SESSION['senha_paciente']?>" placeholder="Digite uma senha com 8 a 30 caracteres contendo um número, um caracter especial, uma leta maiúscula e uma letra minúscula"  required="" >
            <span onclick="showPassword()"></span>
          </div>
      
          <div class="input-box">
            <label>Confirme a senha</label>
            <input type="password" id="confirmaSenha" name="confirmaSenha" value="<?php echo $_SESSION['conf_senha_paciente']?>" placeholder="Confirme sua senha" required="">
            <span onclick="showPassword()"></span>
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" value="<?php echo $_SESSION['altura_paciente']?>" placeholder="Digite a altura em metros"  required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes" value="<?php echo $_SESSION['peso_paciente']?>" placeholder="Digite o peso em Kg"  required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="tel" value="<?php echo $_SESSION['telefone_paciente']?>" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx"  required="" >
      </div>

      <div class="input-box">

            <label>Gênero</label>

            <div class="column">

            <div class="select-box">
                <select id="sexo" name="sexo"  required="">
                    <option value="<?php echo $_SESSION['valor_sexo_paciente']; ?>"><?php echo $_SESSION['sexo_paciente']?></option>
                    <option value="Feminino">Feminino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>
            </div>
            </div> 

      <br> 
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

        function mudar_variaveis(){
            $_SESSION['nome_paciente'] = $_POST['nome'];
            $_SESSION['cpf_paciente'] = $_POST['cpf'];
            $_SESSION['senha_paciente'] = $_POST['Senha'];
            $_SESSION['conf_senha_paciente'] = $_POST['confirmaSenha'];
            $_SESSION['altura_paciente'] = $_POST['alt'];
            $_SESSION['peso_paciente'] = $_POST['pes'];
            $_SESSION['telefone_paciente'] = $_POST['telefone'];
            $_SESSION['data_paciente'] = $_POST['data'];
            $_SESSION['sexo_paciente'] =  $_POST['sexo'];
            $_SESSION['valor_sexo_paciente'] = $_POST['sexo'];
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
            $peso = $_POST['pes'];
            $altura = $_POST['alt'];
            $dat = $_POST['data'];
            $Senha = $_POST['Senha'];
            $confirmasenha = $_POST['confirmaSenha'];
            $telefone = $_POST['telefone'];
            $sexo = $_POST['sexo'];
            
            $datformat = date('Y-m-d',strtotime($dat));

            if(verifica_cpf($cpf) == true){
                echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
            }
            else if($Senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
            else if(!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $cpf)){
                echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
            }
            else if (!validaCPF($_POST['cpf'])) {
                echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
            }
            else if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,30}$/', $Senha)){
                echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 8 caracteres e incluir pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial ($, *, &, @, #).</p></section>";
            }
            else if($datformat > date('Y-m-d')){
                echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
            }
            else if(!preg_match('/^\d(\.\d{2})?$/', $altura)){
                echo "<section class='section_invalido'><p>Digite a altura em metros!</p></section>";
            }
            else if(!preg_match('/^\d{1,3}(\.\d{2})?$/', $peso)){
                echo "<section class='section_invalido'><p>Digite o peso em KG!</p></section>";
            }
            else if(!preg_match('/^\d{9}$|^\d{5}-\d{4}$/', $telefone)){
                echo "<section class='section_invalido'><p>Digite um telefone válido!</p></section>";
            }
            else{
                $sqlInsert = "INSERT INTO usuario(cpf, nome, data_nascimento, senha) VALUES ('$cpf', '$Nome', '$datformat', '$Senha')";
                $sqlInsert1 = "INSERT INTO paciente(telefone, paciente_cpf, altura, peso, sexo) VALUES ('$telefone', '$cpf', '$altura', '$peso', '$sexo')";
                $conn->query($sqlInsert);
                $conn->query($sqlInsert1);
                $_SESSION['pagina_visitada'] = false;
                echo '<meta http-equiv="refresh" content="0; URL=cadastro_paciente_php.php?val=1">';
            } 
        }

      ?>

      <input type="submit" id="Enviar" class="cadbot" name="Cadastrar" value="Cadastrar" onclick="">
  
    </form>

</section>

</div>
</body> 
</html>