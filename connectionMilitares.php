<?php
require_once 'config.php';

try {
    $pdoMilitares = new PDO(
        'mysql:host=' . BANCO_HOST . ';dbname=' . BANCO_TABELA_ARRANCHAMENTO . '',
        BANCO_USUARIO,
        BANCO_SENHA,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
} catch (PDOException $e) {
    echo "Falha ao conectar com o banco de dados: " . $e->getMessage();
    die;
}
