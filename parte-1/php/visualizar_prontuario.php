<?php

include("session_start.php");
    include("conexao.php");
    include("base_paciente.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/visualizar_prontuario.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $(".toggle").click(function(){
            var conteudo = $(this).parent().next(".conteudo");
            if (conteudo.is(":visible")) {
                conteudo.slideUp();
                $(this).text('+');
            } else {
                conteudo.slideDown();
                $(this).text('-');
            }
        });
    });
</script>
<title>Prontuários</title>
</head>

<body>

    <section class="prontuario_titulo">
            <p>Prontuário</p>
    </section>
    
    <!-- Formulário para selecionar a data -->
    <form class="form" method="post">
        <label for="data">Selecione a data:</label>
        <input type="date" id="data" name="data" max="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Filtrar" name="filtrar">
    </form>

    <!-- PHP para exibir os prontuários -->
    <?php
        if(isset($_POST['filtrar']) && isset($_POST['data']) && !empty($_POST['data'])) {
            $data = $_POST['data'];
            $cpf_paci = $_SESSION['cpf'];
            // Consulta SQL para buscar os registros do paciente para a data selecionada
            $pesq_agend = "SELECT usuario.nome, agendamento.id, agendamento.data, agendamento.horario, medico.medico_cpf, registro.descricao, registro.id as id 
                           FROM agendamento
                           INNER JOIN medico ON agendamento.medico_crm = medico.crm
                           INNER JOIN usuario ON medico.medico_cpf = usuario.cpf
                           INNER JOIN registro ON agendamento.id = registro.id_agendamento
                           WHERE agendamento.data = '$data' AND agendamento.paciente_cpf = '$cpf_paci'";
            $result_agend = $conn->query($pesq_agend);
            if($result_agend->num_rows > 0){
                while($row_agend = $result_agend->fetch_assoc()){
        
                    $data_form = date("d/m/y", strtotime($row_agend['data']));
                    $titulo = "Consulta do dia " . $data_form . ", Horário: " . $row_agend['horario'] . ", Médico: " . $row_agend['nome'];
                    criarCaixa($titulo, $row_agend['descricao']);
                    $pesq_presc = "SELECT * FROM prescricao WHERE id_registro = '$row_agend[id]'";
                    $result_presc = $conn->query($pesq_presc);
                    if($result_presc->num_rows > 0){
                        while($row_presc = $result_presc->fetch_assoc()){
                            criarCaixa($row_presc['medicamento'], $row_presc['orientacao']);
                            echo "</div>";
                            echo '</div>';
                        }
                    }
                    else{
                        echo "<div class='erro'>Não há nenhuma prescrição relacionada a esse registro.</div>";
                    }
                    echo "</div>";
                    echo '</div>';
                }
            }        
            else {
                echo "<div class='erro'>Ainda não há nenhum registro em seu prontuário para esta data.</div>";
            }
        
        }
        else{
            $cpf_paci = $_SESSION['cpf'];
            // Consulta SQL para buscar os registros do paciente para todas as datas
            $pesq_agend = "SELECT usuario.nome, agendamento.id, agendamento.data, agendamento.horario, medico.medico_cpf, registro.descricao, registro.id as id
                           FROM agendamento
                           INNER JOIN medico ON agendamento.medico_crm = medico.crm
                           INNER JOIN usuario ON medico.medico_cpf = usuario.cpf
                           INNER JOIN registro ON agendamento.id = registro.id_agendamento
                           WHERE agendamento.paciente_cpf = '$cpf_paci'";
            $result_agend = $conn->query($pesq_agend);
            if($result_agend->num_rows > 0){
                while($row_agend = $result_agend->fetch_assoc()){
                    
                    $data_form = date("d/m/y", strtotime($row_agend['data']));
                    $titulo = "Consulta do dia " . $data_form . ", Horário: " . $row_agend['horario'] . ", Médico: " . $row_agend['nome'];
                    criarCaixa($titulo, $row_agend['descricao']);
                    $pesq_presc = "SELECT * FROM prescricao WHERE id_registro = '$row_agend[id]'";
                    $result_presc = $conn->query($pesq_presc);
                    if($result_presc->num_rows > 0){
                        while($row_presc = $result_presc->fetch_assoc()){
                            criarCaixa($row_presc['medicamento'], $row_presc['orientacao']);
                            echo "</div>";
                            echo '</div>';
                        }
                    }
                    else{
                        echo "<div class='erro'>Não há nenhuma prescrição relacionada a esse registro.</div>";
                    }
                    echo "</div>";
                    echo '</div>';
                }
            }
            else {
                echo "<div class='erro'>Ainda não há nenhum registro em seu prontuário.</div>";
            }
        }
    ?>
    <?php
    function criarCaixa($titulo, $descricao) {
        echo '<div class="caixa">';
        echo '<div class="titulo">' . $titulo . ' <span class="toggle">+</span></div>';
        echo '<div class="conteudo" style="display: none;">';
        echo '<p><strong>Descrição:</strong> ' . $descricao . '</p>';
        
    }
    ?> 
</div>

</body>
</html>