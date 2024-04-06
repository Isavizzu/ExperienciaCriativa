<?php
    include("base.php");
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
        <h2>Deseja excluir o cadastro desse paciente?</h2><br>
        <form class="form" id="form" name="form"  method="post">

        <div class="div_semcoluna">
          <label>Nome completo: <?php echo $nome; ?></label>
        </div> 
      
      <div class="column">
      
          <div class="div_comcoluna">
            <label>CPF: <?php echo $CPF; ?></label>
          </div>
          <div class="div_comcoluna">
            <label>Data de Nascimento: <?php echo $data; ?></label>
          </div>
        </div>

      <div class="column">
      
          <div class="div_comcoluna">
            <label>Senha: <?php echo $senha; ?></label>
          </div>
          <div class="div_comcoluna">
            <label>Telefone: <?php echo $tel; ?>"</label>
          </div>
      
      </div>

      <div class="column">
      
          <div class="div_comcoluna">
            <label>Altura: <?php echo $alt; ?></label>
          </div>
      
          <div class="div_comcoluna">
            <label>Peso: <?php echo $pes; ?></label>
          </div>
      
      </div>

      
      <br>

      <?php
        if(isset($_POST['Confirmar'])) {
            botao_confirmar($CPF);
        }
        else if(isset($_POST['Cancelar'])){
            botao_cancelar();
        }

        function botao_confirmar($CPF){
            global $conn;
            $sql = "DELETE FROM usuario WHERE cpf = '$CPF'";
            $conn->query($sql);
            echo '<meta http-equiv="refresh" content="0; URL=cadastro_paciente_php.php?val=3">';
        }   

        function botao_cancelar(){
            echo "<meta http-equiv='refresh' content='0; URL=lista_paciente.php?'>";
        }
      ?>
      
      <div class="column">
      
          <div class="input-box">
            <input type="submit" id="Confirmar" name="Confirmar" class="cadbot" value="Confirma exclusão" >
          </div>
      
          <div class="input-box">
            <input type="submit" id="Cancelar" name="Cancelar" class="cadbot" value="Cancelar" >
          </div>
      
      </div>

    </form>
</section>    
</body>

</html>