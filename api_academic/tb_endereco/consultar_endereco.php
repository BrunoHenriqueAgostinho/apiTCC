<?php
/*
{
    "cpf": "11111111111"
}

{
    "cpf": "22222222222"
}
*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;

    $sql = "SELECT 
                E.Tb_Instituicao_cnpj_instituicao, 
                E.estado_endereco, 
                E.cidade_endereco, 
                E.bairro_endereco, 
                E.rua_endereco,
                E.numero_endereco,
                E.complemento_endereco, 
                E.cep_endereco
        
            FROM 
                tb_endereco E 
            WHERE 
                E.Tb_Instituicao_cnpj_instituicao = ".$cnpj;
        
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}