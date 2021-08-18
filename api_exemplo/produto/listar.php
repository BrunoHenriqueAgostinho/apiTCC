<?php

header("Content-Type: application/json");

require("../conexao.php");
$sql = "select 
        pro_id as id, 
        pro_descricao as descricao,
        pro_preco as preco, 
        pro_validade as validade 
        from produto order by pro_id";

$result = mysqli_query($conexao, $sql);
if ($result) {
    $r = $result->fetch_all(MYSQLI_ASSOC);
    http_response_code(200);
    echo json_encode($r, JSON_UNESCAPED_UNICODE);
} else {
    header("HTTP/1.1 500 Erro no SQL");
    echo json_encode(["erro" => "Erro SQL: " . $conexao->error]);
}
?>