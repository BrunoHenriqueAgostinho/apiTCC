<?php

/*
{
    "nome": "novo trabalho",
    "descricao": "Essa é a descricão",
    "arquivo": "Texto aqui",
    "margemDireita": "1cm",
    "margemEsquerda": "1cm",
    "margemTopo": "1cm",
    "margemBaixo": "1cm",
    "modelo": 1
}
*/

header("Content-Type: application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $nome = $deco->nome;
    $descricao = $deco->descricao;
    $arquivo = $deco->arquivo;
    $margemDireita = $deco->margemDireita;
    $margemEsquerda = $deco->margemEsquerda;
    $margemTopo = $deco->margemTopo;
    $margemBaixo = $deco->margemBaixo;
    $dtCriacao = date('Y-m-d');
    $dtAlteracao = date('Y-m-d');
    $modelo = $deco->modelo;

    $sql1 = "SELECT codigo_trabalho as codigo FROM tb_trabalho WHERE codigo_trabalho = (SELECT MAX(codigo_trabalho) FROM tb_trabalho)";
    $resultado1 = mysqli_query($conexao, $sql1);
    $dados1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);
    $codigo = $dados1["codigo"] + 1;

    $sql2 = "INSERT INTO tb_trabalho (codigo_trabalho, nome_trabalho, descricao_trabalho, arquivo_trabalho, margemDireita_trabalho, margemEsquerda_trabalho, margemTopo_trabalho, margemBaixo_trabalho, dtCriacao_trabalho, dtAlteracao_trabalho,  Tb_Modelo_codigo_modelo) VALUES
                ($codigo, '$nome', '$descricao', '$arquivo', '$margemDireita', '$margemEsquerda', '$margemTopo', '$margemBaixo', '$dtCriacao', '$dtAlteracao', $modelo)";
    $resultado2 = mysqli_query($conexao, $sql2);
    
    if ($resultado2) {
        http_response_code(200);
        echo json_encode(["codigo" => $codigo]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao criar trabalho."]);
    }
}

/*
header("Content-Type: application/json");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $nome = $deco->nome;
    $descricao = $deco->descricao;
    $arquivo = $deco->arquivo;
    $margemDireita = $deco->margemDireita;
    $margemEsquerda = $deco->margemEsquerda;
    $margemTopo = $deco->margemTopo;
    $margemBaixo = $deco->margemBaixo;
    $dtCriacao = date('Y-m-d');
    $dtAlteracao = date('Y-m-d');
    $modelo = $deco->modelo;

    $sql1 = "INSERT INTO tb_trabalho (nome_trabalho, descricao_trabalho, arquivo_trabalho, margemDireita_trabalho, margemEsquerda_trabalho, margemTopo_trabalho, margemBaixo_trabalho, dtCriacao_trabalho, dtAlteracao_trabalho,  Tb_Modelo_codigo_modelo) VALUES
                ('$nome', '$descricao', '$arquivo', '$margemDireita', '$margemEsquerda', '$margemTopo', '$margemBaixo', '$dtCriacao', '$dtAlteracao', $modelo)";
    $resultado1 = mysqli_query($conexao, $sql1);
    if ($resultado1) {
        $sql2 = "SELECT codigo_trabalho as codigo FROM tb_trabalho WHERE nome_trabalho = '$nome' AND descricao_trabalho = '$descricao' AND arquivo_trabalho = '$arquivo' AND margemDireita_trabalho = '$margemDireita' AND margemEsquerda_trabalho = '$margemEsquerda' AND margemTopo_trabalho = '$margemTopo' AND margembaixo_trabalho = '$margemBaixo' AND dtCriacao_trabalho = '$dtCriacao' AND Tb_Modelo_codigo_modelo = $modelo";
        $resultado2 = mysqli_query($conexao, $sql2);
        if ($resultado2){
            $dados = mysqli_fetch_array($resultado2, MYSQLI_ASSOC);
            http_response_code(201);
            echo json_encode(["codigo" => $dados["codigo"]]);
        } else {
            header("HTTP/1.1 500 Erro no SQL");
            echo json_encode(["erro" => "Erro ao identificar trabalho."]);
        }
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao criar trabalho."]);
    }
}*/
?>