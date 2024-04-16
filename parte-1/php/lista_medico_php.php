<?php
    include("base.php");
    include("session_start.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Dados do médico</title>
</head> 

<body class="">
    <?php 
        $CPF= $_GET['cpf'];
        $pesquisa_cpf = "SELECT cpf, nome, data_nascimento, senha FROM usuario WHERE cpf = '$CPF'";
        $resultado_pesquisa = $conn->query($pesquisa_cpf);
        $row = $resultado_pesquisa->fetch_assoc();
        $nome = $row['nome'];
        $data_nascimento = $row['data_nascimento'];
        $senha = $row['senha'];

        $pesquisa_medico_cpf =  "SELECT crm, medico_cpf, especialidade_id FROM medico WHERE medico_cpf = '$CPF'";
        $resultado_pesquisa_medico = $conn->query($pesquisa_medico_cpf);
        $row = $resultado_pesquisa_medico->fetch_assoc();
        $especialidade_id = $row['especialidade_id'];
        $CRM = $row['crm'];

        $pesquisa_especialidade = "SELECT nome_especialidade FROM especialidade WHERE id = $especialidade_id";
        $resultado_especialidade = $conn->query($pesquisa_especialidade);
        $row = $resultado_especialidade->fetch_assoc();
        $especialidade_nome = $row['nome_especialidade'];

        if($_SESSION['pagina_visitada'] == false || !isset($_SESSION['pagina_visitada'])){
            $_SESSION['nome_medico_atualiza'] = $nome;
            $_SESSION['cpf_medico_atualiza'] = $CPF;
            $_SESSION['senha_medico_atualiza'] = $senha;
            $_SESSION['conf_senha_medico_atualiza'] = $senha;
            $_SESSION['data_medico_atualiza'] = $data_nascimento;
            $_SESSION['crm_medico_atualiza'] = $CRM;
            $_SESSION['especialidade_medico_atualiza'] = $especialidade_nome;
            $_SESSION['valor_especialidade_medico_atualiza'] = $especialidade_id;
            $_SESSION['pagina_visitada_atualiza'] = true;
        }

        if(isset($_POST['Atualizar'])){
            mudar_variaveis();
        }
    ?>
    <section class="caixa">
        <h1>Dados do médico</h1><br>
        <form class="form" id="form" name="form" method="post" >

            <div class="input-box">
                <label>Nome completo</label>
                <input type="text" id="nome" name="nome" placeholder="Digite o nome completo" value="<?php echo $_SESSION['nome_medico_atualiza']; ?>"  pattern="^[A-Za-zÀ-úçÇ ]{1,100}$"  required="">
            </div>
            
            <div class="column">

                <div class="input-box">
                    <label>CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite o CPF no formato xxxxxxxxxxx ou xxx.xxx.xxx-xx"  value="<?php echo $_SESSION['cpf_medico_atualiza']; ?>" required="">
                </div>

                <div class="input-box">
                    <label>CRM</label>
                    <input type="text" id="crm" name="crm" placeholder="Digite o CRM no formato xxxxxxx"  value="<?php echo $_SESSION['crm_medico_atualiza']; ?>" required="">
                </div>
            
            
                <div class="input-box">
                    <label>Data de Nascimento</label>
                    <input type="date" id="data" name="data" placeholder="dd/mm/aaaa" value="<?php echo $_SESSION['data_medico_atualiza']; ?>"  required="">
                </div>
            </div>

            <div class="column">

                <div class="input-box">
                    <label>Senha</label>
                    <input type="password" id="Senha" name="Senha" placeholder="Digite uma senha com 6 a 30 caracteres" value="<?php echo $_SESSION['senha_medico_atualiza']; ?>" required="">
                    <span onclick="showPassword()"></span>
                </div>

                <div class="input-box">
                    <label>Confirme a senha</label>
                    <input type="password" id="confirmaSenha" name="confirmaSenha"  placeholder="Confirme sua senha" value="<?php echo $_SESSION['conf_senha_medico_atualiza']; ?>" required="">
                    <span onclick="showPassword()"></span>
                </div>
            </div>

            <div class="input-box">

            <label>Especialidade</label>

            <div class="column">

            <div class="select-box">
                <select id="especialidade" name="especialidade" required="">
                    <option value="<?php echo $_SESSION['valor_especialidade_medico_atualiza']; ?>"><?php echo $_SESSION['especialidade_medico_atualiza']; ?></option>
                    <option value="1">Cardiologia</option>
                    <option value="2">Dermatologia</option>
                    <option value="3">Pediatria</option>
                    <option value="4">Neurologia</option>
                    <option value="5">Ortopedia</option>
                    <option value="6">Endocrinologia</option>
                </select>
            </div>
            </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <?php
                    if(isset($_POST['Atualizar'])) {
                        botao_atualizar($CRM, $CPF);
                    }
                    else if(isset($_POST['Excluir'])){
                        botao_excluir($CPF);
                    }

                    function verifica_cpf($Cpf, $CPF){

                        global $conn;
                        $pesquisa_cpf = "SELECT cpf FROM usuario WHERE cpf = '$Cpf'";
                        $resultado_pesquisa = $conn->query($pesquisa_cpf);
                        $row = $resultado_pesquisa->fetch_assoc();
                        if($row == null){
                          return true;
                        }
                        else if ($row['cpf'] == $CPF){
                            return true;
                        }
                        else{
                            return false; 
                        }
                    } 

                    function verifica_crm($crm, $CRM){
                        global $conn;
                        $pesquisa_crm = "SELECT crm FROM medico WHERE crm = '$crm'";
                        $resultado_pesquisa_crm = $conn->query($pesquisa_crm);
                        $row = $resultado_pesquisa_crm->fetch_assoc();
                        if($row == null){
                          return true;
                        }
                        else if ($row['crm'] == $CRM){
                            return true;
                        }
                        else{
                            return false; 
                        }
                    }

                    function mudar_variaveis(){
                        $especialidade = $_POST['especialidade'];

                        if($especialidade == 1){
                            $_SESSION['especialidade_medico_atualiza'] = 'Cardiologia';
                        }
                        else if($especialidade == 2){
                            $_SESSION['especialidade_medico_atualiza'] = 'Dermatologia';
                        }
                        else if($especialidade == 3){
                            $_SESSION['especialidade_medico_atualiza'] = 'Pediatria';
                        }
                        else if($especialidade == 4){
                            $_SESSION['especialidade_medico_atualiza'] = 'Neurologia';
                        }
                        else if($especialidade == 5){
                            $_SESSION['especialidade_medico_atualiza'] = 'Ortopedia';
                        }
                        else if($especialidade == 6){
                            $_SESSION['especialidade_medico_atualiza'] = 'Endocrinologia';
                        }

                        $_SESSION['nome_medico_atualiza'] = $_POST['nome'];
                        $_SESSION['cpf_medico_atualiza'] = $_POST['cpf'];
                        $_SESSION['senha_medicoat_atualiza'] = $_POST['Senha'];
                        $_SESSION['conf_senha_medico_atualiza'] = $_POST['confirmaSenha'];
                        $_SESSION['data_medico_atualiza'] = $_POST['data'];
                        $_SESSION['crm_medico_atualiza'] = $_POST['crm'];
                        $_SESSION['valor_especialidade_medico_atualiza'] = $_POST['especialidade'];
                    }

                    function calcularIdade($datformat) {
                        $datformat = new DateTime($datformat);
                        $agora = new DateTime();
                        $idade = $agora->diff($datformat);
                        return $idade->y;
                    }

                    function botao_atualizar($CRM,$CPF){

                        global $conn;

                        $Cpf = $_POST['cpf'];
                        $Nome = $_POST['nome'];
                        $dat = $_POST['data'];
                        $crm = $_POST['crm'];
                        $Senha = $_POST['Senha'];
                        $especialidade = $_POST['especialidade'];
                        $confirmasenha = $_POST['confirmaSenha'];
                        $datformat = date('Y-m-d',strtotime($dat));
                    
                        if ($Senha != $confirmasenha){
                            echo "<section class='section_invalido'><p>As senhas não correspondem!</p></section>";
                        }
                        else if(verifica_cpf($Cpf, $CPF) == false){
                            echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
                        }
                        else if(verifica_cpf($crm, $CRM) == false){
                            echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
                        }
                        else if (!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $Cpf)){
                            echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
                        }
                        else if($datformat > date('Y-m-d')){
                            echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
                          }
                        else if (!preg_match('/^.{6,30}$/', $Senha)){
                            echo "<section class='section_invalido'><p>A senha precisa ter no mínimo 6 caracteres!</p></section>";
                        }
                        else if (!preg_match('/^[A-Za-zÀ-úçÇ ]{1,100}$/', $Nome)){
                            echo "<section class='section_invalido'><p>Digite o nome completo!</p></section>";
                        }
                        else if(calcularIdade($datformat) < 25){
                            echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
                        }
                        else if (!preg_match('/^\d{7}$/', $crm)){
                                echo "<section class='section_invalido'><p>Digite um CRM válido (7 dígitos)!</p></section>";    
                        }
                        else{
                                $sql = "UPDATE usuario SET cpf = '$Cpf', nome = '$Nome', data_nascimento = '$datformat', senha = '$Senha' WHERE cpf = '$CPF'";
                                $sql1 = "UPDATE medico SET crm = '$crm', especialidade_id = $especialidade WHERE medico_cpf = '$CPF'";
                                $conn->query($sql);
                                $conn->query($sql1);
                                $_SESSION['pagina_visitada'] = false;
                                echo '<meta http-equiv="refresh" content="0; URL=cadastro_med_php.php?val=2">';
                            }
                        }
                    
                    
                    function botao_excluir($CPF){
                        $_SESSION['pagina_visitada'] = false;
                        echo "<meta http-equiv='refresh' content='0; URL=cadastro_med_excluir.php?cpf=$CPF'>";
                    }
                    ?>
                    <div class="column">
                    
                    <div class="input-box">
                        <input type="submit" id="Atualizar" name="Atualizar" class="cadbot" value="Atualizar" >
                    </div>
                
                    <div class="input-box">
                        <input type="submit" id="Excluir" name="Excluir" class="cadbot" value="Excluir" >
                    </div>
                
                </div>

        </form>
    </section>    
</body>
</html>