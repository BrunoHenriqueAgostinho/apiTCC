<?php
/*
{
    "pesquisa": "Devisate"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;
    $pesquisa = '%' . $pesquisa . '%';
    
    $sql = $conexao2->prepare("SELECT * FROM tb_instituicao WHERE nome_instituicao like :pesquisa AND contaStatus_instituicao = 1");
    $sql->bindValue(':pesquisa', $pesquisa, PDO::PARAM_STR);
    $status = $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    $contador = count($resultado);
    if ($contador > 0){
        http_response_code(200);
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Sem retorno");
        echo json_encode(["erro" => "Nada foi encontrado."]);
    }
}
?>