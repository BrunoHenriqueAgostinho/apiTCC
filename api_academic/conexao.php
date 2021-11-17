<?php
    //academicoetec.mysql.dbaas.com.br caso o ip nao esteja funcionando
    // PARA USAR A CONEXAO COM O SERVIDOR UTILIZE DESCOMENTE ESSA PARTE
    // host far from  home
    $host = "201.62.65.6"; 
    // host local na escola
    // $host = "172.16.20.100"; 
    
    $user = "academic";
    $password = "Academic@2021";
    $base = "academic";
    $dsn = "mysql:host={$host};dbname={$base}"; 
    
    // PARA USAR O SERVIDOR LOCAL DESCOMENTAR ESTA PAGINA https://academicapitcc.herokuapp.com/api_academic/tb_tag/listar
    // $host = "localhost";
    // $user = "root";
    // $password = "";
    // $base = "academic";
    // $dsn = "mysql:host={$host};port=3306;dbname={$base}";
    
    //NÃO COMENTAR ESTA PARTE SE NÃO, NÃO IRA FUNCIONAR
    $conexao = @mysqli_connect($host, $user, $password);
    $conexao->set_charset("UTF8");
    try{
        $conexao2 = new PDO($dsn, $user, $password);
    }catch (PDOException $e){
        die($e->getMessage());
    }   
    if ($conexao->connect_error) {
        die("Falha ao conectar: " . $conexao->connect_error);
    }
    if (!$conexao->select_db($base)) {
        die("O Banco de dados não existe");
    }
?>
