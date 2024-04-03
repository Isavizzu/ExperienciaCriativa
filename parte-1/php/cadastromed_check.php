<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $crm = $_POST['crm'];
    $especialidade_id = $_POST['especialidade'];
    $senha = $_POST['senha'];
    $senha_conf = $_POST['senha_conf'];


    if (empty($nome) || empty($cpf) || empty($crm) || empty($especialidade_id) || empty($senha) || empty($senha_conf)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

    if (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $cpf)) {
        echo "CPF inválido. Por favor, digite no formato xxx.xxx.xxx-xx.";
        exit();
    }

   
    if (!preg_match("/^\d{7}$/", $crm)) {
        echo "CRM inválido. Por favor, digite um CRM válido.";
        exit();
    }

   
    $verifica_cpf = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
    $resultado_verifica_cpf = $conn->query($verifica_cpf);

    if ($resultado_verifica_cpf->num_rows > 0) {
        echo "CPF já cadastrado.";
        exit();
    }


    $verifica_crm = "SELECT crm FROM medico WHERE crm = '$crm'";
    $resultado_verifica_crm = $conn->query($verifica_crm);

    if ($resultado_verifica_crm->num_rows > 0) {
        echo "CRM já cadastrado.";
        exit();
    }

   
    $verifica_especialidade = "SELECT id FROM especialidade WHERE id = '$especialidade_id'";
    $resultado_verifica_especialidade = $conn->query($verifica_especialidade);

    if ($resultado_verifica_especialidade->num_rows == 0) {
        echo "Especialidade selecionada não existe no sistema.";
        exit();
    }

   
    $sql = "INSERT INTO medico (crm, medico_cpf, especialidade_id) VALUES ('$crm', '$cpf', '$especialidade_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Cadastro de médico realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar médico: " . $conn->error;
    }
}
?>
