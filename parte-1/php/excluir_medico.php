<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['CRM'])) {
        include("base.php");

        $CRM = $_POST['CRM'];

        if(isset($_POST['verifica']) && $_POST['verifica'] == 1) {
            $query_excluir_medico = "DELETE FROM medico WHERE crm = '$CRM'";

            if ($conn->query($query_excluir_medico) === TRUE) {
                header("Location: lista_medico_php.php?success=Médico excluído com sucesso.");
                exit();
            } else {
                header("Location: lista_medico_php.php?error=Erro ao excluir o médico: " . $conn->error);
                exit();
            }
        } else {
            header("Location: lista_medico_php.php?error=Parâmetro de verificação inválido.");
            exit();
        }
    } else {
        header("Location: lista_medico_php.php?error=CRM do médico não foi recebido.");
        exit();
    }
} else {
    header("Location: lista_medico_php.php?error=Dados não foram enviados via POST.");
    exit();
}
?>
