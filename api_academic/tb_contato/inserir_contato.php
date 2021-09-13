<?php
/*
{
	"email": "emailaleatorio@gmail.com",
	"telefoneFixo": "12345",
	"telefoneCelular": "54321"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $email = $deco->email;
    $telefoneFixo = $deco->telefoneFixo;
    $telefoneCelular = $deco->telefoneCelular;

    $sql1 = "SELECT 
                *
            FROM 
                tb_contato 
            WHERE 
                email_contato = '$email'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0){
        $sql2 = "INSERT INTO tb_contato (email_contato, telefoneFixo_contato, telefoneCelular_contato) VALUES
                    ('$email', '$telefoneFixo', '$telefoneCelular')";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Contato inserido com Sucesso"]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao inserir contato"]);
        }
    } else {
        header("HTTP/1.1 500 Registro já existente");
        echo json_encode(["erro" => "Esse email já foi utilizado."]);
    }
}
?>