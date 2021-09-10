<?php
/*
{
	"cnpj": "11111111111"
}
*/
header('Content-Type: application/json');
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;

    $sql = "SELECT 
                I.*, 
                C.*,
                E.*
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
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao consultar instituição."]);
    } else {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>
