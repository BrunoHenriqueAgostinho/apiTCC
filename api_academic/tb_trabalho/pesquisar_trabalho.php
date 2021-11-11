<?php
/*{
	"pesquisa": "B"
}*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conexao2 = new PDO("mysql:host=localhost:3306;dbname=academic", 'root', '');

    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;

    if($pesquisa != '' && $pesquisa != null){
        $sql1 = "SELECT 
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
            finalizado_trabalho = 1 AND nome_trabalho LIKE '%$pesquisa%'";

        $resultado1 = mysqli_query($conexao, $sql1); 
        if (mysqli_num_rows($resultado1) >= 1) { 
            $dados = $resultado1->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Nenhum resultado encontrado."]);
        }
    }
}
?>