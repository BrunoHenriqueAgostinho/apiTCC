<?php
/*

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
                tb_modelo
            WHERE
                codigo_modelo = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse modelo não existe."]);
    } else {
        $sql2 = "DELETE FROM tb_modelo WHERE codigo_modelo = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);

        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Modelo deletado com sucesso"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao deletar modelo."]);
        }
    }
}
?>