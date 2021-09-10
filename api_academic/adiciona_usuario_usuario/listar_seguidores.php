<?php
/*
{
    "cpf": "11111111111"
}
*/

header('Content-Type: application/json');
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar usuário."]);
    } else {
        $sql2 = "SELECT 
                    seguidor_usuario,
                    seguido_usuario
                FROM 
                    adiciona_usuario_usuario 
                WHERE 
                    seguido_usuario = '$cpf'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            $dados = $resultado2->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao consultar seguidores."]);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>