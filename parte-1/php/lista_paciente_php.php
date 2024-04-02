<?php
    include("base.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/lista_paciente.css">
    <title>Dados do paciente</title>
</head>

<body class="">
    <?php
    $CPF= $_GET["crm"];
    $pesquisa_cpf = "SELECT cpf, nome, data_nascimento, senha FROM usuario WHERE cpf = '$CPF'";
    $resultado_pesquisa = $conn->query($pesquisa_cpf);
    $row = $resultado_pesquisa->fetch_assoc();
    $nome = $row['nome'];
    $data= $row['data_nascimento'];
    $senha = $row['senha'];

    $pesquisa_paciente_cpf = "SELECT telefone, paciente_cpf, altura, peso FROM paciente WHERE paciente_cpf = '$CPF'";
    $resultado_pesquisa_paciente = $conn->query($pesquisa_paciente_cpf);
    $row = $resultado_pesquisa_paciente->fetch_assoc();
    $alt= $row['altura'];
    $pes= $row['peso'];
    $tel= $row['telefone'];

    ?>
    
   <section class="caixa">
        <h1>Dados do paciente</h2><br>
        <form class="form" id="form" name="form" action="atualiza_cadastro.php" method="post">

        <!Adiciona campos ocultos para armazenar as variáveis>
        <input type="hidden" id="Cpf" name="cpf" value="">
        <input type="hidden" id="verifica" name="verifica" value="0">
      
      <div class="input-box">
          <label>Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $nome; ?>" required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $CPF; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" id="data" name="data" placeholder="dd/mm/aaaa" value="<?php echo $data; ?>" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Senha</label>
            <input type="text" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" value="<?php echo $senha; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Confirme a senha</label>
            <input type="text" id="confirmaSenha" name="confirmaSenha"  placeholder="Confirme sua senha" value="<?php echo $senha; ?>" required="">
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" placeholder="Digite a altura em metros"  value="<?php echo $alt; ?>" required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes"  placeholder="Digite o peso em Kg" value="<?php echo $pes; ?>" required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="tel" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx" value="<?php echo $tel; ?>" required="" >
      </div>
      <br>
      
      <div class="column">
      
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

// Função para exibir confirmação antes de excluir o usuário
function confirmarExclusao() {
    // Exibe uma caixa de diálogo de confirmação
    if (confirm("Tem certeza que deseja excluir este usuário?")) {
        // Se o usuário confirmar, redireciona para uma página PHP que realiza a exclusão
        var Cpf = document.getElementById('cpf').value;
        var verifica = 1;
        window.location.href = "atualiza_cadastro.php?verifica=" +verifica + "&Cpf=" +Cpf;
    } 
}

function confirn(){
        var senha = document.getElementById('Senha').value
        var confirmaSenha = document.getElementById('confirmaSenha').value;
        var CpfRegex = /^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/i
        var TelRegex = /^\d{9}$|^\d{5}-\d{4}$/;
        var Cpf = document.getElementById('cpf').value
        var Tel = document.getElementById('tel').value
        let pes = document.getElementById('pes').value
        let alt = document.getElementById('alt').value
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
        else if (!(testa_num.test(alt))){
            alert("Digite sua altura em metros")
            return;
        }
        else if (!(testa_num.test(pes))){
            alert("Digite seu peso em kg")
            return;
        }
        
        else{

            if (TelRegex.test(Tel) == false){
                alert('Digite um telefone Válido')
                return
            }
           
            if (CpfRegex.test(Cpf) == false){
                alert('Digite um cpf Válido')
                return
            }
            else{
                form.submit();
            }
             
        }
    }
</script>
</html>