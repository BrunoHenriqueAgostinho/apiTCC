<?php
//?cpf=11111111111
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $codigo = $_GET["id"];
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
        from tb_usuario where cpf_usuario = " . $codigo;
    
    $resultado = mysqli_query($conexao, $sql);
    if($resultado) {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>