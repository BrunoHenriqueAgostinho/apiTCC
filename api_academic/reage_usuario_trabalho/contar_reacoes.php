<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql = "SELECT 
                count(Tb_Usuario_cpf_usuario) AS reacoes
            FROM 
                reage_usuario_trabalho
            WHERE 
                Tb_Trabalho_codigo_trabalho = $codigo";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>