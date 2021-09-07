<?php
/*
{
	"cpf":"44444444444",
	"codigo":"1",
	"cargo":"1"
}
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;
    $cargo = $deco->cargo;

    $sql1 = "SELECT 
                * 
            FROM 
                tb_usuario 
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    $sql2 = "SELECT 
                * 
            FROM 
                tb_trabalho 
            WHERE 
                codigo_trabalho = $codigo";
    $resultado2 = mysqli_query($conexao, $sql2);
    $contador2 = mysqli_num_rows($resultado2);

    if ($contador1 == 0){
        header("HTTP/1.1 500 Usuário Inexistente");
        echo json_encode(["erro" => "Esse usuário não existe."]);
    } else {
        if ($contador2 == 0){
            header("HTTP/1.1 500 Trabalho Inexistente");
            echo json_encode(["erro" => "Esse trabalho não existe."]);
        } else {
            $sql3 = "INSERT INTO desenvolve_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho, cargo_usuario) VALUES
                    ('$cpf', $codigo, $cargo)";
            $resultado3 = mysqli_query($conexao, $sql3);
            if ($resultado3) {
                http_response_code(201);
                echo json_encode(["mensagem" => "Relação de desenvolvimento inserida com sucesso."]);
            } else {
                header("HTTP/1.1 500 Erro no SQL");
                echo json_encode(["erro" => "Erro ao inserir relação de desenvolvimento."]);
            }
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>