<?php

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql = "SELECT 
                count(Tb_Usuario_cpf_usuario) as usuario
            FROM
                Desenvolve_Usuario_Trabalho
            WHERE
                Tb_Usuario_cpf_usuario = $cpf AND Tb_Trabalho_codigo_trabalho = $codigo";
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0){
        header("HTTP/1.1 500 Erro ao consultar banco");
        echo json_encode(["erro" => "Não foi possível consultar os membros deste trabalho."]);
    } else {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}

?>