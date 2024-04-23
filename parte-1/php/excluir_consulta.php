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
    <title>Dados do médico</title>
</head>

<body class="">
    <?php
    $id = $_GET['id'];

    $pesquisa = "SELECT * FROM agendamento WHERE id = $id";
    $resultado = $conn->query($pesquisa);
    $row = $resultado->fetch_assoc();
    ?>
    
   <section class="caixa">
        <h2>Deseja excluir essa consulta?</h2><br>
        <form class="form" id="form" name="form"  method="post">

        <div class="div_semcoluna">
                <label>CRM: <?php echo $row['medico_crm']; ?> </label>
        </div>
    
        <div class="div_comcoluna">
            <label>CPF do Paciente: <?php echo $row['paciente_cpf']; ?></label>
        </div>

        <div class="div_comcoluna">
            <label>Horário: <?php echo $row['horario']; ?></label>
        </div>

        <div class="div_comcoluna">
            <label>Data: <?php echo $row['data']; ?></label>
        </div>
      
      <br>

      <?php
        if(isset($_POST['Confirmar'])) {
            botao_confirmar($id);
        }
        else if(isset($_POST['Cancelar'])){
            botao_cancelar();
        }

        function botao_confirmar($id){
            global $conn;
            $sql = "DELETE FROM agendamento WHERE id = '$id'";
            $conn->query($sql);
            echo '<meta http-equiv="refresh" content="0; URL=adicionar_consulta_php.php?verifica=3">';
        }   
 
        function botao_cancelar(){
            echo "<meta http-equiv='refresh' content='0; URL=../php/agenda_recepcionista.php'>";
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