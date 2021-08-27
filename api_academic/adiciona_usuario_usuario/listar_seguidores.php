<?php
/*
{
    "cpf": "11111111111"
}
*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql = "SELECT 
                seguidor_usuario,
                seguido_usuario
            FROM 
                adiciona_usuario_usuario 
            WHERE 
                seguido_usuario = " . $cpf;
        
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>