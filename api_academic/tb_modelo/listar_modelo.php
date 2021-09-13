<?php
/*

*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $pesquisa = $deco->pesquisa;

    $sql1 = "SELECT 
                * 
            FROM 
                tb_instituicao 
            WHERE 
                nome_instituicao like '%$pesquisa%'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Não encontramos essa instituição."]);
    } else {
        $valores = mysqli_fetch_array($resultado1);
        $codigo = $valores["cnpj_instituicao"];
        $sql2 = "SELECT 
                    * 
                FROM 
                    tb_modelo 
                WHERE
                    Tb_Instituicao_cnpj_instituicao = '$codigo'";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            $dados = $resultado2->fetch_all(MYSQLI_ASSOC);
            http_response_code(200);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao listar modelos."]);
        }
    }


} 
?>