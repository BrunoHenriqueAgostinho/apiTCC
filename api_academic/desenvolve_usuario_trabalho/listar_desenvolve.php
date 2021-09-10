<?php
/*
{
    "codigo":"1"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                * 
            FROM 
                tb_trabalho
            WHERE 
                codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0){
        header("HTTP/1.1 500 Trabalho inexistente");
        echo json_encode(["erro" => "Não existe esse trabalho."]);
    } else {
        $sql2 = "SELECT 
                    * 
                FROM 
                    desenvolve_usuario_trabalho 
                WHERE 
                    Tb_Trabalho_codigo_trabalho = '$codigo' ORDER BY Tb_Usuario_cpf_usuario";
        $resultado2 = mysqli_query($conexao, $sql2);
        $contador2 = mysqli_num_rows($resultado2);
        if ($contador2 == 0) {
            header("HTTP/1.1 500 Sem membros");
            echo json_encode(["erro" => "O trabalho não apresenta membros."]);
        } else {
            $dados = $resultado2->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>