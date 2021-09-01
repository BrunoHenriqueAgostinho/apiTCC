<?php

/*
    {
        "codigo":"1"
    }
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql = "SELECT * FROM desenvolve_usuario_trabalho WHERE Tb_Trabalho_codigo_trabalho = '$codigo' ORDER BY Tb_Usuario_cpf_usuario";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado) {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao listar " . $conexao->error]);
    }
}
?>