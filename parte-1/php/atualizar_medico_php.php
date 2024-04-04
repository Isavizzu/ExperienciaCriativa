<?php
include("conexao.php");
include("base.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['atualizar'])){
        $crm = $_POST['crm'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $data_nascimento = $_POST['data'];
        $especialidade = $_POST['especialidade'];
        $senha = $_POST['senha'];
        $confirmaSenha = $_POST['confirmaSenha'];

        if (strlen($senha) < 6 || strlen($senha) > 30) {
            echo "<div class='message-box error'><span>A senha deve ter entre 6 e 30 caracteres!</span></div>";
        } elseif (!preg_match("/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}-?[0-9]{2}$/", $cpf)) {
            echo "<div class='message-box error'><span>CPF inválido! Digite no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx</span></div>";
        } else {
            $sql = "SELECT medico_cpf FROM medico WHERE crm = '$crm'";
            $resultado = $conn->query($sql);
            if ($resultado->num_rows == 1) {
                $row = $resultado->fetch_assoc();
                $medico_cpf = $row['medico_cpf'];

                $sql_update_usuario = "UPDATE usuario SET nome = '$nome', data_nascimento = '$data_nascimento', senha = '$senha' WHERE cpf = '$cpf'";
                $sql_update_medico = "UPDATE medico SET medico_cpf = '$cpf', especialidade_id = '$especialidade' WHERE crm = '$crm'";
                
                if ($conn->query($sql_update_usuario) === TRUE && $conn->query($sql_update_medico) === TRUE) {
                    echo "<div class='message-box success'><span>Dados do médico atualizados com sucesso!</span></div>";
                } else {
                    echo "<div class='message-box error'><span>Erro ao atualizar os dados do médico: " . $conn->error . "</span></div>";
                }
            } else {
                echo "<div class='message-box error'><span>CRM não encontrado!</span></div>";
            }
        }
    } elseif(isset($_POST['excluir'])){
        $crm = $_POST['crm'];
        
        $sql_delete_medico = "DELETE FROM medico WHERE crm = '$crm'";
        if ($conn->query($sql_delete_medico) === TRUE) {
            echo "<div class='message-box success'><span>Médico excluído com sucesso!</span></div>";
        } else {
            echo "<div class='message-box error'><span>Erro ao excluir o médico: " . $conn->error . "</span></div>";
        }
    }
}
?>
