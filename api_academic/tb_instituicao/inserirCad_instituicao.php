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
    //$conexao2 = new PDO("mysql:host=localhost:3306;dbname=academic", 'root', '');

    require("../validarCnpj.php");

    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    $email = $deco->email;
    $dtCadastro = date('Y-m-d');
    
    if(validar_cnpj($cnpj)){
        $sql1 = $conexao2->prepare("SELECT * FROM tb_usuario WHERE email_usuario = :email");
        $sql1->bindValue(':email', $email, PDO::PARAM_STR);
        $sql1->execute();
        $resultado1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $sql2 = $conexao2->prepare("SELECT * FROM tb_instituicao WHERE email_instituicao = :email");
        $sql2->bindValue(':email', $email, PDO::PARAM_STR);
        $sql2->execute();
        $resultado2 = $sql2->fetch(PDO::FETCH_ASSOC);
        if(empty($resultado1) && empty($resultado2)){
            try {
                $sql = $conexao2->prepare("INSERT INTO tb_instituicao(cnpj_instituicao, nome_instituicao, senha_instituicao, dtCadastro_instituicao, email_instituicao) VALUES
                    (:cnpj, :nome, :senha, '$dtCadastro', :email)");
                $sql->bindValue(':cnpj', $cnpj, PDO::PARAM_INT);
                $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
                $sql->bindValue(':senha', $senha, PDO::PARAM_STR);
                $sql->bindValue(':email', $email, PDO::PARAM_STR);
                $status = $sql->execute();
                http_response_code(201);
                echo json_encode(["mensagem" => "Instituição cadastrada com sucesso."]);
            } catch (PDOException $e){
                header("HTTP/1.1 500 Erro no SQL");
                echo json_encode(["erro" => "Não foi possível realizar o cadastro da instituição."]);
            }
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Não foi possível realizar o cadastro da instituição."]);
        }
    } else{
        header("HTTP/1.1 500 CNPJ inválido");
        echo json_encode(["erro" => "CNPJ inválido."]);
    }
}
/*
header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conexao2 = new PDO("mysql:host=localhost:3306;dbname=academic2", 'root', '');

    require("../validarCnpj.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $email = $deco->email;
    $dtCadastro = date('Y-m-d');
    $senha = md5($senha_des);
    if(validar_cnpj($cnpj)){
        $sql1 = $conexao2->prepare("SELECT * FROM tb_instituicao WHERE cnpj_instituicao = :cnpj");
        $sql1->bindValue(':cnpj', $cnpj, PDO::PARAM_INT);
        $sql1->execute();
        $resultado1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
        $contador1 = count($resultado1);
        if ($contador1 == 0) {
            $sql2 = $conexao2->prepare("SELECT * FROM tb_contato WHERE email_contato = :email");
            $sql2->bindValue(':email', $email, PDO::PARAM_STR);
            $sql2->execute();
            $resultado2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
            $contador2 = count($resultado2);
            if($contador2 == 0){
                $sql3 = $conexao2->prepare("INSERT INTO tb_contato (email_contato) VALUES (:email)");
                $sql3->bindValue(':email', $email, PDO::PARAM_STR);
                $sql3->execute();
                if($sql3){
                    $sql4 = $conexao2->prepare("SELECT codigo_contato FROM tb_contato WHERE email_contato LIKE :email");
                    $sql4->bindValue(':email', $email, PDO::PARAM_STR);
                    $sql4->execute();
                    if($sql4){
                        $resultado4 = $sql4->fetch(PDO::FETCH_ASSOC);
                        $contato = $resultado4["codigo_contato"];
                        $sql5 = $conexao2->prepare("INSERT INTO tb_instituicao(cnpj_instituicao, nome_instituicao, senha_instituicao, dtCadastro_instituicao, Tb_Contato_codigo_contato) VALUES (:cnpj, :nome, :senha, '$dtCadastro', :contato)");
                        $sql5->bindValue(':cnpj', $cnpj, PDO::PARAM_INT);
                        $sql5->bindValue(':nome', $nome, PDO::PARAM_STR);
                        $sql5->bindValue(':senha', $senha, PDO::PARAM_STR);
                        $sql5->bindValue(':contato', $contato, PDO::PARAM_INT);
                        $sql5->execute();
                        if($sql5){
                            http_response_code(201);
                            echo json_encode(["mensagem" => "Instituição cadastrada com sucesso."]);
                        }else{
                            header("HTTP/1.1 500 Erro no SQL");
                            echo json_encode(["erro" => "Erro ao cadastrar instituição."]);
                        }
                    }else{
                        header("HTTP/1.1 500 Erro de inserção");
                        echo json_encode(["erro" => "Erro ao encontrar o contato da instituição."]); 
                    }
                }else{
                    header("HTTP/1.1 500 Erro de inserção");
                    echo json_encode(["erro" => "Erro ao cadastrar o email."]);
                }
            }else{
                header("HTTP/1.1 500 Registro já existente");
                echo json_encode(["erro" => "Esse email já está sendo utilizado por outra pessoa."]);
            }
        } else {
            header("HTTP/1.1 500 Registro já existente");
            echo json_encode(["erro" => "Esse CNPJ já está sendo utilizado."]);
        }
    } else {
        header("HTTP/1.1 500 CNPJ inválido");
        echo json_encode(["erro" => "CNPJ inválido."]);
    }
}
*/
?>
