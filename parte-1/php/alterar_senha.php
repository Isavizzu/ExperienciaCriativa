<?php
    include("base.php");
    include("conexao.php"); 
    include("session_start.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adicionar_consulta.css">
    <title>Alterar senha</title>
</head>
<body>
    <section class="titulo">
        <h1>Alterar senha</h1>
    </section>

    <section class="caixa">
        <form class="form"  method="POST">
            <div class="input-box">
                <label>Senha</label>
                <input type="password" id="senha" name="Senha"  placeholder="Digite uma senha com no mínimo 8 caracteres"  required="" >
            </div>

            <div class="input-box">
                <label>Confirmar senha</label>
                <input type="password" id="confirmasenha" name="confirmasenha"  placeholder="Confirme sua senha"  required="" >
            </div>

    <?php
        if(isset($_POST['confirmar'])) {
            $senha = $_POST['Senha'];
            $confirmasenha = $_POST['confirmasenha'];
            if($senha != $confirmasenha){
                echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
            }
            else if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,30}$/', $senha)){
                echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 8 caracteres e incluir pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial ($, *, &, @, #).</p></section>";
            }
            else{
                $cpf = $_GET['cpf'];
                $hash = md5($senha);
                $sql = "UPDATE usuario SET senha='$hash'  WHERE cpf = '$cpf'";
                $conn->query($sql);
                echo '<meta http-equiv="refresh" content="0; URL=cadastro_paciente_php.php?val=2">';
            }
        }



    ?>
    
        <input type="submit" name="confirmar" class="cadbot" value="Confirmar">

    </form>

    </section>
    
    
</body>
</html>