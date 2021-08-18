<?php

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    require("../conexao.php");
    $codigo = $_GET["id"];
    $sql = "delete from produto where pro_id = ". $codigo;
    
    $result = mysqli_query($conexao, $sql);
    if ($result) {
        $data = ["mensagem" => "Registro número ". $codigo." Excluído com Sucesso"];
        echo json_encode($data);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
} else {
    header("HTTP/1.1 501 Método Inválido");
    echo json_encode(["erro" => " Método Inválido"]);
}
}
?>