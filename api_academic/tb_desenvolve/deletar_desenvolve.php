<?php
/*
{
	"cpf":"11111111111",
    "codigo":"1"
}
*/
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql = "SET foreign_key_checks = 0";
    $resultado = mysqli_query($conexao, $sql);

    $sql = "DELETE FROM desenvolve_usuario_trabalho WHERE Tb_Usuario_cpf_usuario = '$cpf' AND Tb_Trabalho_codigo_trabalho = '$codigo'";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado) {
        http_response_code(200);
        $dados = ["mensagem" => "Modelo deletado com sucesso"];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }

    $sql = "SET foreign_key_checks = 1";
    $resultado = mysqli_query($conexao, $sql);
}
?>