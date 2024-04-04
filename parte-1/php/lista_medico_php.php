<?php
    include("base.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/lista_paciente.css">
    <title>Dados do médico</title>
</head>

<body class="">
    <?php
    $CRM = $_GET["crm"];
    $pesquisa_medico = "SELECT crm, medico_cpf, especialidade_id FROM medico WHERE crm = '$CRM'";
    $resultado_pesquisa_medico = $conn->query($pesquisa_medico);
    $row = $resultado_pesquisa_medico->fetch_assoc();
    $medico_cpf = $row['medico_cpf'];
    $especialidade_id = $row['especialidade_id'];

    $pesquisa_nome_medico = "SELECT nome, data_nascimento, senha 
                             FROM usuario 
                             WHERE cpf = '$medico_cpf'";
    $resultado_pesquisa_nome_medico = $conn->query($pesquisa_nome_medico);
    $row_medico = $resultado_pesquisa_nome_medico->fetch_assoc();
    $nome = $row_medico['nome'];
    $data_nascimento = $row_medico['data_nascimento'];
    $senha = $row_medico['senha'];

    $pesquisa_especialidade = "SELECT nome_especialidade 
                               FROM especialidade 
                               WHERE id = '$especialidade_id'";
    $resultado_pesquisa_especialidade = $conn->query($pesquisa_especialidade);
    $row_especialidade = $resultado_pesquisa_especialidade->fetch_assoc();
    $nome_especialidade = $row_especialidade['nome_especialidade'];
    ?>

    <section class="caixa">
        <h1>Dados do médico</h1><br>
        <form class="form" id="form" name="form" action="atualiza_cadastro_med.php" method="post">

            <input type="hidden" id="CRM" name="CRM" value="<?php echo $CRM; ?>">
            <input type="hidden" id="verifica" name="verifica" value="0">
          
            <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $nome; ?>" required="">
            </div>
            
            <div class="column">
                <div class="input-box">
                    <label>CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $medico_cpf; ?>" required="">
                </div>
            
                <div class="input-box">
                    <label>Data de Nascimento</label>
                    <input type="date" id="data" name="data" placeholder="dd/mm/aaaa" value="<?php echo $data_nascimento; ?>" required="">
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Senha</label>
                    <input type="text" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" value="<?php echo $senha; ?>" required="">
                </div>
            
                <div class="input-box">
                    <label>Especialidade</label>
                    <input type="text" id="especialidade" name="especialidade" value="<?php echo $nome_especialidade; ?>" required="" readonly>
                </div>
            </div>

            <div class="input-box">
                <label>Confirme a senha</label>
                <input type="text" id="confirmaSenha" name="confirmaSenha"  placeholder="Confirme sua senha" value="<?php echo $senha; ?>" required="">
            </div>

            <div class="column">
                <div class="input-box">
                    <input type="button" id="atualizar" class="cadbot" value="Atualizar" onclick="confirn()">
                </div>
            
                <div class="input-box">
                    <input type="button" id="deletar" class="cadbot" value="Excluir" onclick="confirmarExclusao()">
                </div>
            </div>

            <!-- Caixas de aviso em PHP -->
            <?php if(isset($_GET['error'])): ?>
                <div class="error-box">
                    <?php echo $_GET['error']; ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="success-box">
                    <?php echo $_GET['success']; ?>
                </div>
            <?php endif; ?>

        </form>
    </section>    

    <script>

        function confirmarExclusao() {
            if (confirm("Tem certeza que deseja excluir este médico?")) {
                var CRM = document.getElementById('crm').value;
                var verifica = 1;
                window.location.href = "excluir_medico.php?verifica=" +verifica + "&CRM=" +CRM;
            } 
        }

        function confirn(){
            var senha = document.getElementById('Senha').value;
            var confirmaSenha = document.getElementById('confirmaSenha').value;
            var CPFRegex = /^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/i;
            var CRM = document.getElementById('cpf').value;
            const testa_senha = /^.{6,30}$/;
            const letra = /^[A-Za-z ]{1,100}$/;
            
            if (!(testa_senha.test(senha))) {
                window.location.href = "lista_recepcionista_php.php?error=Sua senha tem que ter de 6 a 30 caracteres.";
                return;
            } else if (senha != confirmaSenha){
                window.location.href = "lista_recepcionista_php.php?error=As senhas não correspondem.";
                return;
            } else if (!(letra.test(nome))){
                window.location.href = "lista_recepcionista_php.php?error=Digite o nome completo.";
                return;
            } else if (CPFRegex.test(CRM) == false){
                window.location.href = "lista_recepcionista_php.php?error=Digite um CPF Válido.";
                return;
            } else{
                form.submit();
            }
        }
    </script>
</body>
</html>
