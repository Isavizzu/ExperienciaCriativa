<?php
include("conexao.php");


$CPF = $_POST['cpf'];
$Nome = $_POST['nome'];
$peso = $_POST['pes'];
$altura = $_POST['alt'];
$dat = $_POST['data'];
$Senha = $_POST['Senha'];
$telefone = $_POST['telefone'];


$datformat = date('Y-m-d',strtotime($dat));

$sql = "UPDATE usuario SET nome = '$Nome', data_nascimento = '$datformat', senha = '$Senha' WHERE cpf = '$CPF'";
$sql1 = "UPDATE paciente SET telefone = '$telefone', altura = '$altura', peso = '$peso' WHERE paciente_cpf = '$CPF'";

$conn->query($sql);
$conn->query($sql1);
echo '<meta http-equiv="refresh" content="0; URL=atualizar_paciente.php">';

?>