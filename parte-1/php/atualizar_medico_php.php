<?php
include("conexao.php");
include("base.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['atualizar'])){
        $crm = $_POST['CRM'];
        $nome = $_POST['nome'];
        $data_nascimento = $_POST['data'];
        $senha = $_POST['senha'];

        $sql_medico = "SELECT medico_cpf, especialidade_id FROM medico WHERE crm = '$crm'";
        $resultado_medico = $conn->query($sql_medico);

        if ($resultado_medico->num_rows == 1) {
            $row_medico = $resultado_medico->fetch_assoc();
            $medico_cpf = $row_medico['medico_cpf'];
            $especialidade_id = $row_medico['especialidade_id'];

            $sql_update_usuario = "UPDATE usuario SET nome = '$nome', data_nascimento = '$data_nascimento', senha = '$senha' WHERE cpf = '$medico_cpf'";
            if ($conn->query($sql_update_usuario) === TRUE) {
                echo "<div class='message-box success'><span>Dados do médico atualizados com sucesso!</span></div>";
            } else {
                echo "<div class='message-box error'><span>Erro ao atualizar os dados do médico: " . $conn->error . "</span></div>";
            }
        } else {
            echo "<div class='message-box error'><span>CRM não encontrado!</span></div>";
        }
    } elseif(isset($_POST['excluir'])){

        $crm = $_POST['CRM'];

        $sql_delete_medico = "DELETE FROM medico WHERE crm = '$crm'";
        if ($conn->query($sql_delete_medico) === TRUE) {
            echo "<div class='message-box success'><span>Médico excluído com sucesso!</span></div>";
        } else {
            echo "<div class='message-box error'><span>Erro ao excluir o médico: " . $conn->error . "</span></div>";
        }
    }
}
?>
