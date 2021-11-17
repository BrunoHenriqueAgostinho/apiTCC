<?php

header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $email = $deco->email;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);

    $sql1 = $conexao2->prepare("SELECT cpf_usuario, email_usuario, senha_usuario FROM Tb_Usuario WHERE email_usuario = :email AND senha_usuario = :senha");
    $sql1->bindValue(':email', $email, PDO::PARAM_STR);
    $sql1->bindValue(':senha', $senha, PDO::PARAM_STR);
    $sql1->execute();
    $resultado1 = $sql1->fetch(PDO::FETCH_ASSOC);
    //print_r($resultado1);
    if (empty($resultado1)){
        $sql2 = $conexao2->prepare("SELECT cnpj_instituicao, email_instituicao, senha_instituicao FROM Tb_Instituicao WHERE email_instituicao = :email AND senha_instituicao = :senha");
        $sql2->bindValue(':email', $email, PDO::PARAM_STR);
        $sql2->bindValue(':senha', $senha, PDO::PARAM_STR);
        $sql2->execute();
        $resultado2 = $sql2->fetch(PDO::FETCH_ASSOC);
        if(empty($resultado2)){
            header("HTTP/1.1 500 Erro no Login");
            echo json_encode(["erro" => "Email ou senha inválidos."]);
        } else {
            http_response_code(200);
            echo json_encode(["codigo"=> $resultado2["cnpj_instituicao"]]);
        }
    } else {
        http_response_code(200);
        echo json_encode(["codigo"=> $resultado1["cpf_usuario"]]);
    }
}
/*
header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conexao2 = new PDO("mysql:host=localhost:3306;dbname=academic2", 'root', '');
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $email = $deco->email;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    
    $sql1 = $conexao2->prepare("SELECT codigo_contato FROM tb_contato WHERE email_contato LIKE :email");
    $sql1->bindValue(':email', $email, PDO::PARAM_STR);
    $sql1->execute();
    $resultado1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
    $contador1 = count($resultado1);
    if($contador1 == 0){
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Registro não existente."]);
    }else{
        $contato = $resultado1["0"]["codigo_contato"];
        $sql2 = $conexao2->prepare("SELECT cnpj_instituicao FROM tb_instituicao WHERE Tb_Contato_codigo_contato = :contato AND senha_instituicao LIKE :senha");
        $sql2->bindValue(':contato', $contato, PDO::PARAM_INT);
        $sql2->bindValue(':senha', $senha, PDO::PARAM_STR);
        $sql2->execute();
        $resultado2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
        $contador2 = count($resultado2);
        if($contador2 == 0){
            $sql3 = $conexao2->prepare("SELECT cpf_usuario FROM tb_usuario WHERE Tb_Contato_codigo_contato = :contato AND senha_usuario LIKE :senha");
            $sql3->bindValue(':contato', $contato, PDO::PARAM_INT);
            $sql3->bindValue(':senha', $senha, PDO::PARAM_STR);
            $sql3->execute();
            $resultado3 = $sql3->fetchAll(PDO::FETCH_ASSOC);
            $contador3 = count($resultado3);
            if($contador3 == 0){
                header("HTTP/1.1 500 Erro no SQL");
                echo json_encode(["erro" => "Senha incorreta."]);
            }else{
                $usuario = $resultado3["0"]["cpf_usuario"];
                http_response_code(200);
                echo json_encode(["codigo"=>"$usuario"]);
            }
        }else{
            $instituicao = $resultado2["0"]["cnpj_instituicao"];
            http_response_code(200);
            echo json_encode(["codigo"=>"$instituicao"]);
        }

    }
    
}
*/
?>