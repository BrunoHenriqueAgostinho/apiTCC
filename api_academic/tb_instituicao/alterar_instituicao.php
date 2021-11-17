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
    $logotipo = $deco->logotipo;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    $telefoneFixo = $deco->telefoneFixo;
    $telefoneCelular = $deco->telefoneCelular;
    $cidade = $deco->cidade;

    $sql = $conexao2->prepare("UPDATE Tb_Instituicao SET nome_instituicao = :nome, senha_instituicao = :senha, logotipo_instituicao = :logotipo, telefoneFixo_instituicao = :telefoneFixo, telefoneCelular_instituicao = :telefoneCelular, cidade_instituicao = :cidade WHERE cnpj_instituicao = :cnpj");
    $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
    $sql->bindValue(':senha', $senha, PDO::PARAM_STR);
    $sql->bindValue(':logotipo', $logotipo, PDO::PARAM_STR);
    $sql->bindValue(':telefoneFixo', $telefoneFixo, PDO::PARAM_STR);
    $sql->bindValue(':telefoneCelular', $telefoneCelular, PDO::PARAM_STR);
    $sql->bindValue(':cidade', $cidade, PDO::PARAM_STR);
    $sql->bindValue(':cnpj', $cnpj, PDO::PARAM_INT);
    $status = $sql->execute();

    if($status){
        http_response_code(200);
        $dados = ["mensagem" => "Dados da instituição alterados com sucesso."];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        //Erro ao alterar dados da instituição
        $dados = ["erro"=> "Houve um problema ao alterar as informações da instituição"];
        echo json_encode($dados);
    }
}
?>