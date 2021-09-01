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

if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $estado = $deco->estado;
    $cidade = $deco->cidade;
    $bairro = $deco->bairro;
    $rua = $deco->rua;
    $numero = $deco->numero;
    $complemento = $deco->complemento;
    $cep = $deco->cep;

    $sql = "UPDATE tb_endereco 
            SET  
                estado_endereco = '$estado', 
                cidade_endereco = '$cidade', 
                bairro_endereco = '$bairro', 
                rua_endereco = '$rua',
                numero_endereco = '$numero',
                complemento_endereco = '$complemento', 
                cep_endereco = '$cep'

            WHERE 
                Tb_Instituicao_cnpj_instituicao = ".$cnpj;
        
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Endereço alterado com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}