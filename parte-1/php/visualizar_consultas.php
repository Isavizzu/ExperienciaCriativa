<?php
    include("base_paciente.php");
    include("session_start.php");
    include("conexao.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/consulta_paciente.css">
    <title>Consultas</title>
</head>
<body>
    <section class="agenda_titulo">
        <p>Consultas agendadas</p>
    </section>
  
    <?php
        $paciente = $_SESSION['cpf'];
        $verifica_consulta = "SELECT horario, data, medico_crm FROM agendamento WHERE paciente_cpf='$paciente'";
        $resultado_pesquisa = $conn->query($verifica_consulta);
        
        if ($resultado_pesquisa->num_rows > 0) {
            while ($linha_pesquisa = $resultado_pesquisa->fetch_assoc()) {
                echo "<section class='result-box'> 
                          <a href='../php/editar_consulta.php?horario={$linha_pesquisa['horario']}'>Data: $linha_pesquisa[data] | Horario: $linha_pesquisa[horario]</a>
                      </section>";
            }
        } else {
            echo "<section class='result-box'>
                      Ainda não há consultas agendadas
                  </section>";
        }

    
?>


</body>
</html>