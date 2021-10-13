<?php
/*{
	"pesquisa": "B"
}*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);

    $sql1 = "SELECT 
                codigo_trabalho as codigo,
                nome_trabalho as nome,
                descricao_trabalho as descricao,
                arquivo_trabalho as arquivo,
                formatacao_trabalho as formatacao,
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
                finalizado_trabalho = 1";

    $resultado1 = mysqli_query($conexao, $sql1); 
    if ($resultado1) { 
        $dados = $resultado1->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        if ((json_encode($dados, JSON_UNESCAPED_UNICODE) == '[]')) {
            $data = ["mensagem" => "Não há trabalhos postados na plataforma"];
            echo json_encode($data);
        } else {
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        }
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>