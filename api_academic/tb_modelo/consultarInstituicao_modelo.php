<?php

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $codigo = $deco->codigo;

    $sql = "SELECT 
                count(codigo_modelo) as instituicao
            FROM 
                tb_modelo 
            WHERE
                Tb_Instituicao_cnpj_instituicao = '$cnpj' and codigo_modelo = $codigo";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        //Erro ao listar modelos.
        echo json_encode(["erro" => "Houve um problema ao consultar a instituição do modelo"]);
    }    
} 
?>