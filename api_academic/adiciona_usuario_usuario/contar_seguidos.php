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
        echo json_encode(["erro" => "Houve um problema ao contar o número de pessoas que segue."]);
    } else {
        $sql2 = "SELECT
                    count(seguido_usuario) as seguidos
                FROM 
                    Adiciona_Usuario_Usuario 
                WHERE 
                    seguidor_usuario = '$cpf'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            $dados = $resultado2->fetch_array(MYSQLI_ASSOC);
            $seguidos = $dados['seguidos'];
            http_response_code(200);
            echo json_encode(["mensagem" => $seguidos]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            //Erro ao consultar seguidos
            echo json_encode(["erro" => "Houve um problema ao contar o número de pessoas que segue."]);
        }
    }
}
?>