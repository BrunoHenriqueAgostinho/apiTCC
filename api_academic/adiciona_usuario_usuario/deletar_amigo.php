<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf_seguidor = $deco->cpf_seguidor;
    $cpf_seguido = $deco->cpf_seguido;

    $sql = "DELETE FROM adiciona_usuario_usuario 
            WHERE 
                seguidor_usuario = '$cpf_seguidor' 
            AND
                seguido_usuario = '$cpf_seguido'"; 
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(200);
        $dados = ["mensagem" => "Deixou de Seguir"];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>