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
    $CPF= $_GET["crm"];
    $pesquisa_cpf = "SELECT cpf, nome, data_nascimento, senha FROM usuario WHERE cpf = '$CPF'";
    $resultado_pesquisa = $conn->query($pesquisa_cpf);
    $row = $resultado_pesquisa->fetch_assoc();
    $CRM = $_GET["crm"];
    $nome = $row['nome'];
    $data_nascimento = $row['data_nascimento'];
    $senha = $row['senha'];

    $pesquisa_medico_cpf = $conn->query($pesquisa_medico);
    $resultado_pesquisa_medico = $conn->query($pesquisa_medico_cpf);
    $row = $resultado_pesquisa_medico->fetch_assoc();
    $especialidade_id = $row['especialidade_id'];
    
    ?>

  <section class="caixa">
        <h1>Dados do médico</h1><br>
        <form class="form" id="form" name="form" action="atualiza_cadastro_med.php" method="post">

            <!Adiciona campos ocultos para armazenar as variáveis>
            <input type="hidden" id="CRM" name="CRM" value="<?php echo $CRM; ?>">
            <input type="hidden" id="verifica" name="verifica" value="0">
          
            <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $nome; ?>" required="">
            </div>
            
            <div class="column">

                <div class="input-box">
                    <label>CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $CPF; ?>" required="">
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
                <label>Confirme a senha</label>
                <input type="text" id="confirmaSenha" name="confirmaSenha"  placeholder="Confirme sua senha" value="<?php echo $senha; ?>" required="">
            </div>

            <div class="input-box">
                <label>Especialidade</label>
                <select id="especialidade" name="especialidade" required="">
                    <option value="">Selecione a especialidade</option>
                    <option value="1">Cardiologia</option>
                    <option value="2">Dermatologia</option>
                    <option value="3">Pediatria</option>
                    <option value="4">Neurologia</option>
                    <option value="5">Ortopedia</option>
                    <option value="6">Endocrinologia</option>
            </div>

            
            <div class="column">

                <div class="input-box">
                <div class="input-box">
            
            <input type="button" id="atualizar" class="cadbot" value="Atualizar" onclick="confirn()">
          </div>
      
          <div class="input-box">

            
            <input type="button" id="deletar" class="cadbot" value="Excluir" onclick="confirmarExclusao()">
          </div>
      
      </div>

    </form>
</section>    
</body>

<script>

function confirmarExclusao() {
    // Exibe uma caixa de diálogo de confirmação
    if (confirm("Tem certeza que deseja excluir este usuário?")) {
        // Se o usuário confirmar, redireciona para uma página PHP que realiza a exclusão
        var Cpf = document.getElementById('cpf').value;
        var verifica = 1;
        window.location.href = "atualiza_cadastro_med.php?verifica=" +verifica + "&Cpf=" +Cpf;
    } 
}

function confirn(){
        var senha = document.getElementById('Senha').value
        var confirmaSenha = document.getElementById('confirmaSenha').value;
        var CpfRegex = /^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/i
        var Cpf = document.getElementById('cpf').value
        var Crm = document.getElementById('crm').value;
        let nome = document.getElementById('nome').value
        let data = document.getElementById('data').value
        const testa_senha = /^.{6,30}$/;
        const testa_num = /^\d{2,10}(\.\d+)?$/;
        const letra = /^[A-Za-z ]{1,100}$/;
        if (!(testa_senha.test(senha))) {
            alert('Sua senha tem que ter de 6 a 30 caracteres.');
            return;
        }
        else if(!data){
            alert("Preencha a data de nascimento.");
        }
        else if (!(letra.test(nome))){
            alert("Digite o nome completo.")
            return;
        }
        else if (senha != confirmaSenha){
            alert("As senhas não correspondem")
            return;
        }
        else{
           
            if (CpfRegex.test(Cpf) == false){
                alert('Digite um cpf Válido')
                return
            } else if (!/^\d{7}$/.test(crm)) {
                alert('Digite um CRM válido (7 dígitos)');
                return false;
            } else{
                form.submit();
            }
             
        }
     }
</script>
</html>