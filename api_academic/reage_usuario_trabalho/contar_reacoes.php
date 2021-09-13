<?php
/*
{
	"codigo": "2"
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
                codigo_trabalho = " . $codigo;
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar trabalho."]);
    } else {
        $sql2 = "SELECT 
                    count(Tb_Usuario_cpf_usuario) AS reacoes
                FROM 
                    reage_usuario_trabalho
                WHERE 
                    Tb_Trabalho_codigo_trabalho = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            $dados = $resultado2->fetch_array(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao contar reações"]);
        }
    }
}
?>