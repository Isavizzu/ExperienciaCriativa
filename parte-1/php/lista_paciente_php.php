<?php
    include("base.php");
    include("session_start.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Dados do paciente</title>
</head>

<body class="">
    <?php
    $CPF= $_GET['cpf'];
    $pesquisa_cpf = "SELECT cpf, nome, data_nascimento, senha FROM usuario WHERE cpf = '$CPF'";
    $resultado_pesquisa = $conn->query($pesquisa_cpf);
    $row = $resultado_pesquisa->fetch_assoc();
    $nome = $row['nome'];
    $data= $row['data_nascimento'];
    $senha = $row['senha'];

    $pesquisa_paciente_cpf = "SELECT telefone, paciente_cpf, altura, peso FROM paciente WHERE paciente_cpf = '$CPF'";
    $resultado_pesquisa_paciente = $conn->query($pesquisa_paciente_cpf);
    $row = $resultado_pesquisa_paciente->fetch_assoc();
    $alt= $row['altura'];
    $pes= $row['peso'];
    $tel= $row['telefone'];

    ?>
    
   <section class="caixa">
        <h1>Dados do paciente</h2><br>
        <form class="form" id="form" name="form"  method="post">

      <div class="input-box">
          <label>Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $nome; ?>"  pattern="^[A-Za-zÀ-úçÇ ]{1,100}$"  required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $CPF; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" id="data" name="data" placeholder="dd/mm/aaaa" value="<?php echo $data; ?>" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Senha</label>
            <input type="password" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" value="<?php echo $senha; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Confirme a senha</label>
            <input type="password" id="confirmaSenha" name="confirmaSenha"  placeholder="Confirme sua senha" value="<?php echo $senha; ?>" required="">
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" placeholder="Digite a altura em metros"  value="<?php echo $alt; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes"  placeholder="Digite o peso em Kg" value="<?php echo $pes; ?>" required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="telefone" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx" value="<?php echo $tel; ?>" required="" >
      </div>
      <br>

      <?php
        if(isset($_POST['Atualizar'])) {
            botao_atualizar();
        }
        else if(isset($_POST['Excluir'])){
            botao_excluir($CPF);
        }

        function verifica_cpf($cpf){
          global $conn;
          $pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
          $resultado_pesquisa = $conn->query($pesquisa_cpf);
          $row = $resultado_pesquisa->fetch_assoc();
          if($row == null){
            return true;
          }
          else if ($row['cpf'] == $cpf){
              return true;
          }
          else{
              return false; 
          }
      } 

        function botao_atualizar(){

            global $conn;
            
            $CPF = $_POST['cpf'];
            $Nome = $_POST['nome'];
            $peso = $_POST['pes'];
            $altura = $_POST['alt'];
            $dat = $_POST['data'];
            $Senha = $_POST['Senha'];
            $confirmasenha = $_POST['confirmaSenha'];
            $telefone = $_POST['telefone'];
            $datformat = date('Y-m-d',strtotime($dat));

            if($Senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
            else if(verifica_cpf($cpf) == false){
              echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
            }
            else if(!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $CPF)){
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
                $sql = "UPDATE usuario SET nome = '$Nome', data_nascimento = '$datformat', senha = '$Senha' WHERE cpf = '$CPF'";
                $sql1 = "UPDATE paciente SET telefone = '$telefone', altura = '$altura', peso = '$peso' WHERE paciente_cpf = '$CPF'";
                $conn->query($sql);
                $conn->query($sql1);
                echo '<meta http-equiv="refresh" content="0; URL=cadastro_paciente_php.php?val=2">';
            }
        }

        function botao_excluir($CPF){
            echo "<meta http-equiv='refresh' content='0; URL=lista_paciente_excluir.php?cpf=$CPF'>";
        }
      ?>
      
      <div class="column">
      
          <div class="input-box">
            <input type="submit" id="Atualizar" name="Atualizar" class="cadbot" value="Atualizar" >
          </div>
      
          <div class="input-box">
            <input type="submit" id="Excluir" name="Excluir" class="cadbot" value="Excluir" >
          </div>
      
      </div>

    </form>
</section>    
</body>

</html>