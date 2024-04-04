<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Dados do Médico</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
    <br>
    <h1>Atualizar Dados do Médico</h1>
    <br>
    <section class="caixa">
        <form class="form" id="form" name="form" action="atualizar_medico_php.php" method="post">
            <div class="input-box">
                <label>CRM</label>
                <input type="text" id="CRM" name="CRM" placeholder="Digite o CRM" required="">
            </div>
            <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" required="">
            </div>
            <div class="input-box">
                <label>Data de Nascimento</label>
                <input type="date" id='data' name="data" placeholder="Digite a data de nascimento">
            </div>
            <div class="input-box">
                <label>Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite uma senha com 6 a 30 caracteres" required="">
            </div>
            <input type="submit" class="cadbot" value="Atualizar" name="atualizar">
            <input type="submit" class="cadbot" value="Excluir" name="excluir">
        </form>
    </section>
</body>
</html>
