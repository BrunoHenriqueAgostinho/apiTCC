<?php

header('Content-Type: application/json');
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
                    count(seguidor_usuario) as seguidores 
                FROM 
                    adiciona_usuario_usuario 
                WHERE 
                    seguido_usuario = '$cpf'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            $dados = $resultado2->fetch_array(MYSQLI_ASSOC);
            $seguidores = $dados['seguidores'];
            http_response_code(200);
            echo json_encode(["mensagem" => $seguidores]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao consultar seguidores."]);
        }
    }
}
?>