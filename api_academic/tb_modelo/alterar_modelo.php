<?php

/*
    {
	    "cnpj":"11111111111111",
        "codigo": "3",
        "nome":"Resumo Expandido",
        "arquivo":"Título: Resumo: Palavras-Chave: Introdução: Objetivos: Relevância do estudo: Metodologia: Resultados: Conclusão: Referências:",
        "formatacao":"8pt",
        "dtCriacao":"2021-08-18",
        "descricao":"Modelo para o TCC do 3°ETIM DS"
    }
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $codigo = $deco->codigo;
    $nome = $deco->nome;
    $arquivo = $deco->arquivo;
    $formatacao = $deco->formatacao;
    $dtCriacao = $deco->dtCriacao;
    $descricao = $deco->descricao;

$sql = "UPDATE tb_modelo 
        SET  
            Tb_Instituicao_cnpj_instituicao =  '$cnpj',
            nome_modelo = '$nome', 
            arquivo_modelo = '$arquivo', 
            formatacao_modelo = '$formatacao', 
            dtCriacao_modelo = '$dtCriacao',
            descricao_modelo = '$descricao'

        WHERE 
            codigo_modelo = ".$codigo;

    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Modelo alterado com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}
?>