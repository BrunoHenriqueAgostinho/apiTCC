<?php
/*{
    "nome": "E"
}*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $sql = "SELECT 
                codigo_tag as codigo, 
                categoria_tag as categoria
            FROM 
                Tb_Tag";
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        //Erro ao selecionar tags
        echo json_encode(["erro" => "Houve um problema ao listar as tags de trabalho"]);
    } else {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
} 
?>