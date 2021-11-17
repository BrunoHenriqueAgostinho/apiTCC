<?php
/*
{
	"pesquisa": "henrique"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;

    if($pesquisa == ''){
        header("HTTP/1.1 500 Nenhum valor informado");
        echo json_encode(["erro" => "Nenhum valor informado."]);
    } else {
        $pesquisa = "'%$pesquisa%'";

        $sql = "SELECT 
                    cpf_usuario as cpf, 
                    nome_usuario as nome, 
                    senha_usuario as senha, 
                    descricao_usuario as descricao, 
                    foto_usuario as foto, 
                    dtCadastro_usuario as dtCadastro, 
                    tema_usuario as tema, 
                    status_usuario as status, 
                    contaStatus_usuario as contaStatus, 
                    email_usuario as email, 
                    telefoneFixo_usuario as telefoneFixo, 
                    telefoneCelular_usuario as telefoneCelular 
                FROM 
                    Tb_Usuario 
                WHERE 
                    nome_usuario LIKE $pesquisa 
                AND 
                    contaStatus_usuario = 1";
                    
        $com = $conexao2->prepare($sql);
        $status = $com->execute();
        $resultado = $com->fetchAll(PDO::FETCH_ASSOC);
        $contador = count($resultado);
        if ($contador > 0){
            http_response_code(200);
            echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Sem retorno");
            echo json_encode(["erro" => "Nada foi encontrado."]);
        }
    }
    
}
?>