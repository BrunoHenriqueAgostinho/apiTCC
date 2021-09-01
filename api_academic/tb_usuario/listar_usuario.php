<?php
/*
{
	"pesquisa": "henrique"
}
*/

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;
    
    $sql = "SELECT 
                U.cpf_usuario,
                U.nome_usuario, 
                U.senha_usuario,
                U.descricao_usuario,
                U.foto_usuario,
                U.dtCadastro_usuario,
                U.tema_usuario,
                U.status_usuario,
                C.codigo_contato,
                C.email_contato,
                C.telefoneFixo_contato,
                C.telefoneCelular_contato
            FROM 
                tb_usuario U, 
                tb_contato C 
            WHERE 
                U.Tb_Contato_codigo_contato = C.codigo_contato 
            AND  
                U.nome_usuario like '%" . $pesquisa . "%'";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao pesquisar por usuários."]);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>