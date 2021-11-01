<?php
header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql = "SELECT 
                codigo_trabalho as codigo,
                nome_trabalho as nome,
                descricao_trabalho as descricao,
                arquivo_trabalho as arquivo,
                margemDireita_trabalho as margemDireita,
                margemEsquerda_trabalho as margemEsquerda,
                margemTopo_trabalho as margemTopo,
                margemBaixo_trabalho as margemBaixo,
                finalizado_trabalho as finalizado,
                dtCriacao_trabalho as dtCriacao,
                dtAlteracao_trabalho as dtAlteracao,
                dtPublicacao_trabalho as dtPublicacao,
                avaliacao_trabalho as avaliacao,
                Tb_Modelo_codigo_modelo as modelo,
                Tb_instituicao_cnpj_instituicao as cnpj
            FROM 
                tb_trabalho
            WHERE 
                codigo_trabalho = $codigo";
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar usuário."]);
    } else {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
?>