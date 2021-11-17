<?php
/*
{
	"cpf":"44444444444",
	"codigo":"1",
	"cargo":"2"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;
    $cargo = $deco->cargo;

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
        echo json_encode(["erro" => "Não existe essa relação de desenvolvimento."]);
    } else {
        $sql2 = "UPDATE Desenvolve_Usuario_Trabalho 
                    SET  
                        cargo_usuario =  '$cargo'
                    WHERE 
                        Tb_Usuario_cpf_usuario = '$cpf'
                    AND
                        Tb_Trabalho_codigo_trabalho = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            echo json_encode(["mensagem" => "Relação de desenvolvimento alterado com sucesso."]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao alterar relação de desenvolvimento."]);
        }
    }
}
?>