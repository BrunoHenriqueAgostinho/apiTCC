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
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    require("../validarCnpj.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $nome = $deco->nome;
    $senha_des = $deco->senha;
    $email = $deco->email;
    //$timezone = new DateTimeZone('America/Sao_Paulo');
    $dtCadastro = date('Y-m-d');//new date('now', $timezone);
    $senha = md5($senha_des);
    if(validar_cnpj($cnpj)){
        $sql1 = "SELECT
                    *
                FROM
                    tb_instituicao
                WHERE
                    cnpj_instituicao = '$cnpj'";
        $resultado1 = mysqli_query($conexao, $sql1);
        $contador1 = mysqli_num_rows($resultado1);
        if ($contador1 == 0) {
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
                        $sql4 = "SELECT codigo_contato
                                FROM    
                                    tb_contato
                                WHERE
                                    email_contato LIKE '$email'";
                        $resultado4 = mysqli_query($conexao, $sql4);
                        $dados = mysqli_fetch_array($resultado4);
                        $contato = $dados["codigo_contato"];
                        if($resultado4){
                            $sql5 = "INSERT INTO tb_instituicao(cnpj_instituicao, nome_instituicao, senha_instituicao, dtCadastro_instituicao, Tb_Contato_codigo_contato) VALUES
                            ('$cnpj', '$nome', '$senha', '$dtCadastro', '$contato')";
                            $resultado5 = mysqli_query($conexao,$sql5);
                            if($resultado5){
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
    }else{
        header("HTTP/1.1 500 Registro já existente");
        echo json_encode(["erro" => "CNPJ inexistente"]);
    }
}
?>
