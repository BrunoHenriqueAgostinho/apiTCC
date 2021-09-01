
<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;
    $estado = $deco->estado;
    $cidade = $deco->cidade;
    $bairro = $deco->bairro;
    $rua = $deco->rua;
    $numero = $deco->numero;
    $complemento = $deco->complemento;
    $cep = $deco->cep;

    $sql = "INSERT INTO tb_endereco (Tb_Instituicao_cnpj_instituicao, estado_endereco, cidade_endereco, bairro_endereco, rua_endereco, numero_endereco, complemento_endereco, cep_endereco) VALUES
                ('$cnpj','$estado','$cidade','$bairro','$rua','$numero','$complemento','$cep')";
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado) {
        http_response_code(201);
        echo json_encode(["mensagem" => "Endereço inserido com Sucesso"]);
    } else {
        header("HTTP/1.1 500 Erro no SQL");
        echo json_encode(["erro" => "Erro ao Inserir " . $conexao->error]);
    }
}
?>

