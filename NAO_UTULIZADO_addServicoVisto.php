<head>
    <title> <?php echo SITE_NOME; ?> - Passar Serviço</title>
</head>
<?php
$grad        = $grad;
$selecionaof = strtoupper($nome);
//$consultafaltapassar = $mysqli->query("SELECT * FROM aosubcmt Where passeiAo ='' and vistoScmt = 'NO' ORDER BY doDia ASC LIMIT 0,5");

if ($nivel == 3) {
    $consultafaltapassar = $mysqli->query("SELECT * FROM aosubcmt Where (passeiAo !='' and vistoFiscal = 'NO') ORDER BY doDia DESC");
    $consultanrdocANO    = $mysqli->query("SELECT YEAR(doDia) as ANO ,COUNT(*) as TOTAL FROM aosubcmt where YEAR(doDia) ='2019'  GROUP BY YEAR(doDia)");
    $numero              = $consultanrdocANO->fetch_array();
}
if ($nivel == 4) {
    $consultafaltapassar = $mysqli->query("SELECT * FROM aosubcmt Where (passeiAo !='' and vistoScmt = 'NO') ORDER BY doDia DESC");
    $consultanrdocANO    = $mysqli->query("SELECT YEAR(doDia) as ANO ,COUNT(*) as TOTAL FROM aosubcmt where YEAR(doDia) ='2019'  GROUP BY YEAR(doDia)");
    $numero              = $consultanrdocANO->fetch_array();
}

$consultadiadoAnoSV = $mysqli->query("SELECT * FROM aosubcmt where   passeiAo ='' and ofdia = '$grad $selecionaof' ORDER BY doDia ASC LIMIT 0,1");
$resultadododia     = $consultadiadoAnoSV->fetch_array();

$datadosv = getdate(strtotime($resultadododia["doDia"]));

if ($datadosv["year"] >= 2020) {
    $numerodoc = $datadosv["yday"] + 1;
}; //var_dump($datadosv);
?>

<div class="container container-fluid" role="main">
    <div class="panel-group">
        <div class="panel panel-default">
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
                <form class="form-horizontal" action="" enctype="multipart/form-data" method="POST">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <center>Serviços que faltam algum tipo de visto digital</center>
                        </div>


                        <div class="panel-body">
                            <div class="form-group">

                                <div class="form-group">
                                    <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Do dia</label>
                                    <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                        <select class="form-control form-control-inline" name="doDia" id="doDia">

                                            <option value="Selecione"><?php echo "Selecione um serviço"; ?></option>
                                            <?php while ($resu = $consultafaltapassar->fetch_array()) {
                                                $adjuntu  = str_replace(".jpg", "", $resu['assinaturaAdj']);
                                                $adjuntoC = str_replace(".png", "", $adjuntu);
                                            ?>

                                                <option value="<?php echo $resu['doDia']; ?>"><?php echo "DIA DO SV: " . date("d-m-Y", strtotime($resu['doDia'])) . " - OF DIA: " . $resu['ofdia'] . " - ADJ: " . $adjuntoC . " "; ?></option>
                                            <?php } ?>
                                        </select>
                                        OBS: Os serviços só aparecem após serem passados digitalmente
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-3 col-lg-2">Assinar como</LABEL>
                                    <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                        <select class="form-control form-control-inline" name="passeiAo" id="passeiAo">
                                            <?php

                                            if ($nivel == 4) {
                                            ?>
                                                <option value="SCMT">SCMT</option>

                                            <?php
                                            }
                                            ?>

                                            <?php

                                            if ($nivel == 3) {
                                            ?>
                                                <option value="FISCAL">FISCAL</option>

                                            <?php

                                            }
                                            ?>


                                        </select>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <center><button type="submit" name="button" class="btn btn-success">Assinar serviço selecionado</button>

                                </div>
                            </div>
                        </div>
                        <?php if ($numerodoc != "") { ?>
                            <center>
                                <h3>
                                    <div class="label label-danger"><kbd>IMPRIMA</kbd>, <kbd>assine</kbd> e <kbd>entregue</kbd> os relatórios ao SCmt e FiscAdm!

                                    </div>
                                </h3>
                            </center>

                        <?php }

                        ?>

                        <?php

                        if (isset($_POST["button"]) and ($_POST["passeiAo"] != "Selecione") and ($_POST["doDia"] != "Selecione")) {

                            $doDia1   = $_POST["doDia"];
                            $passeiAo = $_POST["passeiAo"];
                            $diiia    = date('d-m-Y', strtotime($doDia1));
                            if ($passeiAo == "SCMT") {
                                $passeiAo      = "OK";
                                $query_passasv = $mysqli->prepare("UPDATE `aosubcmt` SET `vistoScmt` = ? WHERE `aosubcmt`.`doDia` = ?");
                                $query_passasv->bind_param('ss', $passeiAo, $doDia1);
                                $query_passasv->execute();

                                if ($query_passasv) {
                                    echo "<script> alert('O serviço do dia $diiia foi assinado digitalmente como SCMT com sucesso!');window.location.href=window.location;</script>";
                                } else {
                                    echo "<script> alert('Erro ao dar visto no serviço!');window.location.href=window.location; </script>";
                                }
                            }

                            if ($passeiAo == "FISCAL") {
                                $passeiAo      = "OK";
                                $query_passasv = $mysqli->prepare("UPDATE `aosubcmt` SET `vistoFiscal` = ? WHERE `aosubcmt`.`doDia` = ?");
                                $query_passasv->bind_param('ss', $passeiAo, $doDia1);
                                $query_passasv->execute();
                                if ($query_passasv) {
                                    echo "<script> alert('O serviço do dia $diiia foi assinado digitalmente pelo FISCAL com sucesso!');window.location.href=window.location;</script>";
                                } else {
                                    echo "<script> alert('Erro ao dar visto no serviço!');window.location.href=window.location; </script>";
                                }
                            }

                            // }

                        }

                        ?>


                    </div>
            </div>

        </div>


        </form>
    </div>
</div>
</div>
</div>

<script>
    function PorximoAdj() {
        // alert("Próximo passo: GERAR O RELATÓRIO E ENVIAR AO SCMT E FISCAL");
    }
</script>