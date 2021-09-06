<?php
/*
    {
	    "cnpj":"11111111111111",
        "nome":"Resumo Expandido",
        "arquivo":"Título: Resumo: Palavras-Chave: Introdução: Objetivos: Relevância do estudo: Metodologia: Resultados: Conclusão: Referências:",
        "formatacao":"8pt",
        "descricao":"Modelo para o TCC do 3°ETIM DS"
    }
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $nome = $deco->nome;
    $arquivo = $deco->arquivo;
    $formatacao = $deco->formatacao;
    $dtCriacao = date('Y-m-d');
    $descricao = $deco->descricao;

    $sql = "INSERT INTO tb_modelo (Tb_Instituicao_cnpj_instituicao, nome_modelo, arquivo_modelo, formatacao_modelo, dtCriacao_modelo, descricao_modelo) VALUES
                ('$cnpj','$nome','$arquivo','$formatacao','$dtCriacao','$descricao')";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Modelo inserido com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao inserir modelo."]);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>
