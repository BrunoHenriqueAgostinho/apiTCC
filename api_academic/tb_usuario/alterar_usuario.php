<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
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

    $sql = "UPDATE tb_usuario 
                SET 
                    nome_usuario = '$nome',
                    senha_usuario = '$senha',
                    descricao_usuario = '$descricao',
                    foto_usuario = '$foto',
                    tema_usuario = $tema,
                    status_usuario = $status
                WHERE
                    cpf_usuario = '$cpf'";
    $resultado = mysqli_query($conexao, $sql);
    if($resultado){
        http_response_code(200);
        $data = ["mensagem" => "Usuário alterado com sucesso"];
        echo json_encode($data);
    } else {
        http_response_code(202);
        $data = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
        echo json_encode($data);
    }
}
?>