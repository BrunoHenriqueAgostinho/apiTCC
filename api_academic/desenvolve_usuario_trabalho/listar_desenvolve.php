<?php
/*
{
    "codigo":"1"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->cpf;

    $sql = "SELECT 
                T.codigo_trabalho as codigo,
                T.nome_trabalho as nome,
                T.descricao_trabalho as descricao,
                T.arquivo_trabalho as arquivo,
                T.formatacao_trabalho as formatacao,
                T.finalizado_trabalho as finalizado,
                T.dtCriacao_trabalho as dtCriacao,
                T.dtAlteracao_trabalho as dtAlteracao,
                T.dtPublicacao_trabalho as dtPublicacao,
                T.avaliacao_trabalho as avaliacao,
                T.Tb_Modelo_codigo_modelo as modelo,
                T.Tb_instituicao_cnpj_instituicao as cnpj 
            FROM
                tb_trabalho T, desenvolve_usuario_trabalho D
            WHERE
                D.Tb_Usuario_cpf_usuario = $codigo AND T.codigo_trabalho = D.Tb_Trabalho_codigo_trabalho
            ORDER BY T.dtCriacao_trabalho DESC";
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0){
        header("HTTP/1.1 500 Erro ao consultar banco");
        echo json_encode(["erro" => "Não foi possível consultar seus trabalhos."]);
    } else {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
/*
$sql1 = "SELECT 
                * 
            FROM 
                tb_trabalho
            WHERE 
                codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0){
        header("HTTP/1.1 500 Trabalho inexistente");
        echo json_encode(["erro" => "Não existe esse trabalho."]);
    } else {
        $sql2 = "SELECT 
                    * 
                FROM 
                    desenvolve_usuario_trabalho 
                WHERE 
                    Tb_Trabalho_codigo_trabalho = '$codigo' ORDER BY Tb_Usuario_cpf_usuario";
        $resultado2 = mysqli_query($conexao, $sql2);
        $contador2 = mysqli_num_rows($resultado2);
        if ($contador2 == 0) {
            header("HTTP/1.1 500 Sem membros");
            echo json_encode(["erro" => "O trabalho não apresenta membros."]);
        } else {
            $dados = $resultado2->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        }
    }
*/
?>