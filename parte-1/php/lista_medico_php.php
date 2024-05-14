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
    <link rel="stylesheet" href="../css/cadastro.css">
    <title>Dados do médico</title>
</head> 

<body class="">
    <?php     
        
        // Recupera os valores do banco de dados e atualiza as variáveis de sessão apenas se necessário
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
            $_SESSION['data_medico_atualiza'] = $data_nascimento;
            $_SESSION['crm_medico_atualiza'] = $CRM;
            $_SESSION['especialidade_medico_atualiza'] = $especialidade_nome;
            $_SESSION['valor_especialidade_medico_atualiza'] = $especialidade_id;
            $_SESSION['pagina_visitada'] = true;
        }
        // Verifica se o formulário foi submetido (se o botão "Atualizar" foi clicado)
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

            <div class="input-box">

            <label>Especialidade</label>

            <div class="column">

            <div class="select-box">
                <select id="especialidade" name="especialidade" required="">
                    <?php 
                    echo "<option value='{$_SESSION['valor_especialidade_medico_atualiza']}'>{$_SESSION['especialidade_medico_atualiza']}</option>";
                    $sql = "SELECT * FROM especialidade";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo "<option value='{$row['id']}'>{$row['nome_especialidade']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            </div>
            </div>

            <div class="input-box">
            <label>Senha <a href="alterar_senha.php?cpf=<?php echo $CPF; ?>">(Alterar senha)</a></label>
            <input type="text" id="Senha" name="Senha" value="********" readonly>
            </div>
            <br> 

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
                        include("conexao.php");
                        $especialidade = $_POST['especialidade'];
                    
                        // Atualiza a especialidade na sessão com base no valor selecionado no formulário
                        $sql = "SELECT * FROM especialidade";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                if ($especialidade == $row['id']){
                                    $_SESSION['especialidade_medico_atualiza'] = $row['nome_especialidade'];
                                }
                            }
                        }
                    
                        // Atualiza as demais variáveis de sessão
                        $_SESSION['nome_medico_atualiza'] = $_POST['nome'];
                        $_SESSION['cpf_medico_atualiza'] = $_POST['cpf'];
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

                    function validaCPF($cpf) {
                        // Remove caracteres não numéricos
                        $cpf = preg_replace('/[^0-9]/', '', $cpf);
                    
                        // Verifica se o CPF possui 11 dígitos
                        if (strlen($cpf) != 11) {
                            return false;
                        }
                    
                        // Verifica se todos os dígitos são iguais, o que torna o CPF inválido
                        if (preg_match('/(\d)\1{10}/', $cpf)) {
                            return false;
                        }
                    
                        // Calcula o primeiro dígito verificador
                        $sum = 0;
                        for ($i = 0; $i < 9; $i++) {
                            $sum += $cpf[$i] * (10 - $i);
                        }
                        $remainder = $sum % 11;
                        $digit1 = ($remainder < 2) ? 0 : (11 - $remainder);
                    
                        // Calcula o segundo dígito verificador
                        $sum = 0;
                        for ($i = 0; $i < 10; $i++) {
                            $sum += $cpf[$i] * (11 - $i);
                        }
                        $remainder = $sum % 11;
                        $digit2 = ($remainder < 2) ? 0 : (11 - $remainder);
                    
                        // Verifica se os dígitos verificadores estão corretos
                        if ($cpf[9] != $digit1 || $cpf[10] != $digit2) {
                            return false;
                        }
                    
                        return true;
                    }

                    function botao_atualizar($CRM,$CPF){

                        global $conn;

                        $Cpf = $_POST['cpf'];
                        $Nome = $_POST['nome'];
                        $dat = $_POST['data'];
                        $crm = $_POST['crm'];
                        $especialidade = $_POST['especialidade'];
                        $datformat = date('Y-m-d',strtotime($dat));
                    
            
                        if(verifica_cpf($Cpf, $CPF) == false){
                            echo "<section class='section_invalido'><p>Esse CPF já foi cadastrado anteriormente!</p></section>";
                        }
                        else if(verifica_crm($crm, $CRM) == false){
                            echo "<section class='section_invalido'><p>Esse CRM já foi cadastrado anteriormente!</p></section>";
                        }
                        else if (!preg_match('/^[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}$/', $Cpf)){
                            echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
                        }
                        else if (!validaCPF($_POST['cpf'])) {
                            echo "<section class='section_invalido'><p>Digite um CPF válido!</p></section>";
                        }
                        else if($datformat > date('Y-m-d')){
                            echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
                        }
                        else if (!preg_match('/^[A-Za-zÀ-úçÇ ]{3,100}$/', $Nome)){
                            echo "<section class='section_invalido'><p>Digite o nome completo!</p></section>";
                        }
                        else if(calcularIdade($datformat) < 25){
                            echo "<section class='section_invalido'><p>Digite uma data válida!</p></section>";
                        }
                        else if (!preg_match('/^\d{7}$/', $crm)){
                                echo "<section class='section_invalido'><p>Digite um CRM válido (7 dígitos)!</p></section>";    
                        }
                        else{
                                $sql = "UPDATE usuario SET cpf = '$Cpf', nome = '$Nome', data_nascimento = '$datformat' WHERE cpf = '$CPF'";
                                $sql1 = "UPDATE medico SET crm = '$crm', especialidade_id = $especialidade WHERE medico_cpf = '$Cpf'";
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