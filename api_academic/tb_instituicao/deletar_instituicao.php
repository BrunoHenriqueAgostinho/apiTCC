<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;

    $sql = "DELETE
            I.*, 
            E.*,
            C.* 
            FROM

            tb_instituicao I,
            tb_contato C,
            tb_endereco E
            
            WHERE 
            
            I.Tb_Contato_codigo_contato = C.codigo_contato 
            
            AND
	            
            E.Tb_Instituicao_cnpj_instituicao = I.cnpj_instituicao

            AND  
            
            I.cnpj_instituicao = " . $cnpj;
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(200);
        $dados = ["mensagem" => "Instituição deletado com sucesso"];
        echo json_encode($dados);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
    }
}
?>