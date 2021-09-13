<?php
/*
{
    "pesquisa": "Devisate"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;
    
    $sql = "SELECT 
                I.*
            FROM 
                tb_instituicao I
            WHERE 
                I.nome_instituicao like '%$pesquisa%'";
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($resultado) {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao pesquisar por instituições."]);
    }
}
?>