<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $json = file_get_contents("php://input");
    require("../conexao.php");
    $deco = json_decode($json);
    $email = $deco->email;
    $telefoneFixo = $deco->telefoneFixo;
    $telefoneCelular = $deco->telefoneCelular;

    $sql = "INSERT INTO tb_contato (email_contato, telefoneFixo_contato, telefoneCelular_contato) VALUES
                ('$email', '$telefoneFixo', '$telefoneCelular')";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Contato inserido com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}
?>