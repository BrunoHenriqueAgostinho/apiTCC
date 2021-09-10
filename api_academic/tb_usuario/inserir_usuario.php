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
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $nome = $deco->nome;
    $senha = $deco->senha;
    $contato = $deco->contato;
    $dtCadastro = date('Y-m-d');
    
    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario 
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0){
        $sql2 = "INSERT INTO tb_usuario (cpf_usuario, nome_usuario, senha_usuario, dtCadastro_usuario, Tb_Contato_codigo_contato) VALUES
            ('$cpf', '$nome', '$senha', '$dtCadastro', '$contato')";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Usuário inserido com Sucesso."]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao inserir usuário."]);
        }
    } else {
        header("HTTP/1.1 500 Registro já existente");
        echo json_encode(["erro" => "Esse CPF já está sendo utilizado."]);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>