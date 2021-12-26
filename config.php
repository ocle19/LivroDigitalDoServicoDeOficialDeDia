<?php
require __DIR__ . '/vendor/autoload.php';
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
define('OS_HOST', 'LINUX'); /// WIN // LINUX
$path = __DIR__ . '/';
$local = true;
define('VERSAO', md5(1));

if ($local) {
    error_reporting(E_ALL);
    define('SITE_NOME', "LIVRO SV OF DIA - LOCAL");
    define('BANCO_HOST', "localhost");
    define('BANCO_TABELA', "livros");
    define('BANCO_TABELA_ARRANCHAMENTO', "arranchamento");
    define('BANCO_USUARIO', "usuario");
    define('BANCO_SENHA', "senha");

} else {
    error_reporting(0);
    define('SITE_NOME', "LIVRO SV OF DIA");
    define('BANCO_HOST', "localhost");
    define('BANCO_TABELA', "livros");
    define('BANCO_TABELA_ARRANCHAMENTO', "arranchamento");
    define('BANCO_USUARIO', "root");
    define('BANCO_SENHA', "");

}
