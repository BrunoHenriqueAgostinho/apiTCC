<?php
/*
{
    "cpf": "11111111111"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cpf = $deco->cpf;

    $sql1 = "SELECT 
                *
            FROM 
                tb_usuario 
            WHERE 
                cpf_usuario = '$cpf'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if($contador == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse usuário não existe."]);
    } else {
        $sql2 = "DELETE FROM desenvolve_usuario_trabalho WHERE Tb_Usuario_cpf_usuario = '$cpf'";
        $resultado2 = mysqli_query($conexao, $sql2);

        $sql3 = "DELETE FROM adiciona_usuario_usuario WHERE seguidor_usuario = '$cpf' OR seguido_usuario = '$cpf'";
        $resultado3 = mysqli_query($conexao, $sql3);

        $sql4 = "DELETE FROM reage_usuario_trabalho WHERE Tb_Usuario_cpf_usuario = '$cpf'";
        $resultado4 = mysqli_query($conexao, $sql4);

        $dados1 = mysqli_fetch_array($resultado1);
        $codigo = $dados1["Tb_Contato_codigo_contato"];

        $sql5 = "DELETE FROM tb_usuario WHERE cpf_usuario = '$cpf'";
        $resultado5 = mysqli_query($conexao, $sql5);

        $sql6 = "DELETE FROM tb_contato WHERE codigo_contato = $codigo";
        $resultado6 = mysqli_query($conexao, $sql6);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>