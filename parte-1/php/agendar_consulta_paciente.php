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
            $pesquisa_medico = "SELECT m.medico_cpf, m.crm, u.nome
                                FROM medico m 
                                INNER JOIN usuario u ON m.medico_cpf = u.cpf
                                LEFT JOIN agenda a ON m.crm = a.medico_crm
                                WHERE m.especialidade_id='$especialidade'
                                AND a.medico_crm IS NOT NULL
                                GROUP BY m.crm";

            $resultado_pesquisa_medico = $conn->query($pesquisa_medico);

            if ($resultado_pesquisa_medico->num_rows == 0) {
                echo "<section class='container'>
                    <section class='message-box'>
                        Ainda não há consultas para essa especialidade
                    </section>
                    </section>";
            } else {
                while ($linha_pesquisa_medico = $resultado_pesquisa_medico->fetch_assoc()) {
                    $crm_medico = $linha_pesquisa_medico['crm'];
                    $nome_medico = $linha_pesquisa_medico['nome'];

                    echo "<section class='result-box_outro'>
                            <a href='../php/adicionar_consulta_paciente.php?crm=$crm_medico&nome=$nome_medico&espe=$especialidade'>$nome_medico</a>
                        </section>";
                }
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

