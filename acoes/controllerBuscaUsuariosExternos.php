<?php
include "../connectionMilitares.php";
$q = strtolower(filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING));

if ($q == " " or strlen($q) <= 0 or empty($q)) {
} else {
    $qLike = '%' . $q . '%';
    $pesquisar = $pdoMilitares->prepare("SELECT DISTINCT * FROM militares WHERE (nomeGuerra like :q OR numero like :q) and militares.status = 'ATIVADO' ORDER BY numero ASC ");
    $pesquisar->bindParam(':q', $qLike);
    $pesquisar->execute();
    while ($reg = $pesquisar->fetch(PDO::FETCH_ASSOC)) {
        $bateria = $reg["subUnidade"];
        $gradRes = mb_strtoupper(($reg["grad"]));
        $numeroRes = $reg["numero"] >= 1 ? $reg["numero"] : '0';
        $nomeCompletoRes = mb_strtoupper(utf8_decode($reg["nomeCompleto"]));
        if ($bateria == 0) {
            $bateria = "Bateria de Comando";
        }
        if ($bateria == 1) {
            $bateria = "1ª Bateria de Obuses";
        }
        if ($bateria == 2) {
            $bateria = "2ª Bateria de Obuses";
        }
        if ($bateria == 3) {
            $bateria = "3ª Bateria de Obuses";
        }
        echo ("<dados class='punido' onclick='check(this)' bateria='$bateria' graduacao='$gradRes' numero='$numeroRes' nomeCompleto='$nomeCompletoRes' >" . $reg["grad"]) . " " . $reg["numero"] . " " . mb_strtoupper(utf8_decode($reg["nomeGuerra"])). " [" . mb_strtoupper(utf8_decode($reg["nomeCompleto"])) . "] da " . $bateria . "</dados>\n";
    }
}
