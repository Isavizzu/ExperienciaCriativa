<?php
    include("base.php");
    include("conexao.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
<br>
<h1>Formulário de Cadastro de Paciente</h1>


<br>

<section class="caixa">
<form class="form" id="form" name="form" action="criar_cadastro.php" method="post">
      
      <div class="input-box">
          <label>Nome completo</label>
          <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" required="" >
      </div>
      
      <div class="column">
      
          <div class="input-box">
            <label>CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx" required="" >
          </div>
      
          <div class="input-box">
            <label>Data de Nascimento</label>
            <input type="date" name="data" placeholder="Digite a data de nascimento" >
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Senha</label>
            <input type="text" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" required="" >
          </div>
      
          <div class="input-box">
            <label>Confirme a senha</label>
            <input type="text" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme sua senha" required="">
          </div>
      
      </div>

      <div class="column">
      
          <div class="input-box">
            <label>Altura</label>
            <input type="text" id="alt" name="alt" placeholder="Digite a altura em metros" required="" >
          </div>
      
          <div class="input-box">
            <label>Peso</label>
            <input type="text" id="pes" name="pes" placeholder="Digite o peso em Kg" required="">
          </div>
      
      </div>

      <div class="input-box">
          <label>Telefone</label>
          <input type="text" id="tel" name="telefone" placeholder="Digite o telefone no formato xxxxx-xxxx ou xxxxxxxxx" required="" >
      </div>
      <br>
      

      <input type="button" id="Enviar" class="cadbot" value="Cadastrar" onclick="confirm()">
  
    </form>
</section>

</div>
</body> 

<?php
    function verifica_cpf($cpf){
        $pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
        $resultado_pesquisa = $conn->query($pesquisa_cpf);
        $row = $resultado_pesquisa->fetch_assoc();
        if ($row == null){
            return false;
        }
        else{
            return true;
        }
    } 
?>

<script>

    function confirm(){
        var senha = document.getElementById('Senha').value
        var confirmaSenha = document.getElementById('confirmaSenha').value;
        var CpfRegex = /^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/i
        var TelRegex = /^\d{9}$|^\d{5}-\d{4}$/;
        var Cpf = document.getElementById('cpf').value
        var Tel = document.getElementById('tel').value
        let pes = document.getElementById('pes').value
        let alt = document.getElementById('alt').value
        let nome = document.getElementById('nome').value
        const testa_senha = /^.{6,30}$/;
        const testa_num = /^\d{2,10}(\.\d+)?$/;
        const letra = /^[A-Za-z ]{1,100}$/;
        let ok = <?php verifica_cpf(?>Cpf<?php)?>;
        if(ok){
            alert('Esse CPF já foi cadastrado!');
        }

        if (!(testa_senha.test(senha))) {
            alert('Sua senha tem que ter de 6 a 30 caracteres.');
            return;
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