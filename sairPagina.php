<?php
error_reporting(false);
function sairPagina()
{
    if ($_GET["func"] && $_GET["func"] == "sairPagina") {
        session_destroy();
        echo "<head>
	<title> <?php echo SITE_NOME ?> - Saindo...</title>
	</head>";
        echo "<script> alert('Você foi desconectado!'); location.href='index.php'</script>";
    }
}
