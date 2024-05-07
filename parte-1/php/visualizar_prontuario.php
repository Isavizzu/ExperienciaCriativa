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
            $pesq_agend = "SELECT id FROM agendamento WHERE data = '$data' AND paciente_cpf = '$cpf_paci'";
            $result_agend = $conn->query($pesq_agend);
            if($result_agend->num_rows > 0){
                while($row_agend = $result_agend->fetch_assoc()){
                    $query = "SELECT * FROM registro WHERE id_agendamento = '$row_agend[id]'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        // Exibir os prontuários
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='input-box'>";
                            $data_form = date("d/m/y", strtotime($data));
                            $titulo = "Consulta do dia " . $data_form;
                            criarCaixa($titulo, $row['descricao']);
                            $pesquisa = "SELECT * FROM prescricao WHERE id_registro = '$row[id]'";
                            $resultado = $conn->query($pesquisa);
                            if ($resultado->num_rows > 0) {
                                while($linha = $resultado->fetch_assoc()){
                                    criarCaixa($linha['medicamento'], $linha['orientacao']);
                                }
                            }
                            else{
                                echo "<div class='erro'>Não foram vinculados prescrições à essa consulta</div>";
                            }
                            echo "</div>";
                        } 
                    }
                    else {
                        echo "<div class='erro'>Ainda não há nenhum registro em seu prontuário para esta data.</div>";
                    }
                }
            }

            
        }
        else{
            $cpf_paci = $_SESSION['cpf'];
            // Consulta SQL para buscar os registros do paciente para a data selecionada
            $pesq_agend = "SELECT id, data, medico_crm FROM agendamento WHERE data = '$data' AND paciente_cpf = '$cpf_paci' AND medico_crm = '$crm' ";
            $result_agend = $conn->query($pesq_agend);
            if($result_agend->num_rows > 0){
                while($row_agend = $result_agend->fetch_assoc()){
                    $query = "SELECT * FROM registro WHERE id_agendamento = '$row_agend[id]'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        // Exibir os prontuários
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='input-box'>";
                            $data_form = date("d/m/y", strtotime($row_agend['data']));
                            $titulo = "Consulta do dia " . $data_form;
                            criarCaixa($titulo, $row['descricao', $row_agend['medico_crm']]);
                            $pesquisa = "SELECT * FROM prescricao WHERE id_registro = '$row[id]'";
                            $resultado = $conn->query($pesquisa);
                            if ($resultado->num_rows > 0) {
                                while($linha = $resultado->fetch_assoc()){
                                    criarCaixa($linha['medicamento'], $linha['orientacao']);
                                }
                            }
                        }
                    }
                    else{
                        echo "<div class='erro'>Não foram vinculados prescrições à essa consulta</div>";
                    }
                    echo "</div>";
                } 
            }
            else {
                echo "<div class='erro'>Ainda não há nenhum registro em seu prontuário.</div>";
            }
        }
    ?>
    <?php
    function criarCaixa($titulo, $texto) {
        echo '<div class="caixa">';
        echo '<div class="titulo">' . $titulo . ' <span class="toggle">+</span></div>';
        echo '<div class="conteudo" style="display: none;">' . $texto . '</div>';
        echo '</div>';
    }
    function criarCaixa2($titulo, $texto, $crm) {
        echo '<div class="caixa">';
        echo '<div class="titulo">' . $titulo . ' <span class="toggle">+</span></div>';
        echo '<div class="conteudo" style="display: none;">' . $texto . '</div>';
        echo '<div class="titulo">' . $crm . ' <span class="toggle">+</span></div>';
        echo '</div>';
    }
    ?> 
</div>

</body>
</html>