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
                Tb_Usuario
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        //Erro ao consultar usuário
        echo json_encode(["erro" => "Houve um problema ao contar o número de seguidores"]);
    } else {
        $sql2 = "SELECT
                    count(seguidor_usuario) as seguidores 
                FROM 
                    Adiciona_Usuario_Usuario 
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
            //Erro ao consultar seguidores
            echo json_encode(["erro" => "Houve um problema ao contar o número de seguidores"]);
        }
    }
}
?>