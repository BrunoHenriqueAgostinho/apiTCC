<?php
/*
{
    "cnpj": "55555555555"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;

    $sql = "UPDATE Tb_Instituicao SET contaStatus_instituicao = 0 WHERE cnpj_instituicao = '$cnpj'";
    $resultado = mysqli_query($conexao, $sql);
    echo json_encode(["mensagem" => "Instituição deletada com sucesso."]);
}
?>