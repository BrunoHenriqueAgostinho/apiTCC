<?php
/*{
    "nome": "E"
}*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    
    $sql = "SELECT T.codigo_tag as codigo, T.categoria_tag as categoria 
    FROM tb_tag T, apresenta_trabalho_tag A 
    WHERE A.Tb_Trabalho_codigo_trabalho = $codigo AND A.Tb_Tag_codigo_tag = T.codigo_tag";
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao selecionar tags."]);
    } else {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
} 
?>