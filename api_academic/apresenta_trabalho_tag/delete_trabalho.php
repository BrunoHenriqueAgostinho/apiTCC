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

    $sql = "DELETE FROM apresenta_trabalho_tag WHERE Tb_Trabalho_codigo_trabalho=".$trabalho." AND Tb_Tag_codigo_tag =".$tag;
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(200);
        $dados = ["mensagem" => "Tag deletada com sucesso do trabalho"];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>