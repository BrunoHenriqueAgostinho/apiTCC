<?php
/*{
    "cnpj": "22222222222222",
	"estado": "São Paulo",
    "cidade": "Marília",
    "bairro": "Somenzari",
    "rua": "Avenida Castro Alves",
    "numero": "62",
    "complemento": "",
    "cep": "17506000"
}*/

header('Content-Type: application/json');
//header("Access-Control-Allow-Origin: *");
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

    $sql1 = "SELECT 
                *
            FROM 
                tb_endereco
            WHERE 
                Tb_Instituicao_cnpj_instituicao = " . $cnpj;
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse endereço não existe."]);
    } else {
        $sql2 = "UPDATE 
                tb_endereco 
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
        
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Endereço alterado com sucesso"]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
        }
    }
}
?>