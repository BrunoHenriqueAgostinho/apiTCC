<?php

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;

    $sql1 = "SELECT * FROM tb_instituicao WHERE nome_instituicao like '%$pesquisa%'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    if ($contador1 == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Não encontramos essa instituição."]);
    } else {
        $dados1 = mysqli_fetch_array($resultado1);
        $codigo = $dados1["cnpj_instituicao"];

        $sql2 = "SELECT codigo_modelo as codigo, nome_modelo as nome, arquivo_modelo as arquivo, margemDireita_modelo as margemDireita, margemEsquerda_modelo as margemEsquerda, margemTopo_modelo as margemTopo, margemBaixo_modelo as margemBaixo, dtCriacao_modelo as dtCriacao, descricao_modelo as descricao, Tb_instituicao_cnpj_instituicao as cnpj 
                FROM 
                    tb_modelo 
                WHERE
                Tb_Instituicao_cnpj_instituicao LIKE '%$codigo%'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            $dados2 = $resultado2->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados2, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao listar modelos."]);
        }
        
    }
} 
?>