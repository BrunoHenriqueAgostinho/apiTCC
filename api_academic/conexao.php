<?php
    //academicoetec.mysql.dbaas.com.br caso o ip nao esteja funcionando
    // PARA USAR A CONEXAO COM O SERVIDOR UTILIZE DESCOMENTE ESSA PARTE
    // $host = "179.188.16.2"; 
    // $user = "academicoetec";
    // $password = "TCC!@#010203";
    // $base = "academicoetec";
    // $dsn = "mysql:host={$host};dbname={$base}"; 
    
    // PARA USAR O SERVIDOR LOCAL DESCOMENTAR ESTA PAGINA
    $host = "localhost";
    $user = "root";
    $password = "";
    $base = "academic";
    $dsn = "mysql:host={$host};port=3306;dbname={$base}";
    
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