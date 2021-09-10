<?php
/*{
    "nome": "",
    "descricao": "",
    "arquivo": "",
    "formatacao": "",
    "finalizado": "",
    "dtPublicacao": "",
    "avaliacao": "",
    "modelo": "",
    "cnpj": "" 
}*/

header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $nome = $deco->nome;
    $descricao = $deco->descricao;
    $arquivo = $deco->arquivo;
    $formatacao = $deco->formatacao;
    $dtCriacao = date('Y-m-d');
    $dtAlteracao = date('Y-m-d');
    $modelo = $deco->modelo;

    $sql = "INSERT INTO tb_trabalho 
                (nome_trabalho,descricao_trabalho,arquivo_trabalho,formatacao_trabalho,finalizado_trabalho,dtCriacao_trabalho,dtAlteracao_trabalho,dtPublicacao_trabalho, avaliacao_trabalho, Tb_Modelo_codigo_modelo,Tb_Instituicao_cnpj_instituicao) 
            VALUES
                ('$nome','$descricao','$arquivo','$formatacao',0,'$dtCriacao','$dtAlteracao',null,null,$modelo,null)";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Trabalho inserido com sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}else{
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>