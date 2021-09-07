<?php
/*{
    "trabalho": "2",
    "tag": "7"
}*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $trabalho = $deco->trabalho;
    $tag = $deco->tag;
    
    $sql = "INSERT apresenta_trabalho_tag (Tb_Trabalho_codigo_trabalho,Tb_Tag_codigo_tag) VALUES (".$trabalho.",".$tag.")";

    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Tag inserida com Sucesso ao trabalho"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>