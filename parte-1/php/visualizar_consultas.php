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
        $verifica_consulta = "SELECT id, horario, data, medico_crm FROM agendamento WHERE paciente_cpf='$paciente'";
        $resultado_pesquisa = $conn->query($verifica_consulta);

        $dataDeHoje = date("Y-m-d");

        
        if ($resultado_pesquisa->num_rows > 0) {
            while ($linha_pesquisa = $resultado_pesquisa->fetch_assoc()) {
                if($linha_pesquisa['data'] > $dataDeHoje ){
                    $crm = $linha_pesquisa['medico_crm'];
                    $data = $linha_pesquisa['data'];
                    $data_formatada = date('d/m/Y', strtotime($data));
                    $pesquisa_medico = "SELECT medico.medico_cpf, usuario.nome, especialidade.nome_especialidade 
                                        FROM medico 
                                        JOIN usuario ON usuario.cpf = medico.medico_cpf 
                                        JOIN especialidade ON especialidade.id = medico.especialidade_id
                                        WHERE medico.crm = '$crm'";
                    $pesquisa = $conn->query($pesquisa_medico);
                    $row = $pesquisa->fetch_assoc();

                    echo "<section class='result-box'> 
                            <a href='../php/editar_consulta.php?nome=$row[nome]&crm=$crm&id=$linha_pesquisa[id]'>Data: $data_formatada | Horario: $linha_pesquisa[horario] | Médico: $row[nome] | Especialidade: $row[nome_especialidade]</a>
                        </section>";
                 }
                
        }
        } 
        else {
            echo "<section class='result-box'>
                      Ainda não há consultas agendadas
                  </section>";
        }

        

    
?>


</body>
</html>