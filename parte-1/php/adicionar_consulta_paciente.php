<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adicionar_consulta.css">
    <title>Agendar de Consulta</title>
</head>
<body> 
    <?php
        include("session_start.php"); 
        include("base_paciente.php");
        $crm = $_GET['crm']; 
        $nome = $_GET['nome'];
        if($_SESSION['pagina_visitada'] == false || !isset($_SESSION['pagina_visitada'])){
            $_SESSION['cpf_paciente'] = '';
            $_SESSION['data_marcada'] = '';
            $_SESSION['hora_marcada'] = '';
            $_SESSION['pagina_visitada'] = true;
        }
        if(isset($_POST['confirmar'])){
            mudar_variaveis();
        }
    ?>

    <br>
    <section class="titulo">
        <h1>Agendamento de Consulta</h1>
    </section>
    
    <section class="caixa">
        <form class="form"  method="POST">

            <div class="input-box">
                <label>Nome do Médico</label>
                <input type="text" name="nome" value="<?php echo $nome?>" readonly>
            </div>

            <div class="input-box">
                <label>CPF do Paciente</label>
                <input type="text" name="cpf" value="<?php echo $_SESSION['cpf']?>" readonly>
            </div>
            
            <div class="input-box">
                <label>Data da Consulta</label>
                <input type="date" name="data" value="<?php echo $_SESSION['data_marcada'] ?>" placeholder="Escolha a data da consulta" required>
            </div>

            <div class="input-box">
                <label>Hora da Consulta</label>
                <input type="time" name="horario" value="<?php echo $_SESSION['hora_marcada']?>" placeholder="Digite o horário da consulta" required>
            </div>
            <input type='hidden' name='nome' value='<?php echo $nome?>'>
            <input type='hidden' name='crm' value='<?php echo $crm?>'>

            <?php
                if(isset($_POST['confirmar'])) {
                    botao_confirmar($nome, $crm);
                }

                function botao_confirmar($nome, $crm){

                    include("conexao.php");
                    
                    //pega os dados do form
                    $crm_medico = $crm;
                    $cpf = $_POST["cpf"];
                    $data = $_POST["data"];
                    $horario = $_POST["horario"];

                    //testes de inputs
                    $testeCpf = "/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/";
                    $testeData = $testeData = "/^(\d{4})-(\d{2})-(\d{2})$/";
                    $testeHorario = "/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
                    $testeMinuto = "/^(0[0-9]|1[0-9]|2[0-3]):(00|30)$/";
                    $dataAtual = date('Y-m-d');
                    $dataFormatada = date('Y-m-d', strtotime(str_replace('/', '-', $data)));
                    $horarioTimestamp = strtotime($horario);
                    $horarioAtual = time();

                    
                    //verifica se existe o cpf digitado
                    $pesquisa_cpf = "SELECT paciente_cpf FROM paciente WHERE paciente_cpf = '$cpf'";

                    $resultado_cpf = $conn->query($pesquisa_cpf);
                    $row = $resultado_cpf->fetch_assoc();

                    if (!preg_match($testeCpf, $cpf)){
                        echo "<br><section class='section_invalido'><p>Digite um CPF válido!</p></section>";
                    }
                    else if ($row == null){
                        echo "<br><section class='section_invalido'><p>Não há um paciente cadastrado com esse CPF!</p></section>";
                    }
                    else if (!preg_match($testeData, $data)){
                        echo "<br><section class='section_invalido'><p>Escolha uma data válida, formato: (DD/MM/AAAA)!</p></section>";
                    }
                    else if ($dataFormatada < $dataAtual){
                        echo "<br><section class='section_invalido'><p>Escolha uma data válida, não é possível marcar uma consulta para uma data no passado!</p></section>";
                    }
                    else if (!preg_match($testeHorario, $horario)){
                        echo "<br><section class='section_invalido'><p>Digite um horário válido, formato: (HH:MM)!</p></section>";
                    }
                    else if(!preg_match($testeMinuto, $horario)){
                        echo "<br><section class='section_invalido'><p>Digite um horário exato, de meia em meia hora (:30 ou :00)!</p></section>";
                    }
                    else if ($dataFormatada == $dataAtual && $horarioAtual > $horarioTimestamp){
                        echo "<br><section class='section_invalido'><p>Escolha uma horário válido, não é possível marcar uma consulta para um horário no passado!</p></section>";
                    }
                    else { //verifica se o(a) médico(a) trabalha no dia e na hora especificada

                        $data_formatada = date("Y-m-d", strtotime(str_replace('/', '-', $data))); //Converter a data para o formato YYYY-MM-DD
                        $dia_semana = date('w', strtotime($data_formatada));//Fala o dia da semana, 0 domingo e 6 sábado
                        $pesquisa_agenda = "SELECT trabalha, trabalha_manha, trabalha_tarde, horario_inicio_manha, horario_inicio_tarde, horario_fim_manha, horario_fim_tarde 
                                            FROM agenda WHERE medico_crm='$crm_medico' AND dia_semana=$dia_semana";
                        $resultado_agenda = $conn->query($pesquisa_agenda);
                        $row_agenda = $resultado_agenda->fetch_assoc();

                        if($row_agenda['trabalha'] && $row_agenda['trabalha'] !== null){//verifica se trabalha no dia da semana solicitada
                            
                            $horario_formatado = strtotime($horario);//formata a hora para comparação
                            $hora_de_comparacao = strtotime("12:00");

                            if($horario_formatado <= $hora_de_comparacao){//verifica se o horário solicitado é de manhã

                                if($row_agenda['trabalha_manha'] && $row_agenda['trabalha_manha'] !== null){        //verifica se trabalha de manhã
                                    $horario_inicio_manha = strtotime($row_agenda['horario_inicio_manha']);
                                    $horario_fim_manha = strtotime($row_agenda['horario_fim_manha']); 

                                    if($horario_formatado >= $horario_inicio_manha && $horario_formatado < $horario_fim_manha){//Verifica se o horário informado está dentro do horário do(a) médico(a)
                                        if(verifica_agendamento($horario,$crm_medico,$cpf,$data)){   //verifica se há consulta no dia e horario informado
                                            $agendar_consulta = "INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf) 
                                                                    VALUES ('$horario', '$data', '$crm_medico', '$cpf')";
                                            $resultado_agendar_consulta = $conn->query($agendar_consulta);
                                            $_SESSION['pagina_visitada'] = false;
                                            echo '<meta http-equiv="refresh" content="0; URL=adicionar_consulta_confirmacao.php?verifica=1">';
                                        }
                                        else{
                                             $_SESSION['pagina_visitada'] = false;
                                            echo "<br><section class='section_invalido'><p>O(A) médico(a) " . $nome . " ou o paciente já tem um horário nesse dia.</p></section>";
                                        }
                                    }
                                    else{       //O horário informado não está dentro do horário do(a) médico(a)
                                        echo "<br><section class='section_invalido'><p>O horário de manhã do(a) médico(a) " . $nome . " é das " . $row_agenda['horario_inicio_manha'] 
                                                . " às " . $row_agenda['horario_fim_manha'] . ".</p></section>";
                                    }
                                }
                                else{     //não de trabalha de manhã
                                    echo "<br><section class='section_invalido'><p>O(A) médico(a) " . $nome . " não trabalha de manhã e madrugada.</p></section>";
                                }
                            }
                            else{       //verifica se o horário solicitado é de tarde
                                if($row_agenda['trabalha_tarde'] && $row_agenda['trabalha_tarde'] !== null){       //verifica se trabalha de tarde
                                    $horario_inicio_tarde = strtotime($row_agenda['horario_inicio_tarde']);
                                    $horario_fim_tarde = strtotime($row_agenda['horario_fim_tarde']);

                                    if($horario_formatado >= $horario_inicio_tarde && $horario_formatado < $horario_fim_tarde){//Verifica se o horário informado está dentro do horário do(a) médico(a)
                                        if(verifica_agendamento($horario,$crm_medico,$cpf,$data)){   //verifica se há consulta no dia e horario informado
                                            $agendar_consulta = "INSERT INTO agendamento (horario, data, medico_crm, paciente_cpf) 
                                                                    VALUES ('$horario', '$data', '$crm_medico', '$cpf')";
                                            $resultado_agendar_consulta = $conn->query($agendar_consulta);
                                            echo '<meta http-equiv="refresh" content="0; URL=adicionar_consulta_confirmacao.php?verifica=1">';                                         
                                        }
                                        else{
                                            echo "<br><section class='section_invalido'><p>O(A) médico(a) " . $nome . " ou o paciente já tem um horário nesse dia.</p></section>";
                                        }
                                    }
                                    else{      //O horário informado não está dentro do horário do(a) médico(a)
                                        echo "<br><section class='section_invalido'><p>O horário de tarde do(a) médico(a) " . $nome . " é das " . $row_agenda['horario_inicio_tarde'] 
                                                . " às " . $row_agenda['horario_fim_tarde'] . ".</p></section>";
                                    }
                                }
                                else {    //não de trabalha de tarde
                                    echo "<br><section class='section_invalido'><p>O(A) médico(a) " . $nome . " não trabalha de tarde e noite.</p></section>";
                                }
                            }
                        }
                        else{    //Não trabalha no dia da semana solicitada
                            echo "<br><section class='section_invalido'><p>O(A) médico(a) " . $nome . " não trabalha esse dia da semana.</p></section>";
                        }
                    }
                }

                function verifica_agendamento($horario,$crm_medico,$cpf,$data){
                    include("conexao.php");
                    $pesquisa_agendamento = "SELECT * FROM agendamento WHERE horario='$horario' AND data='$data' AND medico_crm='$crm_medico'";
                    $resultado_agendamento = $conn->query($pesquisa_agendamento);
                    $pesquisa_agendamento_paciente = "SELECT * FROM agendamento WHERE horario='$horario' AND data='$data' AND paciente_cpf='$cpf'";
                    $resultado_agendamento_paciente = $conn->query($pesquisa_agendamento_paciente);
                    
                    if($resultado_agendamento->num_rows > 0 || $resultado_agendamento_paciente->num_rows > 0){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
            ?>

            <input type="submit" name="confirmar" class="cadbot" value="Confirmar">
        </form>
    </section>

    <section class='agenda'>
        <?php
            echo "<h2>Horário do(a) $nome: </h2>";
            $i = 0;
            while ($i < 7) {
                verifica_agenda($i, $crm);
                $i++;
            }
        ?>
    </section>
    <?php

        function mudar_variaveis(){
            $_SESSION['cpf_paciente'] = $_POST['cpf'];
            $_SESSION['data_marcada'] = $_POST['data'];
            $_SESSION['hora_marcada'] = $_POST['horario'];
        }

        function verifica_agenda($dia, $crm){
            include("conexao.php");
            $pesquisa_agenda = "SELECT * FROM agenda WHERE dia_semana = '$dia' AND medico_crm = '$crm'";
            $resultado_agenda = $conn->query($pesquisa_agenda);
            $mensagem = '';
            if ($dia == 0){ $mensagem = "Domingo: ";}
            else if ($dia == 1){ $mensagem = "Segunda: ";}
            else if ($dia == 1){ $mensagem = "Terça: ";}
            else if ($dia == 3){ $mensagem = "Quarta: ";}
            else if ($dia == 4){ $mensagem = "Quinta: ";}
            else if ($dia == 5){ $mensagem = "Sexta: ";}
            else {$mensagem = "Sábado: ";}
            if ($resultado_agenda->num_rows > 0){
                $row = $resultado_agenda->fetch_assoc();
                if ($row['trabalha']){
                    if ($row['trabalha_manha']){
                        $mensagem .= " das " . $row['horario_inicio_manha'] . " às " . $row['horario_fim_manha'];
                    }
                    if ($row['trabalha_tarde']){
                        $mensagem .= " - das " . $row['horario_inicio_tarde'] . " às " . $row['horario_fim_tarde']. ".";
                    }
                }
                echo "<section class='agenda_dia'>$mensagem</section>";
                return;
            }
            else {
                $mensagem .= "não trabalha neste dia.";
            }
            echo "<section class='agenda_dia'>$mensagem</section>";
        }
    ?>


    
</body>
</html>