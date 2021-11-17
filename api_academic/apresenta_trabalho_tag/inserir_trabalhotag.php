<?php
/*
{
	"trabalho": "1",
	"tag": "4"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    $tag = $deco->tag;
    
    $sql1 = "SELECT 
                *
            FROM 
                Tb_Trabalho
            WHERE 
                codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0){
        header("HTTP/1.1 500 Registro inexistente");
        echo json_encode(["erro" => "Esse trabalho não existe."]);
    } else {
        $sql2 = "SELECT 
                    *
                FROM 
                    Tb_Tag
                WHERE 
                    codigo_tag = $tag";
        $resultado2 = mysqli_query($conexao, $sql2);
        $contador2 = mysqli_num_rows($resultado2);
        if ($contador2 == 0){
            header("HTTP/1.1 500 Registro inexistente");
            echo json_encode(["erro" => "Essa tag não existe."]);
        } else {
            $sql3 = "SELECT
                        *
                    FROM
                        Apresenta_Trabalho_Tag
                    WHERE
                        Tb_Trabalho_codigo_trabalho = $codigo
                    AND
                        Tb_Tag_codigo_tag = $tag";
            $resultado3 = mysqli_query($conexao, $sql3);
            $contador3 = mysqli_num_rows($resultado3);
            if ($contador3 == 0) {
                $sql4 = "INSERT Apresenta_Trabalho_Tag (Tb_Trabalho_codigo_trabalho,Tb_Tag_codigo_tag) VALUES 
                            ($codigo, $tag)";
                $resultado4 = mysqli_query($conexao, $sql4);
                if ($resultado4) {
                    http_response_code(201);
                    echo json_encode(["mensagem" => "Tag inserida com sucesso ao trabalho."]);
                } else {
                    header("HTTP/1.1 500 Erro no SQL");
                    echo json_encode(["erro" => "Erro ao inserir tag ao trabalho."]);
                }
            } else {
                header("HTTP/1.1 500 Registro existente");
                echo json_encode(["erro" => "Esse registro já existe."]);
            }
        }
    }
}
?>