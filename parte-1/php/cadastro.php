<?php
    include("base.php");
    include("conexao.php");
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
          <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" pattern="^[A-Za-z ]{1,100}$" required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx" pattern="^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$" required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" id='data' name="data" placeholder="Digite a data de nascimento" required="" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Senha</label>
            <input type="text" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" pattern="^.{6,30}$" required="" >
          </div>
      
          <div class="input-box">
            <label>Confirme a senha</label>
            <input type="text" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme sua senha" required="">
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" placeholder="Digite a altura em metros" pattern="^\d(\.\d{2})?$" required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes" placeholder="Digite o peso em Kg" pattern="^\d{1,3}(\.\d{2})?$" required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="tel" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx" pattern="^\d{9}$|^\d{5}-\d{4}$" required="" >
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

            $cpf = $_POST['cpf'];
            $Nome = $_POST['nome'];
            $peso = $_POST['pes'];
            $altura = $_POST['alt'];
            $dat = $_POST['data'];
            $Senha = $_POST['Senha'];
            $confirmasenha = $_POST['confirmaSenha'];
            $telefone = $_POST['telefone'];

            if(verifica_cpf($cpf) == true){
                echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
            }
            else if($Senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
            

        }





      ?>

      <input type="submit" id="Enviar" class="cadbot" name="Cadastrar" value="Cadastrar" onclick="confirm()">
  
    </form>
</section>

</div>
</body> 
</html>