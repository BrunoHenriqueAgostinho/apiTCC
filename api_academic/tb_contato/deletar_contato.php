<?php
/*
{
	"codigo": ""
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                *
            FROM 
                tb_contato
            WHERE 
                codigo_contato = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 201 Contato inexistente");
        echo json_encode(["erro" => "Não existe esse contato."]);
    } else {
        $sql2 = "DELETE FROM tb_contato WHERE codigo_contato = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Contato deletado com sucesso"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao deletar contato."]);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>