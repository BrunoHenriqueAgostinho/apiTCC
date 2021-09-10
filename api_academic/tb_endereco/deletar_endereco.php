<?php
/*{
    "cnpj": "22222222222222"
}
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;

    $sql1 = "SELECT 
                *
            FROM 
                tb_endereco
            WHERE 
                Tb_Instituicao_cnpj_instituicao = " . $cnpj;
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse endereço não existe."]);
    } else {
        $sql2 = "DELETE FROM 
                    tb_endereco 
                WHERE 
                    Tb_Instituicao_cnpj_instituicao = ".$cnpj;
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Endereço deletado com sucesso"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
        }
    }
}else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>