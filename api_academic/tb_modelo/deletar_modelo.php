<?php
/*

*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql1 = "UPDATE 
                Tb_Trabalho 
            SET 
                Tb_Modelo_codigo_modelo = 1 
            WHERE 
                Tb_Modelo_codigo_modelo = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);

    if($resultado1) {
        $sql2 = "DELETE FROM Tb_Modelo WHERE codigo_modelo = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);

        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Modelo deletado com sucesso"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            //"Erro ao deletar modelo."
            echo json_encode(["erro" => "Houve um problema ao deletar o modelo"]);
        }
    } else {
        header("HTTP/1.1 500 Registro inexistente.");
        //Esse modelo não existe
        echo json_encode(["erro" => "Houve um problema ao deletar o modelo"]);
    }
}
?>