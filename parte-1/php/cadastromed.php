<?php
   include("conexao.php");
   include("base.php");
   include ("cadastromed_check.php")

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Cadastro de Médico</title>
</head>
<body>
    <br>
    <section class="caixa">
        <form class="form" id="form" name="form" action="cadastrar_medico.php" method="post">
            <div class="input-box">
                <label>Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" required="">
            </div>
            <div class="input-box">
                <label>Data de Nascimento</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required="">
            </div>
            <div class="input-box">
                <label>CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxx.xxx.xxx-xx" required="">
            </div>
            <div class="input-box">
                <label>CRM</label>
                <input type="text" id="crm" name="crm" placeholder="Digite o CRM" required="">
            </div>
            <div class="input-box">
                <label>Especialidade</label>
                <select name="especialidade" id="especialidade" required="">
                    <option value="">Selecione a especialidade</option>
                    <option value="1">Cardiologia</option>
                    <option value="2">Dermatologia</option>
                    <option value="3">Pediatria</option>
                    <option value="4">Neurologia</option>
                    <option value="5">Ortopedia</option>
                    <option value="6">Endocrinologia</option>
                </select>
            </div>
            <div class="input-box">
                <label>Senha</label>
                <input type="text" id="senha" name="senha" placeholder="Digite sua senha" required="">
            </div>
            <div class="input-box">
            <label>Confirme a senha</label>
            <input type="text" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme sua senha" required="">
           </div>
      
            <br>
            <input type="submit" id="Enviar" class="cadbot" value="Cadastrar">
        </form>
    </section>
</body>
</html>
