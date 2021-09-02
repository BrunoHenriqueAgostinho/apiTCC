<?php
/*
{
	"cpf_seguidor": "44444444444",
	"cpf_seguido": "33333333333"
}
*/

header("Content-Type: application/json");
header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf_seguidor = $deco->cpf_seguidor;
    $cpf_seguido = $deco->cpf_seguido;

    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario
            WHERE 
                cpf_usuario = '$cpf_seguidor'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    $sql2 = "SELECT 
                *
            FROM 
                tb_usuario
            WHERE 
                cpf_usuario = '$cpf_seguido'";
    $resultado2 = mysqli_query($conexao, $sql2);
    $contador2 = mysqli_num_rows($resultado2);

    if ($contador1 == 0 || $contador2 == 0){
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar usuários."]);
    } else {
        $sql3 = "INSERT INTO adiciona_usuario_usuario (seguidor_usuario, seguido_usuario) VALUES
                    ('$cpf_seguidor', '$cpf_seguido')";
        $resultado3 = mysqli_query($conexao, $sql3);
        if ($resultado3) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Amigo inserido com sucesso."]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao inserir amigo."]);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>