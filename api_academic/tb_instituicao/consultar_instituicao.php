<?php
/*
{
	"cnpj": "11111111111"
}
*/
header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require("../conexao.php");
    $json = file_get_contents("php://input");
    $deco = json_decode($json);
    $cnpj = $deco->cnpj;

    $sql = "SELECT 
                cnpj_instituicao as cnpj, 
                nome_instituicao as nome, 
                logotipo_instituicao as logotipo, 
                dtCadastro_instituicao as dtCadastro, 
                senha_instituicao as senha, 
                contaStatus_instituicao as contaStatus, 
                email_instituicao as email, 
                telefoneFixo_instituicao as telefoneFixo, 
                telefoneCelular_instituicao as telefoneCelular, 
                cidade_instituicao as cidade 
            FROM 
                Tb_Instituicao 
            WHERE 
                cnpj_instituicao = $cnpj";
                
    $resultado = mysqli_query($conexao, $sql);
    $contador = mysqli_num_rows($resultado);
    if ($contador == 0) {
        header("HTTP/1.1 500 Erro no SQL");
        //Erro ao consultar instituição
        echo json_encode(["erro" => "Houve um problema ao consultar a instiruição"]);
    } else {
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }
} 
?>
