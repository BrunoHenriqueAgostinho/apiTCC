<?php
/*
{
    "cpf": "11111111111",
    "nome": "Bruno Henrique Agostinho da Silva",
    "senha": "123456789",
    "descricao": "Olá, meu nome é Bruno",
    "foto": null,
    "tema": 1,
    "status": 1
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $nome = $deco->nome;
    $senha = $deco->senha;
    $descricao = $deco->descricao;
    $foto = $deco->foto;
    $tema = $deco->tema;
    $status = $deco->status;

    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario 
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if($contador == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse usuário não existe."]);
    } else {
        $sql2 = "UPDATE tb_usuario 
                    SET 
                        nome_usuario = '$nome',
                        senha_usuario = '$senha',
                        descricao_usuario = '$descricao',
                        foto_usuario = '$foto',
                        tema_usuario = $tema,
                        status_usuario = $status
                    WHERE
                        cpf_usuario = '$cpf'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if($resultado2){
            http_response_code(200);
            $dados = ["mensagem" => "Usuário alterado com sucesso"];
            echo json_encode($dados);
        } else {
            http_response_code(202);
            $dados = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
            echo json_encode($dados);
        }
    }
}
?>