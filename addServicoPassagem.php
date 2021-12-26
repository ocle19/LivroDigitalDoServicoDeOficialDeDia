<head>
    <title> <?php echo SITE_NOME; ?> - Passar Serviço</title>
</head>
<?php
$selecionaof   = strtoupper($nome);
$ofdiaLogado = $grad . " " . $selecionaof;

$consultafaltapassar = $pdo->prepare("SELECT * FROM aosubcmt WHERE passeiAo ='' and ofdia = :ofdia ORDER BY doDia ASC LIMIT 0,1");
$consultafaltapassar->bindParam(':ofdia', $ofdiaLogado);
$consultafaltapassar->execute();

$consultaoficiais  = $pdo->prepare("SELECT * FROM usuarios WHERE user_nivel = 2 and usuarios.status='ATIVADO' ORDER BY grad, user_nome ASC");
$consultaoficiais->execute();
$dodia     = "";

$consultatotalsv = $pdo->prepare("SELECT * FROM aosubcmt WHERE passeiAo ='' and ofdia = :ofdia ORDER BY doDia ASC LIMIT 0,1");
$consultatotalsv->bindParam(':ofdia', $ofdiaLogado);
$consultatotalsv->execute();
$PEGAid    = $consultatotalsv->rowCount();
$numerodoc   = $PEGAid["id"] ?? 0;

$consultafaltapassar = $pdo->prepare("SELECT * FROM aosubcmt WHERE (passeiAo = '' or assinaturaOfDia = '') and ofdia = :ofdia ORDER BY doDia ASC");
$consultafaltapassar->bindParam(':ofdia', $ofdiaLogado);
$consultafaltapassar->execute();
$consultanrdocANO  = $pdo->prepare("SELECT YEAR(doDia) as ANO ,COUNT(*) as TOTAL FROM aosubcmt WHERE YEAR(doDia) = '2019'  GROUP BY YEAR(doDia)");
$consultanrdocANO->execute();
$numero      = $consultanrdocANO->rowCount();

$consultadiadoAnoSV = $pdo->prepare("SELECT * FROM aosubcmt WHERE passeiAo = '' and ofdia = :ofdia ORDER BY doDia ASC LIMIT 0,1");
$consultadiadoAnoSV->bindParam(':ofdia', $ofdiaLogado);
$consultadiadoAnoSV->execute();
$resultadododia   = $consultadiadoAnoSV->rowCount();

if (!empty($resultadododia["doDia"])) {
    $datadosv = getdate(strtotime($resultadododia["doDia"]));
} else {
    $datadosv['year'] = 0;
}

if ($datadosv["year"] >= 2020) {
    $numerodoc = $datadosv["yday"] + 1;
};
?>
<div class="container theme-showcase" role="main">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <center>Passagem de serviço após passar o serviço</center>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <?php

                if ($nivel == 1) { ?>
                    <a href="#" onclick="window.open('ajudaADJ.pdf', 'Ajuda Adjunto', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10');">Clique aqui caso tenha alguma dúvida sobre o Sistema.</a>
                <?php
                }
                ?>
                <?php
                if ($nivel == 2) { ?>
                    <a href="#" onclick="window.open('ajudaOF.pdf', 'Ajuda Oficial de Dia', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10');">Clique aqui caso tenha alguma dúvida sobre o Sistema.</a>
                <?php
                }
                ?>
                <hr>
                <form class="form-horizontal" action="" id="form_passar_servico" enctype="multipart/form-data" method="POST">
                    <div class="form-group">
                        <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Do dia</label>
                        <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
                            <select class="form-control form-control-inline" name="doDia" id="doDia">
                                <option value="Selecione"><?php echo "Passe os servicos 1 por vez ( caso atrase a passagem e tenha + de 2 na espera )"; ?></option>
                                <?php while ($resu = $consultafaltapassar->fetch(PDO::FETCH_ASSOC)) {
                                    $adjuntu  = str_replace(".jpg", "", $resu['assinaturaAdj']);
                                    $adjuntoC = str_replace(".png", "", $adjuntu);
                                ?>
                                    <option value="<?php echo $resu['doDia']; ?>"><?php echo "DIA DO SV: " . date("d-m-Y", strtotime($resu['doDia'])) . " - OF DIA: " . $resu['ofdia'] . " - ADJ: " . $adjuntoC . " "; ?></option>
                                <?php } ?>
                            </select>
                            OBS: Se não aparecer seu último sv, é porquê você tem serviços com a 'passagem' pendente!
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-3 col-lg-2">Passar ao</LABEL>
                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                            <select class="form-control form-control-inline" name="passeiAo" id="passeiAo">
                                <option value="Selecione"><?php echo "Selecione um oficial"; ?></option>
                                <?php while ($resuofi = $consultaoficiais->fetch(PDO::FETCH_ASSOC)) {
                                    $grad   = $resuofi['grad'];
                                    $nomecompleto = strtoupper($resuofi['user_nome']);
                                ?>
                                    <option value="<?php echo "$grad $nomecompleto"; ?>"><?php echo "$grad $nomecompleto"; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                    </div>
                    <input type="hidden" name="assinatura" value="<?php echo $ofdiaLogado; ?>">
                    <input type="hidden" name="acao" value="passar_servico">
                    <div class="form-group">
                        <center><button type="submit" id="btn_passar_servico" class="btn btn-success">Fechar e passar serviço</button></center>
                    </div>
                </form>
            </div>
        </div>
        <center>
            <h3>
                <div class="label label-danger"><kbd>IMPRIMA</kbd>, <kbd>assine</kbd> e <kbd>entregue</kbd> os relatórios ao SCmt e FiscAdm!
                </div>
            </h3>
        </center>
    </div>
</div>