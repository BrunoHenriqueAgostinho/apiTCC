<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    $telefoneFixo = $deco->telefoneFixo;
    $telefoneCelular = $deco->telefoneCelular;

    $sql = "UPDATE tb_contato 
                SET 
                    telefoneFixo_contato = '$telefoneFixo',
                    telefoneCelular_contato = '$telefoneCelular'
                WHERE
                    codigo_contato = '$codigo'";
    $resultado = mysqli_query($conexao, $sql);
    if($resultado){
        http_response_code(200);
        $data = ["mensagem" => "Contato alterado com sucesso"];
        echo json_encode($data);
    } else {
        http_response_code(202);
        $data = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
        echo json_encode($data);
    }
}
?>