<?php
/*
    {
	    "cpf":"11111111111",
        "codigo":"1",
        "cargo":"0"
    }
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;
    $cargo = $deco->cargo;

$sql = "UPDATE desenvolve_usuario_trabalho 
        SET  
            cargo_usuario =  '$cargo'

        WHERE 
            Tb_Usuario_cpf_usuario = '$cpf'
        AND
            Tb_Trabalho_codigo_trabalho = '$codigo'";

    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Relação de desenvolvimento alterado com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao alterar " . $conexao->error]);
    }
}
?>