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
   $CPF= $_GET['cpf'];
   $pesquisa_cpf = "SELECT cpf, nome, data_nascimento, senha FROM usuario WHERE cpf = '$CPF'";
   $resultado_pesquisa = $conn->query($pesquisa_cpf);
   $row = $resultado_pesquisa->fetch_assoc();
   $nome = $row['nome'];
   $data_nascimento = $row['data_nascimento'];
   $senha = $row['senha'];

   $pesquisa_medico_cpf =  "SELECT crm, medico_cpf, especialidade_id FROM medico WHERE medico_cpf = '$CPF'";
   $resultado_pesquisa_medico = $conn->query($pesquisa_medico_cpf);
   $row = $resultado_pesquisa_medico->fetch_assoc();
   $especialidade_id = $row['especialidade_id'];
   $CRM = $row['crm'];

   $pesquisa_especialidade = "SELECT nome_especialidade FROM especialidade WHERE id = $especialidade_id";
   $resultado_especialidade = $conn->query($pesquisa_especialidade);
   $row = $resultado_especialidade->fetch_assoc();
   $especialidade_nome = $row['nome_especialidade'];

    ?>
    
   <section class="caixa">
        <h2>Deseja excluir o cadastro desse médico?</h2><br>
        <form class="form" id="form" name="form"  method="post">

        <div class="div_semcoluna">
                <label>Nome completo: <?php echo $nome; ?> </label>
            </div>
            
            <div class="column">

                <div class="div_comcoluna">
                    <label>CPF: <?php echo $CPF; ?></label>
                </div>

                <div class="div_comcoluna">
                    <label>CRM: <?php echo $CRM; ?></label>

                </div>
            </div>

            <div class="column">

                <div class="div_comcoluna">
                    <label>Senha: <?php echo $senha; ?></label>
                </div>
                <div class="div_comcoluna">
                    <label>Data de Nascimento: <?php echo $data_nascimento; ?></label>
                </div>

            </div>

            <div class="div_semcoluna">
             <label>Especialidade: <?php echo $especialidade_nome; ?></label>
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
            echo '<meta http-equiv="refresh" content="0; URL=cadastro_med_php.php?val=3">';
        }   
 
        function botao_cancelar(){
            echo "<meta http-equiv='refresh' content='0; URL=lista_medico.php?'>";
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