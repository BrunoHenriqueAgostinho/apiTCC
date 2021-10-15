<?php
/*{
	"codigo": "3",
    "nome": "Trabalho",
    "descricao": "Descrição do Trabalho",
    "arquivo": "Arquivo do Trabalho",
    "formatacao": "Formatação do Trabalho",
	"finalizado": "0",
	"avaliacao": "5",
	"cnpj": "11111111111111"
}*/

header("Content-Type: application/json");
//header("Access-Controlo-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $codigo = $deco->codigo;
    $nome = $deco->nome;
    $descricao = $deco->descricao;
    $arquivo = $deco->arquivo;
    $formatacao = $deco->formatacao;
    $finalizado = $deco->finalizado;
    $dtAlteracao = date('Y-m-d');
    $avaliacao = $deco->avaliacao;
    $cnpj = $deco->cnpj;
    
    $sql1 = "SELECT 
                *
            FROM 
                tb_trabalho 
            WHERE 
                codigo_trabalho  = " . $codigo;
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador = mysqli_num_rows($resultado1);
    if ($contador == 0) {
        header("HTTP/1.1 500 Registro inexistente.");
        echo json_encode(["erro" => "Esse trabalho não existe."]);
    } else {
        if(empty($cnpj) && empty($avaliacao)){
            $sql2 = "UPDATE tb_trabalho SET nome_trabalho = '$nome', descricao_trabalho = '$descricao', arquivo_trabalho = '$arquivo', formatacao_trabalho = '$formatacao', finalizado_trabalho = $finalizado, dtAlteracao_trabalho = '$dtAlteracao' WHERE codigo_trabalho = $codigo";
        } else if (empty($avaliacao)){
            $sql2 = "UPDATE tb_trabalho SET nome_trabalho = '$nome', descricao_trabalho = '$descricao', arquivo_trabalho = '$arquivo', formatacao_trabalho = '$formatacao', finalizado_trabalho = $finalizado, dtAlteracao_trabalho = '$dtAlteracao', Tb_Instituicao_cnpj_instituicao = '$cnpj' WHERE codigo_trabalho = $codigo";
        } else {
            $sql2 = "UPDATE tb_trabalho SET nome_trabalho = '$nome', descricao_trabalho = '$descricao', arquivo_trabalho = '$arquivo', formatacao_trabalho = '$formatacao', finalizado_trabalho = $finalizado, dtAlteracao_trabalho = '$dtAlteracao', Tb_Instituicao_cnpj_instituicao = '$cnpj', avaliacao_trabalho = '$avaliacao' WHERE codigo_trabalho = $codigo";
        }

        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(200);
            $data = ["mensagem" => "Trabalho alterado com sucesso"];
            echo json_encode($data);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            $data = ["erro"=> mysqli_error($conexao)];
            echo json_encode($data);
        }
    }
}

?>