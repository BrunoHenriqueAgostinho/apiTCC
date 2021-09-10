<?php
/*
{
    "cnpj": "55555555555"
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
                tb_instituicao
            WHERE
                cnpj_instituicao = '$cnpj'";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0) {
        header("HTTP/1.1 201 Instituição inexistente");
        echo json_encode(["erro" => "Não existe essa instituição."]);
    } else {
        $sql2 = "UPDATE tb_modelo
                    SET
                        Tb_Instituicao_cnpj_instituicao = null
                    WHERE
                        Tb_Instituicao_cnpj_instituicao = '$cnpj'";
        $resultado2 = mysqli_query($conexao, $sql2);
        
        $sql3 = "UPDATE tb_trabalho
                    SET
                        Tb_Instituicao_cnpj_instituicao = null
                    WHERE
                        Tb_Instituicao_cnpj_instituicao = '$cnpj'";
        $resultado3 = mysqli_query($conexao, $sql3);

        $sql4 = "DELETE FROM tb_endereco WHERE Tb_Instituicao_cnpj_instituicao = $cnpj";
        $resultado4 = mysqli_query($conexao, $sql4);

        $dados1 = mysqli_fetch_array($resultado1);
        $codigo = $dados1["Tb_Contato_codigo_contato"];

        $sql5 = "DELETE FROM tb_instituicao WHERE cnpj_instituicao = '$cnpj'";
        $resultado5 = mysqli_query($conexao, $sql5);
        echo $conexao->error;

        $sql6 = "DELETE FROM tb_contato WHERE codigo_contato = $codigo";
        $resultado6 = mysqli_query($conexao, $sql6);
    }
} else {
    header("HTTP/1.1 401 Request Method Incorreto");
    echo json_encode(["erro" => "O método de solicitação está incorreto."]);
}
?>