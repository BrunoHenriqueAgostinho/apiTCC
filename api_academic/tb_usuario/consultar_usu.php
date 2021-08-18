<?php
/*
{
    "cpf": "11111111111"
}
*/
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql = "select 
        cpf_usuario,
        nome_usuario, 
        senha_usuario,
        descricao_usuario,
        foto_usuario,
        dtCadastro_usuario,
        tema_usuario,
        status_usuario,
        Tb_Contato_codigo_contato 
        from Tb_usuario where cpf_usuario = " . $cpf;
        
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $result->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>