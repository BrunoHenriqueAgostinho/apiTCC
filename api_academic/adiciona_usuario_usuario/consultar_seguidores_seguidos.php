<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf_seguidor = $deco->cpf_seguidor;
    $cpf_seguido = $deco->cpf_seguido;

    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario
            WHERE 
                cpf_usuario = '$cpf_seguidor'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    $sql2 = "SELECT 
                *
            FROM 
                tb_usuario
            WHERE 
                cpf_usuario = '$cpf_seguido'";
    $resultado2 = mysqli_query($conexao, $sql2);
    $contador2 = mysqli_num_rows($resultado2);
    
    if ($contador1 == 0 || $contador2 == 0){
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar usuários."]);
    } else {
        $sql3 = "SELECT 
                    seguidor_usuario,
                    seguido_usuario
                FROM 
                    adiciona_usuario_usuario 
                WHERE 
                    seguido_usuario = '$cpf_seguido' AND seguidor_usuario = '$cpf_seguidor'";
        $resultado3 = mysqli_query($conexao, $sql3);
        if ($resultado3) {
            $dados = $resultado3->fetch_array(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao consultar amigos."]);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>