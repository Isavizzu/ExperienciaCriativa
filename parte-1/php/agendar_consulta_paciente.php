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
    <section class="agenda_titulo">
        <p>Agendar consulta</p>
    </section>

    <form class="form" id="form" name="form" method="post">

    <div class="inputbox">
            <div class="column">
            <div class="select-box">
                <select id="especialidade" name="especialidade" required="">
                    <?php 
                    echo "<option value=''>Selecione a especialidade</option>";
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
                while($linha_pesquisa_medico = $resultado_pesquisa_medico->fetch_assoc()){
                    $pesquisa_nome_medico = "SELECT nome 
                                            FROM usuario 
                                            WHERE cpf='$linha_pesquisa_medico[medico_cpf]'";
                    $resultado_pesquisa_nome_medico = $conn->query($pesquisa_nome_medico);
                    $linha_pesquisa_nome_medico = $resultado_pesquisa_nome_medico->fetch_assoc();
                    echo"<section class='result-box'>
                        <a href='../php/adicionar_consulta.php?crm=$linha_pesquisa_medico[crm]&nome=$linha_pesquisa_nome_medico[nome]'>$linha_pesquisa_nome_medico[nome]</a>
                    </section>";
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

            

    </form>

    
</body>
</html>