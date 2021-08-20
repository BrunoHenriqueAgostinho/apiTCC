<?php
/*
{
    "cpf": "55555555555",
    "nome": "Clebsvaldo",
    "senha": "abcdefghijk",
    "contato": "3"
}
*/
header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $nome = $deco->nome;
    $senha = $deco->senha;
    $contato = $deco->contato;
    //$timezone = new DateTimeZone('America/Sao_Paulo');
    $dtCadastro = date('Y-m-d');//new date('now', $timezone);

    $comando = "insert into tb_usuario (cpf_usuario, nome_usuario, senha_usuario, dtCadastro_usuario, Tb_Contato_codigo_contato) values
    ('$cpf', '$nome', '$senha', '$dtCadastro', '$contato')";
    $resultado = mysqli_query($conexao, $comando);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Usuário inserido com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}
?>