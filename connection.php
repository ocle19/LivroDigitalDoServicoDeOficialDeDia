<?php
require_once 'config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . BANCO_HOST . ';dbname=' . BANCO_TABELA . '',
        BANCO_USUARIO,
        BANCO_SENHA,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
} catch (PDOException $e) {
    echo "Falha ao conectar com o banco de dados: " . $e->getMessage();
    die;
}
