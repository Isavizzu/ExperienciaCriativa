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

        $pesquisa_paciente_cpf = "SELECT telefone, paciente_cpf, altura, peso, sexo FROM paciente WHERE paciente_cpf = '$CPF'";
        $resultado_pesquisa_paciente = $conn->query($pesquisa_paciente_cpf);
        $row = $resultado_pesquisa_paciente->fetch_assoc();
        $alt= $row['altura'];
        $pes= $row['peso'];
        $tel= $row['telefone'];
        $sexo= $row['sexo'];

        if($_SESSION['pagina_visitada'] == false ){
            $_SESSION['nome_paciente_atualiza'] = $nome;
            $_SESSION['cpf_paciente_atualiza'] = $CPF;
            $_SESSION['senha_paciente_atualiza'] = $senha;
            $_SESSION['conf_senha_paciente_atualiza'] = $senha;
            $_SESSION['altura_paciente_atualiza'] = $alt;
            $_SESSION['peso_paciente_atualiza'] = $pes;
            $_SESSION['telefone_paciente_atualiza'] = $tel;
            $_SESSION['data_paciente_atualiza'] = $data;
            $_SESSION['sexo_paciente_atualiza'] = $sexo;
            $_SESSION['pagina_visitada'] = true;
        }
        if(isset($_POST['Atualizar'])){
            mudar_variaveis();
        }
    ?>
    
   <section class="caixa">
        <h1>Dados do paciente</h2><br>
        <form class="form" id="form" name="form"  method="post">

      <div class="input-box">
          <label>Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $_SESSION['nome_paciente_atualiza']; ?>"  pattern="^[A-Za-zÀ-úçÇ ]{3,100}$"  required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $_SESSION['cpf_paciente_atualiza']; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" id="data" name="data" placeholder="dd/mm/aaaa" value="<?php echo $_SESSION['data_paciente_atualiza']; ?>" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" placeholder="Digite a altura em metros"  value="<?php echo $_SESSION['altura_paciente_atualiza']; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes"  placeholder="Digite o peso em Kg" value="<?php echo $_SESSION['peso_paciente_atualiza']; ?>" required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="telefone" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx" value="<?php echo $_SESSION['telefone_paciente_atualiza']; ?>" required="" >
      </div>

      <div class="input-box">

            <label>Gênero</label>

            <div class="column">

            <div class="select-box">
                <select id="sexo" name="sexo"  required="">
                    <option value="<?php echo $_SESSION['sexo_paciente_atualiza']; ?>"><?php echo $_SESSION['sexo_paciente_atualiza']; ?></option>
                    <option value="Feminino">Feminino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Outros">Outros</option>
                </select>
              </div>
            </div>
      </div>

    <div class="input-box">
    <label>Senha <a href="alterar_senha.php?cpf=<?php echo $CPF; ?>">(Alterar senha)</a></label>
    <input type="text" id="Senha" name="Senha" value="********" readonly>
    </div>
    <br>

      <br>

      <?php
        if(isset($_POST['Atualizar'])) {
            botao_atualizar($CPF);
        }
        else if(isset($_POST['Excluir'])){
            botao_excluir($CPF);
        }

        function verifica_cpf($Cpf, $CPF){

          global $conn;
          $pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$Cpf'";
          $resultado_pesquisa = $conn->query($pesquisa_cpf);
          $row = $resultado_pesquisa->fetch_assoc();
          if($row == null){
            return true;
          }
          else if ($row['cpf'] == $CPF){
              return true;
          }
          else{
              return false; 
          }
      } 


      function mudar_variaveis(){
          $_SESSION['nome_paciente_atualiza'] = $_POST['nome'];
          $_SESSION['cpf_paciente_atualiza'] = $_POST['cpf'];
          $_SESSION['senha_paciente_atualiza'] = $_POST['Senha'];
          $_SESSION['conf_senha_paciente_atualiza'] =  $_POST['confirmaSenha'];
          $_SESSION['altura_paciente_atualiza'] = $_POST['alt'];
          $_SESSION['peso_paciente_atualiza'] = $_POST['pes'];
          $_SESSION['telefone_paciente_atualiza'] = $_POST['telefone'];
          $_SESSION['data_paciente_atualiza'] = $_POST['data'];
          $_SESSION['sexo_paciente_atualiza'] = $_POST['sexo'];
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
        function botao_atualizar($CPF){

            global $conn; 
            
            $Cpf = $_POST['cpf'];
            $Nome = $_POST['nome'];
            $peso = $_POST['pes'];
            $altura = $_POST['alt'];
            $dat = $_POST['data'];
            $Senha = $_POST['Senha'];
            $confirmasenha = $_POST['confirmaSenha'];
            $telefone = $_POST['telefone'];
            $sexo = $_POST['sexo'];

            $datformat = date('Y-m-d',strtotime($dat));

            if($Senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
            else if(verifica_cpf($Cpf, $CPF) == false){
              echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
            }
            else if (!validaCPF($_POST['cpf'])) {
              echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
            }
            else if($datformat > date('Y-m-d')){
              echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
            }
            else if(!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $Cpf)){
                echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
            }
            else if(!preg_match('/^(?=.\d)(?=.[a-z])(?=.[A-Z])(?=.[$&@#])[0-9a-zA-Z$&@#]{8,30}$/', $Senha)){
              echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 8 caracteres e incluir pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial ($, *, &, @, #).</p></section>";
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
                $sql = "UPDATE usuario SET cpf = '$Cpf', nome = '$Nome', data_nascimento = '$datformat' WHERE cpf = '$CPF'";
                $sql1 = "UPDATE paciente SET telefone = '$telefone', altura = '$altura', peso = '$peso', sexo = '$sexo' WHERE paciente_cpf = '$Cpf'";
                $conn->query($sql);
                $conn->query($sql1);
                $_SESSION['pagina_visitada'] = false;
                echo '<meta http-equiv="refresh" content="0; URL=cadastro_paciente_php.php?val=2">';
            }
        }

        function botao_excluir($CPF){
            $_SESSION['pagina_visitada'] = false;
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