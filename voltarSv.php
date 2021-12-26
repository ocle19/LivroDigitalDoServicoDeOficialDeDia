<head>
    <title> <?php echo SITE_NOME; ?> -Voltar Serviço</title>
</head>
<?php
$grad                = $grad;
$selecionaof         = strtoupper($nome);
$diaHoje             = date('Y-m-d');
$ofdia = $grad . ' ' . $selecionaof;
if ($nivel >= 6) {
    $consultafaltapassar = $pdo->prepare("SELECT * FROM aosubcmt Where passeiAo <> '' ORDER BY doDia DESC LIMIT 15");
} else {
    $consultafaltapassar = $pdo->prepare("SELECT * FROM aosubcmt Where passeiAo <> '' and ofdia = :ofdia and paraOdia = :paraOdia ORDER BY doDia DESC LIMIT 1");
    $consultafaltapassar->bindParam(':ofdia', $ofdia);
    $consultafaltapassar->bindParam(':paraOdia', $diaHoje);
}
$consultafaltapassar->execute();

$consultatotalsv     = $pdo->prepare("SELECT * FROM `aosubcmt` WHERE DAYOFWEEK(aosubcmt.doDia) BETWEEN 1 AND 5 ORDER BY `id` ASC;");
$consultatotalsv->execute();
$numerodoc           = $consultatotalsv->rowCount() + 8;
?>
<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Voltar serviço para o modo de edição</center>
            </div>
            <div class="panel-body">
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
                <center>
                    <h5>SÓ PODE SER USADO NA DATA ( para o dia ) DO SEU SERVIÇO</h5>
                </center>
                <form class="form-horizontal" id="form_voltar_servico" action="" enctype="multipart/form-data" method="POST">
                    <div class="form-group">
                        <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Do dia</label>
                                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                    <select class="form-control form-control-inline" name="doDia" id="doDia">
                                        <option value="Selecione"><?php echo "Selecione um serviço"; ?></option>
                                        <?php while ($resu = $consultafaltapassar->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $resu['doDia']; ?>"><?php echo "" . date("d-M-Y", strtotime($resu['doDia'])) . ""; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="acao" value="voltar_servico">
                                <center><button type="submit" id="btn_voltar_servico" class="btn btn-success">Voltar o serviço ao modo edição</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>