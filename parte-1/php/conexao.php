<?php
    $servername = "localhost";
    $username = "root";
    $password = "PUC@1234";
    $dbname = "clinical_here";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $SESSION['cpf_login'] = "";

    if ($conn->connect_error) {
?>
        <section>
            <p>Houve um problema de Conexão
                com o Banco de Dados. Tente
                Novamente, mais tarde.
            </p>
        </section>
<?php
        die("Connection failed: " . $conn->connect_error);
    }
?>
