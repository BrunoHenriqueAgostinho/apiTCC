<?php
/*{
    "trabalho": "2",
    "tag": "7"
}*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "GET"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $trabalho = $deco->trabalho;
    $tag = $deco->tag;


    $sql1 = "SELECT
                *
            FROM
                apresenta_trabalho_tag
            WHERE
                Tb_Trabalho_codigo_trabalho = $trabalho
            AND
                Tb_Tag_codigo_tag = $tag";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0) {
        header("HTTP/1.1 500 Registro inexistente");
        echo json_encode(["erro" => "Esse registro não existe."]);
    } else {
        $sql2 = "DELETE FROM apresenta_trabalho_tag WHERE Tb_Trabalho_codigo_trabalho = $trabalho AND Tb_Tag_codigo_tag = $tag";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $dados = ["mensagem" => "Tag deletada com sucesso do trabalho"];
            echo json_encode($dados);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao deletar tag do trabalho."]);
        }
    }
}
?>