<?php
/*
{
    "cnpj": "55555555555",
    "nome": "Escola Santa Antonieta",
    "logotipo": null,
    "senha" : "1212121"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    $logotipo = $deco->logotipo;

    $sql1 = "SELECT
                *
            FROM
                tb_instituicao
            WHERE
                cnpj_instituicao = '$cnpj'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Essa instituição não existe."]);
    } else {
        $sql2 = "UPDATE tb_instituicao 
                SET 
                    nome_instituicao = '$nome',
                    logotipo_instituicao = '$logotipo',
                    senha_instituicao = '$senha'
                WHERE
                    cnpj_instituicao = '$cnpj'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if($resultado2){
            http_response_code(200);
            $data = ["mensagem" => "Instituição alterada com sucesso."];
            echo json_encode($data);
        } else {
            http_response_code(202);
            $data = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
            echo json_encode($data);
        }
    }
}
?>