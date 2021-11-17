<?php
/*

*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf_seguidor = $deco->cpf_seguidor;
    $cpf_seguido = $deco->cpf_seguido;

    $sql1 = "SELECT 
                seguidor_usuario,
                seguido_usuario
            FROM 
                Adiciona_Usuario_Usuario 
            WHERE 
                seguidor_usuario = '$cpf_seguidor'
            AND
                seguido_usuario = '$cpf_seguido'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0) {
        header("HTTP/1.1 201 Amigo inexistente");
        echo json_encode(["erro" => "Não existe esse amigo."]);
    } else {
        $sql2 = "DELETE FROM Adiciona_Usuario_Usuario 
                WHERE 
                    seguidor_usuario = '$cpf_seguidor' 
                AND
                    seguido_usuario = '$cpf_seguido'"; 
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Deixou de Seguir"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao deletar amigo."]);
        }
    }
}
?>