<?php
/*{
    "codigo": "2"
}*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    
    $sql = "SELECT Tag.categoria_tag FROM apresenta_trabalho_tag TT, tb_tag Tag WHERE TT.Tb_Trabalho_codigo_trabalho = ".$codigo." AND TT.Tb_Tag_codigo_tag = Tag.codigo_tag";

    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>