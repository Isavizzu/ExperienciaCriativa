<?php
    include("base.php");
    include("session_start.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/agenda_recepcionista_php.css">
    <title>Agenda</title>
</head>

<body>
    <section class="caixa_titulo">
        <h1 class="titulo">
        Agenda do(a) Médico(a): 
        </h1>
        <h1>
            <?php 
                $nome_medico = $_GET['nome'];
                echo $nome_medico;
            ?>
        </h1>
    </section>
    
    <div class="tabela-container">
        <table class="horarios">
            <thead>
                <tr>
                    <?php
                    $data_atual = date("Y-m-d");
                    $dia_atual = date('w', strtotime($data_atual));
                    if ($dia_atual == 0){
                        $nomes_dias = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
                    }
                    else if ($dia_atual == 1){
                        $nomes_dias = array('Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado','Domingo');
                    }
                    else if ($dia_atual == 2){
                        $nomes_dias = array('Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado','Domingo','Segunda-feira');
                    }
                    else if ($dia_atual == 3){
                        $nomes_dias = array('Quarta-feira','Quinta-feira','Sexta-feira','Sábado','Domingo','Segunda-feira','Terça-feira');
                    }
                    else if ($dia_atual == 4){
                        $nomes_dias = array('Quinta-feira','Sexta-feira','Sábado','Domingo','Segunda-feira','Terça-feira','Quarta-feira');
                    }
                    else if ($dia_atual == 6){
                        $nomes_dias = array('Sexta-feira','Sábado','Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira',);
                    }
                    else{
                        $nomes_dias = array('Sábado','Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira');
                    }

                    $data_atual = date('d/m/y');
                    $data_atual2 = date('d/m/y', strtotime($data_atual . ' +1 day'));
                    $data_atual3 = date('d/m/y', strtotime($data_atual2 . ' +1 day'));
                    $data_atual4 = date('d/m/y', strtotime($data_atual3 . ' +1 day'));
                    $data_atual5 = date('d/m/y', strtotime($data_atual4 . ' +1 day'));
                    $data_atual6 = date('d/m/y', strtotime($data_atual5 . ' +1 day'));
                    $data_atual7 = date('d/m/y', strtotime($data_atual6 . ' +1 day'));
                    echo"<th></th>
                    <th>$nomes_dias[0]  $data_atual</th>
                    <th>$nomes_dias[1]  $data_atual2</th>
                    <th>$nomes_dias[2]  $data_atual3</th>
                    <th>$nomes_dias[3]  $data_atual4</th>
                    <th>$nomes_dias[4]  $data_atual5</th>
                    <th>$nomes_dias[5]  $data_atual6</th>
                    <th>$nomes_dias[6]  $data_atual7</th>"
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php

                    function gerarHorarios($inicio, $fim) {
                        $horarios = array();
                        $intervalo = new DateInterval('PT30M'); // Produz intervalos de 30 minutos

                        $inicio = new DateTime($inicio);
                        $fim = new DateTime($fim);

                        while ($inicio < $fim) {
                            $horarios[] = $inicio->format('H:i');
                            $inicio->add($intervalo);
                        }

                        return $horarios;
                    }

                    $crm = $_GET["crm"];
                    $horarios_manha = array();
                    $horarios_tarde = array();
                    
                    //Aqui se refere a parte da manhã
                    $horario_inicio_manha = "SELECT trabalha, trabalha_manha, horario_inicio_manha 
                                    FROM agenda 
                                    WHERE medico_crm = '$crm' AND horario_inicio_manha IS NOT NULL 
                                    ORDER BY horario_inicio_manha ASC";
                    $resul_horario_inicio_manha = $conn->query($horario_inicio_manha);

                    if ($resul_horario_inicio_manha->num_rows > 0){

                        $linha_horario_inicio_manha = $resul_horario_inicio_manha->fetch_assoc();
                        $horario_inicio_manha = $linha_horario_inicio_manha['horario_inicio_manha'];
                        
                        $horario_fim_manha = "SELECT trabalha, trabalha_manha, horario_fim_manha 
                                    FROM agenda 
                                    WHERE medico_crm = '$crm' AND horario_fim_manha IS NOT NULL 
                                    ORDER BY horario_fim_manha DESC";
                        $resul_horario_fim_manha = $conn->query($horario_fim_manha);
                        $linha_horario_fim_manha = $resul_horario_fim_manha->fetch_assoc();
                        
                        $horario_fim_manha = $linha_horario_fim_manha['horario_fim_manha'];
                        $horarios_manha = gerarHorarios($horario_inicio_manha,$horario_fim_manha);

                        foreach ($horarios_manha as $horario) {
                            $data_atual = date("Y-m-d"); // Aqui reinicia a data para o dia atual
                            echo "<tr>";
                            echo "<td>$horario</td>"; // Aqui são os horários
                            for ($i = 0; $i <= 6; $i++) { // Aqui são as consultas para os 7 dias da semana de acordo com cada horário
                                $consulta_manha = "SELECT paciente_cpf  
                                                    FROM agendamento
                                                    WHERE data='$data_atual' AND horario='$horario' AND medico_crm='$crm'";
                                $resultado_consulta_manha = $conn->query($consulta_manha);
                                if ($resultado_consulta_manha->num_rows > 0){ //Aqui mostrará os nomes dos pacientes se houver consulta
                                    $linha_consulta_manha = $resultado_consulta_manha->fetch_assoc();
                                    $cpf_paciente = $linha_consulta_manha['paciente_cpf'];

                                    $consulta_paciente_manha = "SELECT nome 
                                                                FROM usuario 
                                                                WHERE cpf='$cpf_paciente'";
                                    $resultado_consulta_paciente_manha = $conn->query($consulta_paciente_manha);
                                    $linha_consulta_paciente_manha = $resultado_consulta_paciente_manha->fetch_assoc();
                                    $nome_paciente = $linha_consulta_paciente_manha['nome'];

                                    echo "<td>$nome_paciente</td>";
                                }
                                else { // Aqui mostarará uma caixa vazia se não houver consulta
                                    echo "<td></td>";
                                }
                                $data_atual = date('Y-m-d', strtotime($data_atual . ' +1 day')); // Aqui aumenta 1 dia
                            }
                            echo "</tr>";
                        }
                    }

                    // Aqui se refere a parte da tarde

                    $horario_inicio_tarde = "SELECT trabalha, trabalha_tarde, horario_inicio_tarde 
                                    FROM agenda 
                                    WHERE medico_crm = '$crm' AND horario_inicio_tarde IS NOT NULL 
                                    ORDER BY horario_inicio_tarde ASC";
                    $resul_horario_inicio_tarde = $conn->query($horario_inicio_tarde);

                    if ($resul_horario_inicio_tarde->num_rows > 0){

                        $linha_horario_inicio_tarde = $resul_horario_inicio_tarde->fetch_assoc();
                        $horario_inicio_tarde = $linha_horario_inicio_tarde['horario_inicio_tarde'];
                        
                        $horario_fim_tarde = "SELECT trabalha, trabalha_tarde, horario_fim_tarde 
                                    FROM agenda 
                                    WHERE medico_crm = '$crm' AND horario_fim_tarde IS NOT NULL 
                                    ORDER BY horario_fim_tarde DESC";
                        $resul_horario_fim_tarde = $conn->query($horario_fim_tarde);
                        $linha_horario_fim_tarde = $resul_horario_fim_tarde->fetch_assoc();
                        
                        $horario_fim_tarde = $linha_horario_fim_tarde['horario_fim_tarde'];
                        $horarios_tarde = gerarHorarios($horario_inicio_tarde,$horario_fim_tarde);

                        foreach ($horarios_tarde as $horario) {
                            $data_atual = date("Y-m-d"); // Aqui reinicia a data para o dia atual
                            echo "<tr>";
                            echo "<td>$horario</td>"; // Aqui são os horários
                            for ($i = 0; $i <= 6; $i++) { // Aqui são as consultas para os 7 dias da semana de acordo com cada horário
                                $consulta_tarde = "SELECT paciente_cpf  
                                                    FROM agendamento
                                                    WHERE data='$data_atual' AND horario='$horario' AND medico_crm='$crm'";
                                $resultado_consulta_tarde = $conn->query($consulta_tarde);
                                if ($resultado_consulta_tarde->num_rows > 0){ //Aqui mostrará os nomes dos pacientes se houver consulta
                                    $linha_consulta_tarde = $resultado_consulta_tarde->fetch_assoc();
                                    $cpf_paciente = $linha_consulta_tarde['paciente_cpf'];

                                    $consulta_paciente_tarde = "SELECT nome 
                                                                FROM usuario 
                                                                WHERE cpf='$cpf_paciente'";
                                    $resultado_consulta_paciente_tarde = $conn->query($consulta_paciente_tarde);
                                    $linha_consulta_paciente_tarde = $resultado_consulta_paciente_tarde->fetch_assoc();
                                    $nome_paciente = $linha_consulta_paciente_tarde['nome'];

                                    echo "<td>$nome_paciente</td>";
                                }
                                else { // Aqui mostarará uma caixa vazia se não houver consulta
                                    echo "<td></td>";
                                }
                                $data_atual = date('Y-m-d', strtotime($data_atual . ' +1 day')); // Aqui aumenta 1 dia
                            }
                            echo "</tr>";
                        }
                    }
                    else if ($resul_horario_inicio_tarde->num_rows == 0 && $resul_horario_inicio_manha->num_rows == 0){
                        echo "<section class='no-agenda-section'>
                            <div class='message-container'>
                                <p class='message'>O doutor ainda não tem agenda.</p>
                            </div>
                        </section>";
                    }
                    
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if ($resul_horario_inicio_tarde->num_rows > 0 || $resul_horario_inicio_manha->num_rows > 0){
            echo "<form action='adicionar_consulta.php' method='POST'>
                        <input type='submit' name='adicionar' class='botao_adicionar' value='Agendar Consulta'>
                        <input type='hidden' name='crm' value='$crm'>
                        <input type='hidden' name='nome' value='$nome_medico'>
                  </form>";
        }
    ?>
    
</body>
</html>