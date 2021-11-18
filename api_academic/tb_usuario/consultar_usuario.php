<?php
/*
{
    "cpf": "11111111111"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

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
                cpf_usuario = $cpf";
                
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        //Erro ao consultar usuário.
        echo json_encode(["erro" => "Houve um problema ao consultar o usuário"]);
    } else {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}
?>