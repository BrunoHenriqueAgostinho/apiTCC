<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql = "DELETE FROM tb_usuario WHERE cpf_usuario = " . $cpf;
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(200);
        $dados = ["mensagem" => "Usuário deletado com sucesso"];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>