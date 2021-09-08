<?php
/*
{
    "cpf": "11111111111"
}
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario 
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if($contador == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse usuário não existe."]);
    } else {

        $permisaoDeletar = "SET foreign_key_checks = 0";
        $resultado2 = mysqli_query($conexao, $permisaoDeletar);

        $sql2 = "DELETE FROM 
                    tb_usuario 
                WHERE cpf_usuario = " . $cpf;
        $resultado3 = mysqli_query($conexao, $sql2);
        if ($resultado3) {
            http_response_code(200);
            $dados = ["mensagem" => "Usuário deletado com sucesso"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
        }

        $habilitarDeletar = "SET foreign_key_checks = 1";
        $resultado4 = mysqli_query($conexao, $habilitarDeletar);
    }
}
?>