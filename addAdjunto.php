<?php
$consultar_servicos_sem_adj = $pdo->prepare("SELECT * FROM aosubcmt where assinaturaAdj = '' ORDER BY doDia DESC LIMIT 100");
$consultar_servicos_sem_adj->execute();
?>

<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Adicionar Adjunto ao serviço</center>
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
                <form class="form-horizontal" id="form_adicionar_adjunto" action="" enctype="multipart/form-data" method="POST">
                    <label for="inputDodia" class="col-xs-12 col-sm-12 col-md-3 col-lg-2">Do dia</label>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <select class="form-control form-control" name="doDia" id="doDia">
                            <option value="Selecione"><?php echo "Selecione um serviço"; ?></option>
                            <?php while ($resu = $consultar_servicos_sem_adj->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $resu['doDia']; ?>"><?php echo "" . date("d-M-Y", strtotime($resu['doDia'])) . ""; ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <?php
                    $consultar_adjuntos = $pdo->prepare("SELECT * FROM `usuarios` where user_nivel='1' ORDER BY `usuarios`.`user_nome` asc");
                    $consultar_adjuntos->execute();
                    ?>
                    <label class="col-xs-12 col-sm-12 col-md-3 col-lg-2">Selecione um militar</label>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                        <select class="form-control form-control hidden-print" name="adj" id="adj">
                            <option value="Selecione"><?php echo "Selecione um militar"; ?></option>
                            <?php while ($resu = $consultar_adjuntos->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $resu['assinatura']; ?>">
                                    <?php echo "" . ($resu['grad']) . ""; ?>
                                    <?php echo "" . ($resu['user_nome']) . ""; ?>
                                </option>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="acao" value="adicionar_adjunto">
                        <center><button type="submit" id="btn_adicionar_adjunto" class="btn btn-success">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>