<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $nome = $deco->nome;
    
    $sql = "SELECT 
                codigo_trabalho,
                nome_trabalho,
                descricao_trabalho,
                arquivo_trabalho,
                formatacao_trabalho,
                finalizado_trabalho,
                dtCriacao_trabalho,
                dtAlteracao_trabalho,
                dtPublicacao_trabalho,
                avaliacao_trabalho,
                Tb_Modelo_codigo_modelo,
                Tb_instituicao_cnpj_instituicao
            FROM 
                tb_trabalho
            WHERE 
                nome_trabalho like '%" . $nome . "%'";
    $resultado = mysqli_query($conexao, $sql); 
    if ($resultado) {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>