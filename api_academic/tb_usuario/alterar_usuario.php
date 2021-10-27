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
    $conexao = new PDO("mysql:host=localhost:3306;dbname=academic2", 'root', '');
    
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    $descricao = $deco->descricao;
    $foto = $deco->foto;
    $tema = $deco->tema;
    $status = $deco->status;
    $telefoneFixo = $deco->telefoneFixo;
    $telefoneCelular = $deco->telefoneCelular;

    $sql = $conexao->prepare("UPDATE tb_usuario SET nome_usuario = :nome, descricao_usuario = :descricao, foto_usuario = :foto, tema_usuario = :tema, status_usuario = :status, telefoneFixo_usuario = :telefoneFixo, telefoneCelular_usuario = :telefoneCelular WHERE cpf_usuario = :cpf");
    $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
    $sql->bindValue(':descricao', $descricao, PDO::PARAM_STR);
    $sql->bindValue(':foto', $foto, PDO::PARAM_STR);
    $sql->bindValue(':tema', $tema, PDO::PARAM_INT);
    $sql->bindValue(':status', $status, PDO::PARAM_INT);
    $sql->bindValue(':telefoneFixo', $telefoneFixo, PDO::PARAM_STR);
    $sql->bindValue(':telefoneCelular', $telefoneCelular, PDO::PARAM_STR);
    $sql->bindValue(':cpf', $cpf, PDO::PARAM_INT);
    $status = $sql->execute();

    if($status){
        http_response_code(200);
        $dados = ["mensagem" => "Dados do usuário alterado com sucesso."];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        $dados = ["erro"=> "Erro ao alterar dados do usuário."];
        echo json_encode($dados);
    }
}
?>