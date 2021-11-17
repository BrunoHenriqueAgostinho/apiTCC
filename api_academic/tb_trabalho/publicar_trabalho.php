<?php

header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    $finalizado = $deco->finalizado;
    $dt = date('Y-m-d');

    $sql1 = "SELECT 
                *
            FROM 
                Tb_Trabalho 
            WHERE 
                codigo_trabalho  = " . $codigo;
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse trabalho não existe."]);
    } else { 
        $sql2 = "UPDATE 
                    Tb_Trabalho 
                SET 
                    finalizado_trabalho = $finalizado, 
                    dtAlteracao_trabalho = '$dt', 
                    dtPublicacao_trabalho = '$dt' 
                WHERE 
                    codigo_trabalho = $codigo";
                    
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $data = ["mensagem" => "Trabalho publicado com sucesso."];
            echo json_encode($data);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            $data = ["erro"=> mysqli_error($conexao)];
            echo json_encode($data);
        }
    }
}

?>