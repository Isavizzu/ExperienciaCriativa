<?php
    include("base.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Dados do médico</title>
</head>

<body class="">
    <?php
    $CPF= $_GET["cpf"];
    $pesquisa_cpf = "SELECT cpf, nome, data_nascimento, senha FROM usuario WHERE cpf = '$CPF'";
    $resultado_pesquisa = $conn->query($pesquisa_cpf);
    $row = $resultado_pesquisa->fetch_assoc();
    $CRM = $_GET["crm"];
    $nome = $row['nome'];
    $data_nascimento = $row['data_nascimento'];
    $senha = $row['senha'];

    $pesquisa_medico_cpf =  "SELECT crm, medico_cpf, especialidade_id FROM medico WHERE medico_cpf = '$CPF'";
    $resultado_pesquisa_medico = $conn->query($pesquisa_medico_cpf);
    $row = $resultado_pesquisa_medico->fetch_assoc();
    $especialidade_id = $row['especialidade_id'];
    
    ?>

  <section class="caixa">
        <h1>Dados do médico</h1><br>
        <form class="form" id="form" name="form" method="post">

          
            <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $nome; ?>"  pattern="^[A-Za-zÀ-úçÇ ]{1,100}$"  required="">
            </div>
            
            <div class="column">

                <div class="input-box">
                    <label>CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $CPF; ?>" required="">
                </div>
            
                <div class="input-box">
                    <label>Data de Nascimento</label>
                    <input type="date" id="data" name="data" placeholder="dd/mm/aaaa" value="<?php echo $data_nascimento; ?>" required="">
                </div>
            </div>

            <div class="column">

                <div class="input-box">
                    <label>Senha</label>
                    <input type="text" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" value="<?php echo $senha; ?>" required="">
                </div>

                <div class="input-box">
                <label>Confirme a senha</label>
                <input type="text" id="confirmaSenha" name="confirmaSenha"  placeholder="Confirme sua senha" value="<?php echo $senha; ?>" required="">
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
            </div>
    <?php
        if(isset($_POST['Atualizar'])) {
            botao_atualizar($conn);
        }
        else if(isset($_POST['Excluir'])){
            botao_excluir();
        }


        function botao_atualizar($conn){
            $CPF = $_POST['cpf'];
            $Nome = $_POST['nome'];
            $dat = $_POST['data'];
            $CRM = $_POST['crm'];
            $Senha = $_POST['Senha'];
            $especialidade = $_POST['especialidade'];
            $confirmasenha = $_POST['confirmaSenha'];
            $datformat = date('Y-m-d',strtotime($dat));
        
            if ($Senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
            else if (!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $CPF)){
                echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
            }
            else if (!preg_match('/^.{6,30}$/', $Senha)){
                echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 6 caracteres!</p></section>";
            }
            else if (empty($dat)){
                echo "<section class='section_invalido'><p>Preencha a data de nascimento!</p></section>";
            }
            else if (!preg_match('/^[a-zA-Z\s]+$/', $Nome)){
                echo "<section class='section_invalido'><p>Digite o nome completo!</p></section>";
            }
            else{
                if (!preg_match('/^\d{7}$/', $CRM)){
                    echo "<section class='section_invalido'><p>Digite um CRM válido (7 dígitos)!</p></section>";
                }
                else{
                    $sql = "UPDATE usuario SET nome = '$Nome', data_nascimento = '$datformat', senha = '$Senha' WHERE cpf = '$CPF'";
                    $sql1 = "UPDATE medico SET crm = '$CRM', especialidade = '$especialidade' WHERE medico_cpf = '$CPF'";
                    $conn->query($sql);
                    $conn->query($sql1);
                    echo '<meta http-equiv="refresh" content="0; URL=cadastro_medico_php.php?val=2">';
                }
            }
        }
        
        function botao_excluir(){
            echo '<meta http-equiv="refresh" content="0; URL=cadastro_medico_php.php?val=2">';
        }
        ?>

<div class="column">
      
      <div class="input-box">
        
        <input type="submit" id="Atualizar" nome="Atualizar" class="cadbot" value="Atualizar" >
      </div>
  
      <div class="input-box">

        
        <input type="submit" id="Excluir" nome="Excluir" class="cadbot" value="Excluir" >
      </div>

      </div>

</form>
</section>    
</body>


</html>
        