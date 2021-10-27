<?php

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                *
            FROM 
                tb_trabalho 
            WHERE 
                codigo_trabalho  = " . $codigo;

    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse trabalho não existe."]);
    } else {
        //Delete tb_desenvolve - Trabalho
        $sql2  = "DELETE FROM
                            desenvolve_usuario_trabalho
                        WHERE
                            Tb_Trabalho_codigo_trabalho = $codigo";

        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            //Delete tb_reag - Trabalho
            $sql3  = "DELETE FROM
                            reage_usuario_trabalho
                        WHERE
                            Tb_Trabalho_codigo_trabalho = $codigo";

            $resultado3 = mysqli_query($conexao, $sql3);
            if ($resultado3) {
                //Delete tb_tag - Trabalho
                $sql4  = "DELETE FROM
                            apresenta_trabalho_tag
                        WHERE
                            Tb_Trabalho_codigo_trabalho = " . $codigo;

                $resultado4 = mysqli_query($conexao, $sql4);
                if ($resultado4) {
                    //Delete tb_trabalho - Trabalho
                    $sql5 = "DELETE FROM 
                                tb_trabalho 
                            WHERE 
                                codigo_trabalho = " . $codigo; 

                    $resultado5 = mysqli_query($conexao, $sql5);
                    if ($resultado5) {
                        http_response_code(200);
                        $dados = ["mensagem" => "Trabalho deletado com sucesso"];
                        echo json_encode($dados);
                    } else {
                        header("HTTP/1.1 500 Erro no SQL");
                        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
                    }
                } else {
                    header("HTTP/1.1 500 Erro no SQL");
                    echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
                }
            } else {
                header("HTTP/1.1 500 Erro no SQL");
                echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
            }
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
        }
    } 
}
?>