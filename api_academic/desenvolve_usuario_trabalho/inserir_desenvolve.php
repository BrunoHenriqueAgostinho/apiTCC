<?php
/*
{
	"cpf":"44444444444",
	"codigo":"1",
	"cargo":"1"
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
    $cargo = 1;

    $sql1 = "SELECT 
                * 
            FROM 
                Tb_Usuario 
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);

    $sql2 = "SELECT 
                * 
            FROM 
                Tb_Trabalho 
            WHERE 
                codigo_trabalho = $codigo";
    $resultado2 = mysqli_query($conexao, $sql2);
    $contador2 = mysqli_num_rows($resultado2);

    if ($contador1 == 0){
        header("HTTP/1.1 500 Usuário Inexistente");
        //Esse usuário não existe
        echo json_encode(["erro" => "Houve um problema ao atribuir o trabalho ao usuário"]);
    } else {
        if ($contador2 == 0){
            header("HTTP/1.1 500 Trabalho Inexistente");
            //Esse trabalho não existe
            echo json_encode(["erro" => "Houve um problema ao atribuir o trabalho ao usuário"]);
        } else {
            $sql3 = "SELECT 
                        * 
                    FROM 
                        Desenvolve_Usuario_Trabalho
                    WHERE 
                        Tb_Usuario_cpf_usuario = '$cpf'
                    AND
                        Tb_Trabalho_codigo_trabalho = $codigo";
            $resultado3 = mysqli_query($conexao, $sql3);
            $contador3 = mysqli_num_rows($resultado3);
            if ($contador3 == 0){
                $sql4 = "INSERT INTO Desenvolve_Usuario_Trabalho (Tb_Usuario_cpf_usuario, Tb_Trabalho_codigo_trabalho, cargo_usuario) VALUES
                            ('$cpf', $codigo, $cargo)";
                $resultado4 = mysqli_query($conexao, $sql4);
                if ($resultado4) {
                    http_response_code(200);
                    echo json_encode(["mensagem" => "Relação de desenvolvimento inserida com sucesso."]);
                } else {
                    header("HTTP/1.1 500 Erro no SQL");
                    //Erro ao inserir relação de desenvolvimento
                    echo json_encode(["erro" => "Houve um problema ao atribuir o trabalho ao usuário"]);
                }
            } else {
                header("HTTP/1.1 500 Relação de desenvolvimento existente");
                //Relação de desenvolvimento já existe
                echo json_encode(["erro" => "Houve um problema ao atribuir o trabalho ao usuário"]);
            }
        }
    }
}
?>