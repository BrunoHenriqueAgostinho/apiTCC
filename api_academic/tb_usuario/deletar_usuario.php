<?php
/*
{
    "cpf": "11111111111"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql = "UPDATE Tb_Usuario SET contaStatus_usuario = 0 WHERE cpf_usuario = '$cpf'";
    $resultado = mysqli_query($conexao, $sql);
    echo json_encode(["mensagem" => "Usuário deletado com sucesso."]);
}
?>