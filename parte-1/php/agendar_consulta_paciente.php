<?php
    include("base_paciente.php");
    include("session_start.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/consulta_paciente.css">
    <title>Agendar consulta</title>
</head>
<body>
    <?php
        if($_SESSION['pagina_visitada'] == false || !isset($_SESSION['pagina_visitada'])){
                $_SESSION['especialidade_escolhida'] = 'Selecione a especialidade';
                $_SESSION['valor_especialidade_medico']= ''; 
                $_SESSION['pagina_visitada'] = true;
            }

        if(isset($_POST['Buscar'])){
            $_SESSION['valor_especialidade_medico']= $_POST['especialidade'];      
            $sql = "SELECT * FROM especialidade";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    if ($_SESSION['valor_especialidade_medico'] == $row['id']){
                        $_SESSION['especialidade_escolhida'] = $row['nome_especialidade'];
                        $especialidade_nome = $row['nome_especialidade'];
                    }
                }
            }
        }
    ?>
    <section class="agenda_titulo">
        <p>Agendar consulta</p>
    </section>

    <form class="form" id="form" name="form" method="post">

    <div class="inputbox">
            <div class="column">
            <div class="select-box">
                <select id="especialidade" name="especialidade" required="">
                    <?php  
                    echo "<option value='{$_SESSION['valor_especialidade_medico']}'>{$_SESSION['especialidade_escolhida']}</option>";
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
                <input type="submit" id="Enviar" class="cadbot" name="Buscar" value="Buscar">
            </div>
            </div>


            
    <section class="container">
        <?php
         if (isset($_POST['Buscar'])) {

            $especialidade = $_POST['especialidade'];
            $pesquisa_medico = "SELECT medico_cpf, crm
                                FROM medico  WHERE especialidade_id='$especialidade'";
            $resultado_pesquisa_medico = $conn->query($pesquisa_medico);
            

            if ($resultado_pesquisa_medico->num_rows > 0){
                while ($linha_pesquisa_medico = $resultado_pesquisa_medico->fetch_assoc()) {
                    $crm_medico = $linha_pesquisa_medico['crm'];
                    
                    $pesquisa_agenda = "SELECT medico_crm FROM agenda WHERE medico_crm = '$crm_medico'";
                    $resultado_agenda = $conn->query($pesquisa_agenda);
                    
                    if ($resultado_agenda->num_rows > 0) {
                        $medico_cpf = $linha_pesquisa_medico['medico_cpf'];
                        
                        $pesquisa_nome_medico = "SELECT nome FROM usuario WHERE cpf = '$medico_cpf'";
                        $resultado_pesquisa_nome_medico = $conn->query($pesquisa_nome_medico);
                        
                        if ($resultado_pesquisa_nome_medico->num_rows > 0) {
                            $linha_pesquisa_nome_medico = $resultado_pesquisa_nome_medico->fetch_assoc();
                            $nome_medico = $linha_pesquisa_nome_medico['nome'];
                            
                            echo "<section class='result-box_outro'>
                                    <a href='../php/adicionar_consulta_paciente.php?crm=$crm_medico&nome=$nome_medico&espe=$especialidade'>$nome_medico</a>
                                  </section>";
                        }
                    }
                }
                
            }
            else {
                echo "<section class='container'>
                        <section class='message-box'>
                            Ainda não há consultas para essa especialidade
                        </section>
                    </section>";
            }
        }
            
        
        ?>
    </section>

    <?php
        if(!isset($_POST['Buscar'])){
            echo "<section class='container'>
            <section class='message-box'>
            <p>Selecione uma especialidade e clique em buscar, depois escolha um médico.</p>   
            </section>
            </section>";
            
            
            //echo '<section class="success">
              //  <p>Selecione uma especialidade e clique em buscar, depois escolha um médico.</p>
                //</section>';
    }
    
    ?>

            

    </form>

    
</body>
</html>