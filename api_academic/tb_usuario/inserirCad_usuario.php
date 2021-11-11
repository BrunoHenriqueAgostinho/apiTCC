<?php
/*
{
    "cpf": "55555455555",
    "nome": "Clebsvaldo",
    "senha": "abcdefghijk",
    "email": "cleberstatroll@troll.com"
}
*/

header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conexao2 = new PDO("mysql:host=localhost:3306;dbname=academic", 'root', '');
    
    require("../validaCpf.php");

    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    $email = $deco->email;
    $dtCadastro = date('Y-m-d');

    if(validaCPF($cpf)){
        $sql1 = $conexao->prepare("SELECT * FROM tb_usuario WHERE email_usuario = :email");
        $sql1->bindValue(':email', $email, PDO::PARAM_STR);
        $sql1->execute();
        $resultado1 = $sql1->fetch(PDO::FETCH_ASSOC);
        $sql2 = $conexao->prepare("SELECT * FROM tb_instituicao WHERE email_instituicao = :email");
        $sql2->bindValue(':email', $email, PDO::PARAM_STR);
        $sql2->execute();
        $resultado2 = $sql2->fetch(PDO::FETCH_ASSOC);
        if(empty($resultado1) && empty($resultado2)){
            try {
                $sql = $conexao->prepare("INSERT INTO tb_usuario(cpf_usuario, nome_usuario, senha_usuario, dtCadastro_usuario, email_usuario) VALUES
                    (:cpf, :nome, :senha, '$dtCadastro', :email)");
                $sql->bindValue(':cpf', $cpf, PDO::PARAM_INT);
                $sql->bindValue(':nome', $nome, PDO::PARAM_STR);
                $sql->bindValue(':senha', $senha, PDO::PARAM_STR);
                $sql->bindValue(':email', $email, PDO::PARAM_STR);
                $status = $sql->execute();
                http_response_code(201);
                echo json_encode(["mensagem" => "Usuário cadastrado com sucesso."]);
                
            } catch (PDOException $e){
                header("HTTP/1.1 500 Erro no SQL");
                echo json_encode(["erro" => "Não foi possível realizar o cadastro do usuário."]);
            }
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Não foi possível realizar o cadastro do usuário."]);
        }
    }else{
        header("HTTP/1.1 500 CPF inválido");
        echo json_encode(["erro" => "CPF inválido."]);
    }
}

/*
header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conexao2 = new PDO("mysql:host=localhost:3306;dbname=academic2", 'root', '');
    
    require("../validaCpf.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    $email = $deco->email;
    $dtCadastro = date('Y-m-d');
    if(validaCPF($cpf)){
        $sql1 = $conexao->prepare("SELECT * FROM tb_usuario WHERE cpf_usuario = :cpf");
        $sql1->bindValue(':cpf', $cpf, PDO::PARAM_INT);
        $sql1->execute();
        $resultado1 = $sql1->fetchAll(PDO::FETCH_ASSOC);
        $contador1 = count($resultado1);
        if ($contador1 == 0){
            $sql2 = $conexao->prepare("SELECT * FROM tb_contato WHERE email_contato = :email");
            $sql2->bindValue(':email', $email, PDO::PARAM_STR);
            $sql2->execute();
            $resultado2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
            $contador2 = count($resultado2);
            if($contador2 == 0){
                $sql3 = $conexao->prepare("INSERT INTO tb_contato (email_contato) VALUES (:email)");
                $sql3->bindValue(':email', $email, PDO::PARAM_STR);
                $sql3->execute();
                if($sql3){
                    $sql4 = $conexao->prepare("SELECT codigo_contato FROM tb_contato WHERE email_contato LIKE :email");
                    $sql4->bindValue(':email', $email, PDO::PARAM_STR);
                    $sql4->execute();
                    if($sql4){
                        $resultado4 = $sql4->fetch(PDO::FETCH_ASSOC);
                        $contato = $resultado4["codigo_contato"];
                        $sql5 = $conexao->prepare("INSERT INTO tb_usuario (cpf_usuario, nome_usuario, senha_usuario, dtCadastro_usuario, Tb_Contato_codigo_contato) VALUES
                                    (:cpf, :nome, :senha, '$dtCadastro', :contato)");
                        $sql5->bindValue(':cpf', $cpf, PDO::PARAM_INT);
                        $sql5->bindValue(':nome', $nome, PDO::PARAM_STR);
                        $sql5->bindValue(':senha', $senha, PDO::PARAM_STR);
                        $sql5->bindValue(':contato', $contato, PDO::PARAM_INT);
                        $sql5->execute();
                        if($sql5){
                            http_response_code(201);
                            echo json_encode(["mensagem" => "Usuário cadastrado com sucesso."]);
                        }else{
                            header("HTTP/1.1 500 Erro no SQL");
                            echo json_encode(["erro" => "Erro ao cadastrar usuário."]);
                        }
                    }else{
                        header("HTTP/1.1 500 Erro de inserção");
                        echo json_encode(["erro" => "Erro ao encontrar o contato do usuario."]); 
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
            echo json_encode(["erro" => "Esse CPF já está sendo utilizado."]);
        }
    }else{
        header("HTTP/1.1 500 CPF inválido");
        echo json_encode(["erro" => "CPF inválido."]);
    }
}
*/
?>
