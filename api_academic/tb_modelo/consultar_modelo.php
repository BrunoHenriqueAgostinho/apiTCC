<?php
/*
{
    "cpf": "11111111111"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql = "SELECT 
                codigo_modelo as codigo, 
                nome_modelo as nome, 
                arquivo_modelo as arquivo, 
                margemDireita_modelo as margemDireita, 
                margemEsquerda_modelo as margemEsquerda, 
                margemTopo_modelo as margemTopo, 
                margemBaixo_modelo as margemBaixo, 
                dtCriacao_modelo as dtCriacao, 
                descricao_modelo as descricao, 
                Tb_instituicao_cnpj_instituicao as cnpj 
            FROM 
                Tb_Modelo 
            WHERE 
                codigo_modelo = $codigo";

    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar modelo."]);
    } else {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
?>