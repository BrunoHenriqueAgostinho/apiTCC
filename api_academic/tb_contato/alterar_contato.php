<?php
header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    $telefoneFixo = $deco->telefoneFixo;
    $telefoneCelular = $deco->telefoneCelular;

    $sql1 = "SELECT 
                *
            FROM 
                tb_contato
            WHERE 
                codigo_contato = " . $codigo;
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse contato não existe."]);
    } else {
        $sql = "UPDATE tb_contato 
                    SET 
                        telefoneFixo_contato = '$telefoneFixo',
                        telefoneCelular_contato = '$telefoneCelular'
                    WHERE
                        codigo_contato = '$codigo'";
        $resultado = mysqli_query($conexao, $sql);
        if($resultado){
            http_response_code(200);
            $data = ["mensagem" => "Contato alterado com sucesso"];
            echo json_encode($data);
        } else {
            http_response_code(202);
            $data = ["status" => "Erro", "msg"=> "Erro ao Alterar"];
            echo json_encode($data);
        }
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>