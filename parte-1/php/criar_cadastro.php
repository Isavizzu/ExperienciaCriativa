<?php
include("conexao.php");
include("cadastro.php");

$CPF = $_POST['cpf'];
$Nome = $_POST['nome'];
$peso = $_POST['pes'];
$altura = $_POST['alt'];
$dat = $_POST['data'];
$Senha = $_POST['Senha'];
$telefone = $_POST['telefone'];
$mensagem = "Paciente cadastrado com Sucesso!";

$datformat = date('Y-m-d',strtotime($dat));

$pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$CPF'";
$resultado_pesquisa = $conn->query($pesquisa_cpf);
$row = $resultado_pesquisa->fetch_assoc();

if($row == null){
    $sqlInsert = "INSERT INTO usuario(cpf, nome, data_nascimento, senha) VALUES ('$CPF', '$Nome', '$datformat', '$Senha')";
    $sqlInsert1 = "INSERT INTO paciente(telefone, paciente_cpf, altura, peso) VALUES ('$telefone', '$CPF', '$altura', '$peso')";
    $conn->query($sqlInsert);
    $conn->query($sqlInsert1);
    echo '<meta http-equiv="refresh" content="0; URL=cadastro_paciente_sucesso.php">';
}
else{
    echo "<script>alert('Esse CPF já foi cadastrado anteriormente!');</script>";
}
?>