<?php
/*
{
	"cpf":"11111111111",
    "codigo":"1"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                * 
            FROM 
                Desenvolve_Usuario_Trabalho
            WHERE 
                Tb_Usuario_cpf_usuario = '$cpf'
            AND
                Tb_Trabalho_codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    if ($contador1 == 0){
        header("HTTP/1.1 500 Relação de desenvolvimento inexistente");
        //Não existe essa relação de desenvolvimento
        echo json_encode(["erro" => "Houve um problema ao retirar o integrante do trabalho"]);
    } else {
        $sql2 = "DELETE FROM Desenvolve_Usuario_Trabalho WHERE Tb_Usuario_cpf_usuario = '$cpf' AND Tb_Trabalho_codigo_trabalho = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Relação de desenvolvimento deletado com sucesso."];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            //Erro ao deletar relação de desenvolvimento
            echo json_encode(["erro" => "Houve um problema ao retirar o integrante do trabalho"]);
        }
    }
}
?>