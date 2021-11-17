<?php

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;

    $sql = "SELECT 
                U.cpf_usuario as cpf,
                U.nome_usuario as nome,
                U.senha_usuario as senha,
                U.descricao_usuario as descricao,
                U.foto_usuario as foto,
                U.dtCadastro_usuario as dtCadastro,
                U.tema_usuario as tema,
                U.status_usuario as status,
                U.contaStatus_usuario as contaStatus,
                U.email_usuario as email,
                U.telefoneFixo_usuario as telefoneFixo,
                U.telefoneCelular_usuario as telefoneCelular,
                D.Tb_Trabalho_codigo_trabalho as codigo,
                D.cargo_usuario as cargo
            FROM
                Tb_Usuario U, Desenvolve_Usuario_Trabalho D
            WHERE
                D.Tb_Trabalho_codigo_trabalho = $codigo AND U.cpf_usuario = D.Tb_Usuario_cpf_usuario";
                //D.Tb_Trabalho_codigo_trabalho = $codigo AND U.cpf_usuario = D.Tb_Usuario_cpf_usuario
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0){
        header("HTTP/1.1 500 Erro ao consultar banco");
        //Não foi possível consultar os membros deste trabalho
        echo json_encode(["erro" => "Houve um problema ao consultar os integrantes do trabalho"]);
    } else {
        $dados = $resultado->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
}

?>