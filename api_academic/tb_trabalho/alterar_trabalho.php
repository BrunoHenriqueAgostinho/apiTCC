<?php
/*
{
	"codigo": "3",
    "nome": "Trabalho",
    "descricao": "Descrição do Trabalho",
    "arquivo": "Arquivo do Trabalho",
    "formatacao": "Formatação do Trabalho",
	"finalizado": "0",
	"avaliacao": "5",
	"cnpj": "11111111111111"
}
*/

header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo =$deco->codigo;
    $nome = $deco->nome;
    $descricao = $deco->descricao;
    $arquivo = $deco->arquivo;
    $formatacao = $deco->formatacao;
    $finalizado = $deco->finalizado;
    $dtAlteracao = date('Y-m-d');
    $avaliacao = $deco->avaliacao;
    $cnpj = $deco->cnpj;
    
    $sql = "UPDATE tb_trabalho 
                SET 
                    nome_trabalho = '$nome',
                    descricao_trabalho = '$descricao',
                    arquivo_trabalho = '$arquivo',
                    formatacao_trabalho = '$formatacao',
                    finalizado_trabalho = $finalizado,
                    dtAlteracao_trabalho = '$dtAlteracao',
                    avaliacao_trabalho = $avaliacao,
                    Tb_Instituicao_cnpj_instituicao = '$cnpj'
                WHERE
                    codigo_trabalho = '$codigo'";

    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(200);
        $data = ["mensagem" => "Trabalho alterado com sucesso"];
        echo json_encode($data);
    } else {
        http_response_code(202);
        $data = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
        echo json_encode($data);
    }
}
?>