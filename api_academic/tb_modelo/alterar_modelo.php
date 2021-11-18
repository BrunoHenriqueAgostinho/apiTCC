<?php
/*
    {
	    "cnpj":"11111111111111",
        "codigo": "3",
        "nome":"Resumo Expandido",
        "arquivo":"Título: Resumo: ",
        "formatacao":"10pt",
        "descricao":"Modelo para o TCC do 3°ETIM DS"
    }
*/

header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "PUT"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $codigo = $deco->codigo;
    $nome = $deco->nome;
    $arquivo = $deco->arquivo;
    $margemDireita = $deco->margemDireita;
    $margemEsquerda = $deco->margemEsquerda;
    $margemTopo = $deco->margemTopo;
    $margemBaixo = $deco->margemBaixo;
    $descricao = $deco->descricao;

    $sql1 = "SELECT
                *
            FROM
                Tb_Modelo
            WHERE
                codigo_modelo = $codigo";
    $resultado1 = mysqli_query($conexao, $sql1);
    $contador1 = mysqli_num_rows($resultado1);
    if ($contador1 == 0){
        header("HTTP/1.1 500 Registro inexistente.");
        //Esse modelo não existe
        echo json_encode(["erro" => "Houve um problema ao alterar as informações do modelo"]);
    } else {
        $sql2 = "UPDATE Tb_Modelo 
                    SET  
                        Tb_Instituicao_cnpj_instituicao =  '$cnpj',
                        nome_modelo = '$nome', 
                        arquivo_modelo = '$arquivo', 
                        margemDireita_modelo = '$margemDireita', 
                        margemEsquerda_modelo = '$margemEsquerda', 
                        margemTopo_modelo = '$margemTopo', 
                        margemBaixo_modelo = '$margemBaixo', 
                        descricao_modelo = '$descricao'
                    WHERE 
                        codigo_modelo = $codigo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2) {
            http_response_code(201);
            echo json_encode(["mensagem" => "Modelo alterado com sucesso."]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            //Erro ao alterar modelo
            echo json_encode(["erro" => "Houve um problema ao alterar as informações do modelo"]);
        }
    }
}
?>