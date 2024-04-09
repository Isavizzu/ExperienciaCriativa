<?php
    include("base.php");
    include("conexao.php"); 
    include("session_start.php");
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
<h1>Formulário de Cadastro de Paciente</h1>


<br>

<section class="caixa">
<form class="form" id="form" name="form" method="post">
      
      <div class="input-box">
          <label>Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" pattern="^[A-Za-zÀ-úçÇ ]{1,100}$" required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" id='data' name="data" placeholder="Digite a data de nascimento" required="" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Senha</label>
            <input type="text" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres"  required="" >
          </div>
      
          <div class="input-box">
            <label>Confirme a senha</label>
            <input type="text" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme sua senha" required="">
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" placeholder="Digite a altura em metros"  required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes" placeholder="Digite o peso em Kg"  required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="tel" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx"  required="" >
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
            else if(!preg_match('/^.{6,30}$/', $Senha)){
                echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 6 caracteres!</p></section>";
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
                $sqlInsert1 = "INSERT INTO paciente(telefone, paciente_cpf, altura, peso) VALUES ('$telefone', '$cpf', '$altura', '$peso')";
                $conn->query($sqlInsert);
                $conn->query($sqlInsert1);
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