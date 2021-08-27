<?php

header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf_seguidor = $deco->cpf_seguidor;
    $cpf_seguido = $deco->cpf_seguido;

    $sql = "INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUES
                ('$cpf_seguidor', '$cpf_seguido')";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Amigo inserido com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}
?>