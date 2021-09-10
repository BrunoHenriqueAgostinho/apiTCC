<?php
/*
{
	"cpf":"11111111111",
    "codigo":"1"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                * 
            FROM 
                desenvolve_usuario_trabalho
            WHERE 
                Tb_Usuario_cpf_usuario = '$cpf'
            AND
                Tb_Trabalho_codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    if ($contador1 == 0){
        header("HTTP/1.1 201 Relação de desenvolvimento inexistente");
        echo json_encode(["erro" => "Não existe essa relação de desenvolvimento."]);
    } else {
        $sql2 = "DELETE FROM desenvolve_usuario_trabalho WHERE Tb_Usuario_cpf_usuario = '$cpf' AND Tb_Trabalho_codigo_trabalho = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Relação de desenvolvimento deletado com sucesso."];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao deletar relação de desenvolvimento."]);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>