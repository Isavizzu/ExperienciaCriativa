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
            $pesq_agend = "SELECT agendamento.id, agendamento.data, agendamento.horario, medico.medico_cpf, medico.medico_cpf as nome_medico, registro.descricao, prescricao.medicamento, prescricao.orientacao
                           FROM agendamento
                           INNER JOIN medico ON agendamento.medico_crm = medico.crm
                           INNER JOIN registro ON agendamento.id = registro.id_agendamento
                           LEFT JOIN prescricao ON registro.id = prescricao.id_registro
                           WHERE agendamento.data = '$data' AND agendamento.paciente_cpf = '$cpf_paci'";
            $result_agend = $conn->query($pesq_agend);
            if($result_agend->num_rows > 0){
                while($row_agend = $result_agend->fetch_assoc()){
                    echo "<div class='input-box'>";
                    $data_form = date("d/m/y", strtotime($row_agend['data']));
                    $titulo = "Consulta do dia " . $data_form . ", Horário: " . $row_agend['horario'] . ", Médico: " . $row_agend['nome_medico'];
                    criarCaixa($titulo, $row_agend['descricao'], $row_agend['medicamento'], $row_agend['orientacao']);
                    echo "</div>";
                }
            }
            else {
                echo "<div class='erro'>Ainda não há nenhum registro em seu prontuário para esta data.</div>";
            }
        }
        else{
            $cpf_paci = $_SESSION['cpf'];
            // Consulta SQL para buscar os registros do paciente para a data selecionada
            $pesq_agend = "SELECT agendamento.id, agendamento.data, agendamento.horario, medico.medico_cpf, medico.medico_cpf as nome_medico, registro.descricao, prescricao.medicamento, prescricao.orientacao
                           FROM agendamento
                           INNER JOIN medico ON agendamento.medico_crm = medico.crm
                           INNER JOIN registro ON agendamento.id = registro.id_agendamento
                           LEFT JOIN prescricao ON registro.id = prescricao.id_registro
                           WHERE agendamento.paciente_cpf = '$cpf_paci'";
            $result_agend = $conn->query($pesq_agend);
            if($result_agend->num_rows > 0){
                while($row_agend = $result_agend->fetch_assoc()){
                    echo "<div class='input-box'>";
                    $data_form = date("d/m/y", strtotime($row_agend['data']));
                    $titulo = "Consulta do dia " . $data_form . ", Horário: " . $row_agend['horario'] . ", Médico: " . $row_agend['nome_medico'];
                    criarCaixa($titulo, $row_agend['descricao'], $row_agend['medicamento'], $row_agend['orientacao']);
                    echo "</div>";
                }
            }
            else {
                echo "<div class='erro'>Ainda não há nenhum registro em seu prontuário.</div>";
            }
        }
    ?>
    <?php
    function criarCaixa($titulo, $descricao, $medicamento, $orientacao) {
        echo '<div class="caixa">';
        echo '<div class="titulo">' . $titulo . ' <span class="toggle">+</span></div>';
        echo '<div class="conteudo" style="display: none;">';
        echo '<p><strong>Descrição:</strong> ' . $descricao . '</p>';
        echo '<p><strong>Medicamento:</strong> ' . $medicamento . '</p>';
        echo '<p><strong>Orientação:</strong> ' . $orientacao . '</p>';
        echo '</div>';
        echo '</div>';
    }
    ?> 
</div>

</body>
</html>