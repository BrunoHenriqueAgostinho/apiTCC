<?php
/*
{
    "cnpj": "55555555555",
    "nome": "Santa Antonieta Scholl",
    "logotipo": "",
    "contato": "3",
    "senha" : "1212121"
}
*/

header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $nome = $deco->nome;
    $logotipo = $deco->logotipo;
    $senha = $deco->senha;
    $contato = $deco->contato;
    //$timezone = new DateTimeZone('America/Sao_Paulo');
    $dtCadastro = date('Y-m-d');//new date('now', $timezone);

    $sql1 = "SELECT
                *
            FROM
                tb_instituicao
            WHERE
                cnpj_instituicao = '$cnpj'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0) {
        $sql2 = "INSERT INTO tb_instituicao(cnpj_instituicao, nome_instituicao, logotipo_instituicao, senha_instituicao, dtCadastro_instituicao, Tb_Contato_codigo_contato) VALUES
                    ('$cnpj', '$nome','$logotipo', '$senha', '$dtCadastro', '$contato')";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Instituição inserida com sucesso."]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao Inserir instituição."]);
        }
    } else {
        header("HTTP/1.1 500 Registro já existente");
        echo json_encode(["erro" => "Esse CNPJ já está sendo utilizado."]);
    }
}
?>