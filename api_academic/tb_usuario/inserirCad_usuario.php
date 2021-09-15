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
    require("../conexao.php");
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
        $sql1 = "SELECT 
                    *
                FROM 
                    tb_usuario 
                WHERE 
                    cpf_usuario = '$cpf'";
        $resultado1 = mysqli_query($conexao, $sql1);
        $contador = mysqli_num_rows($resultado1);
        if ($contador == 0){
            $sql2 = "SELECT 
                    *
                FROM 
                    tb_contato 
                WHERE 
                    email_contato = '$email'";

            $resultado2 = mysqli_query($conexao, $sql2);
            $contador2 = mysqli_num_rows($resultado2);

            if($contador2 == 0){
                $sql3 = "INSERT INTO tb_contato (email_contato) VALUES 
                            ('$email')";
                $resultado3 = mysqli_query($conexao, $sql3);
                if($resultado3){
                    $sql4 = "SELECT 
                                codigo_contato
                            FROM 
                                tb_contato
                            WHERE
                                email_contato LIKE '$email'";
                    $resultado4 = mysqli_query($conexao, $sql4);

                    if($resultado4){
                        $dados = mysqli_fetch_array($resultado4);
                        $contato = $dados["codigo_contato"];
                        $sql5 = "INSERT INTO tb_usuario (cpf_usuario, nome_usuario, senha_usuario, dtCadastro_usuario, Tb_Contato_codigo_contato) VALUES
                                    ('$cpf', '$nome', '$senha', '$dtCadastro', '$contato')";
                        $resultado5 = mysqli_query($conexao, $sql5);
                        if($resultado5){
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
        header("HTTP/1.1 500 CPF inexistente");
        echo json_encode(["erro" => "CPF inexistente"]);
    }
}
?>
