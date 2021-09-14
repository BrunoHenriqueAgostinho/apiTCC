<?php
header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $email = $deco->email;
    $senha_des = $deco->senha;
    $senha = md5($senha_des);
    
    $sql1 = "SELECT codigo_contato FROM tb_contato WHERE email_contato LIKE '$email'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if($contador==0){
        echo json_encode(["login" => "0"]);
    }else{
        $dados = mysqli_fetch_array($resultado1);
        $contato = $dados["codigo_contato"];
        $sql2 = "SELECT cnpj_instituicao FROM tb_instituicao WHERE Tb_Contato_codigo_contato = $contato AND senha_instituicao LIKE '$senha'";
        $resultado2 = mysqli_query($conexao, $sql2);
        $contador2 = mysqli_num_rows($resultado2);
        if($contador2 == 0){
            $sql3 = "SELECT cpf_usuario FROM tb_usuario WHERE Tb_Contato_codigo_contato = $contato AND senha_usuario LIKE '$senha'";
            $resultado3 = mysqli_query($conexao, $sql3);
            $contador3 = mysqli_num_rows($resultado3);
            if($contador3 == 0){
                echo json_encode(["login" => "1"]);
            }else{
                $dados = mysqli_fetch_array($resultado3);
                $usuario = $dados["cpf_usuario"];
                http_response_code(200);
                echo json_encode(["cpf"=>"$usuario"]);
            }
        }else{
            $dados = mysqli_fetch_array($resultado2);
            $instituicao = $dados["cnpj_instituicao"];
            http_response_code(200);
            echo json_encode(["cnpj"=>"$instituicao"]);
        }

    }
    
}
?>