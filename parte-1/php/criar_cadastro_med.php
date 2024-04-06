<?php
include("conexao.php");
include("cadastro.php");

$CPF = $_POST['cpf'];
$CRM = $_POST['crm']
$Nome = $_POST['nome'];
$dat = $_POST['data'];
$Senha = $_POST['Senha'];
$Especialidade = $_POST['especialidade_id']
$mensagem = "Médico cadastrado com Sucesso!";

$datformat = date('Y-m-d',strtotime($dat));

$pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$CPF'";
$resultado_pesquisa = $conn->query($pesquisa_cpf);
$row = $resultado_pesquisa->fetch_assoc();

if($row == null){
    $sqlInsert = "INSERT INTO usuario(cpf, nome, data_nascimento, senha) VALUES ('$CPF', '$Nome', '$datformat', '$Senha')";
    $sqlInsert1 = "INSERT INTO medico(crm, medico_cpf, especialidade_id) VALUES ('$CRM', '$Especialidade')";
    $conn->query($sqlInsert);
    $conn->query($sqlInsert1);
    echo '<meta http-equiv="refresh" content="0; URL=cadastro_med_php.php">';
}
else{
    echo "<script>alert('Esse CPF já foi cadastrado anteriormente!');</script>";
}
?>