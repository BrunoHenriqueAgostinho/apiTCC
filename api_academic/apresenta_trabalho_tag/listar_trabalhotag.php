<?php
/*{
    "codigo": "2"
}*/

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
        header("HTTP/1.1 500 Registro inexistente");
        echo json_encode(["erro" => "Esse trabalho não existe."]);
    } else {

    }


    $sql2 = "SELECT 
                Tag.categoria_tag 
            FROM 
                apresenta_trabalho_tag TT, 
                tb_tag Tag 
            WHERE 
                TT.Tb_Trabalho_codigo_trabalho = $codigo 
            AND 
                TT.Tb_Tag_codigo_tag = Tag.codigo_tag";
    $resultado2 = mysqli_query($conexao, $sql2);
    $contador2 = mysqli_num_rows($resultado2);
    if ($contador2 == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao pesquisar por tags."]);
    } else {
        $dados = $resultado2->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>