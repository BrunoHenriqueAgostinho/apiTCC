<?php
    $conexao = new mysqli("localhost:3306", "root", "");
    $conexao->set_charset("UTF8");
    if ($conexao->connect_error) {
        die("Falha ao conectar: " . $conexao->connect_error);
    }
    if (!$conexao->select_db("academic2")) {
        die("O Banco de dados não existe");
    }
?>