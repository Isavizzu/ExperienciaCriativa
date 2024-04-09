<?php
    include("base.php");
    include("conexao.php"); 
    include("session_start.php");

    if($_SESSION['pagina_visitada'] == false || !isset($_SESSION['pagina_visitada'])){
        $_SESSION['nome_paciente'] = '';
        $_SESSION['cpf_paciente'] = '';
        $_SESSION['senha_paciente'] = '';
        $_SESSION['conf_senha_paciente'] = '';
        $_SESSION['altura_paciente'] = '';
        $_SESSION['peso_paciente'] = '';
        $_SESSION['telefone_paciente'] = '';
        $_SESSION['data_paciente'] = '';
        $_SESSION['pagina_visitada'] = true;
    }
    if(isset($_POST['Cadastrar'])){
        botao_cadastrar();
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
<h1>Formulário de Cadastro de Paciente</h1>


<br>

<section class="caixa">
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
            <input type="password" id="Senha" name="Senha" value="<?php echo $_SESSION['senha_paciente']?>" placeholder="Digite uma senha com 6 a 30 caracteres"  required="" >
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
            <input type="number" id="pes" name="pes" value="<?php echo $_SESSION['peso_paciente']?>" placeholder="Digite o peso em Kg"  required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="tel" value="<?php echo $_SESSION['telefone_paciente']?>" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx"  required="" >
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
            
            $_SESSION['nome_paciente'] = $Nome;
            $_SESSION['cpf_paciente'] = $cpf;
            $_SESSION['senha_paciente'] = $Senha;
            $_SESSION['conf_senha_paciente'] = $confirmasenha;
            $_SESSION['altura_paciente'] = $altura;
            $_SESSION['peso_paciente'] = $peso;
            $_SESSION['telefone_paciente'] = $telefone;
            $_SESSION['data_paciente'] =$dat;

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
                $sqlInsert1 = "INSERT INTO paciente(telefone, paciente_cpf, altura, peso) VALUES ('$telefone', '$cpf', '$altura', '$peso')";
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