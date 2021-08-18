<?php
include("../conexao.php");
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $desc = $request->descricao;
    $preco = $request->preco;
    $validade = $request->validade;
    
    $sql = "insert into Tb_Usuario (cpf_usuario, nome_usuario, senha_usuario, dtCadastro_usuario) values ('$desc',$preco, '$validade')";
    
    $status = mysqli_query($conexao, $sql);
    if ($status) {
        http_response_code(201);
        $data = ["mensagem" => "$desc inserido com Sucesso", "id" => $conexao->insert_id];
        echo json_encode($data);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
} else {
    header("HTTP/1.1 501 Método Inválido");
    echo json_encode(["erro" => " Método Inválido"]);
}
?>