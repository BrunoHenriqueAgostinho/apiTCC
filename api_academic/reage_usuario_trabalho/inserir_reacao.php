<?php

header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql = "INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
                ('$cpf', $codigo)";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Reação inserido com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}
?>