<?php
/*{
    "cnpj": "66666666666666",
    "logotipo": "POPO",
    "senha" : "1212121"
}*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $senha = $deco->senha;
    $logotipo = $deco->logotipo;

    $sql = "UPDATE tb_instituicao 
                SET 
                    logotipo_instituicao = '$logotipo',
                    senha_instituicao = '$senha'
                WHERE
                    cnpj_instituicao = '$cnpj'";

    $resultado = mysqli_query($conexao, $sql);
    if($resultado){
        http_response_code(200);
        $data = ["mensagem" => "Instituição alterada com sucesso"];
        echo json_encode($data);
    } else {
        http_response_code(202);
        $data = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
        echo json_encode($data);
    }
}
?>