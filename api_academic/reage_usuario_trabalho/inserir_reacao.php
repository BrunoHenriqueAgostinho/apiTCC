<?php
/*
{
	"cpf": "33333333333",
	"codigo": 2
} 
*/

header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                *
            FROM 
                reage_usuario_trabalho
            WHERE 
                Tb_Usuario_cpf_usuario = '$cpf'
            AND
                Tb_Trabalho_codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        $sql2 = "INSERT INTO reage_usuario_trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho) VALUES
                    ('$cpf', $codigo)";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Reação inserido com sucesso."]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao inserir reação."]);
        }
    } else {
        header("HTTP/1.1 500 Registro já existente");
        echo json_encode(["erro" => "Essa reação já foi reagido."]);
    }
}
?>