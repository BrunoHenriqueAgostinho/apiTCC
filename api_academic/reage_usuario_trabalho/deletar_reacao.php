<?php
/*

*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;
    $codigo = $deco->codigo;

    $sql1 = "SELECT 
                *
            FROM 
                reage_usuario_trabalho
            WHERE 
                Tb_Usuario_cpf_usuario = '$cpf'
            AND
                Tb_Trabalho_codigo_trabalho = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 201 Reação inexistente");
        echo json_encode(["erro" => "Não há nenhuma reação."]);
    } else {
        $sql = "DELETE FROM reage_usuario_trabalho WHERE Tb_Usuario_cpf_usuario = '$cpf' AND Tb_Trabalho_codigo_trabalho = $codigo";
        $resultado = mysqli_query($conexao, $sql);
        if ($resultado) {
            http_response_code(200);
            $dados = ["mensagem" => "Reação deletada com sucesso"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao deletar reação."]);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>