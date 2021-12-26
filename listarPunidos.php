<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Lista de punidos</center>
            </div>
            <div class="panel-body">
                <form id="form_Relatorio" action="" method="POST">
                    <?php
                    include "connection.php";
                    $consultar_punidos = $pdo->prepare("SELECT * FROM punidos GROUP BY nomecompleto ORDER BY nomecompleto ASC ");
                    $consultar_punidos->execute();
                    ?>
                    <div class="form-group">
                        <label for="inputDodia1" class="col-xs-6 col-sm-6 col-md-2 col-lg-2">Nome do punido </LABEL>
                        <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                            <select class="form-control form-control-inline" name="nomecompleto" id="nomecompleto">
                                <option value="Selecione"><?php echo "Selecione um Militar"; ?></option>
                                <?php while ($resunomepunido = $consultar_punidos->fetch(PDO::FETCH_ASSOC)) {
                                    $gradpunido         = $resunomepunido['graduacao'];
                                    $nomecompletopunido = strtoupper($resunomepunido['nomecompleto']);
                                ?>
                                    <option value="<?php echo "$nomecompletopunido"; ?>"><?php echo "$gradpunido $nomecompletopunido"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <center><button type="submit" name="buttonPorNome" class="btn btn-success">Pesquisar por nome</button> <br>
                            Para gerar um relatório geral, deixei selecionado 'Selecione um Militar' e clique em pesquisar por nome.</center </div>
                </form>


                <?php
                if (isset($_POST["buttonPorNome"]) and ($_POST["nomecompleto"] != "")) {

                    $nomecomPunido = filter_input(INPUT_POST, 'nomecompleto', FILTER_SANITIZE_STRING);

                    if ($nomecomPunido != "Selecione") {
                        echo "<br><center><h3><div><span class='label label-success'>Relatório de punições do $nomecomPunido <br></span></div></h3></center>";
                        $consultar_dados_punido = $pdo->prepare("SELECT * FROM punidos WHERE nomecompleto =:nomecomPunido");
                        $consultar_dados_punido->bindParam(':nomecomPunido', $nomecomPunido);
                        $consultar_dados_punido->execute();
                    }
                    if ($nomecomPunido == "Selecione") {
                        echo "<br><center><h3><div><span class='label label-success'>Relatório de todas as punições<br></span></div></h3></center>";
                        $consultar_dados_punido = $pdo->prepare("SELECT * FROM `punidos` ORDER BY `punidos`.`liberdade` desc");
                        $consultar_dados_punido->execute();
                    }

                ?>
                    <form>
                        <table class="table">
                            <?php
                            $tabela = "
                    <div class='table-responsive'>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>GRAD</th>
                                    <th>Nº</th>
                                    <th>Nome</th>
                                    <th>SU</th>
                                    <th>Inicio</th>
                                    <th>Liberdade</th>
                                    <th>Dias</th>
                                    <th>Punição</th>
                                    <th>BI</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>";
                            $return = "$tabela";
                            while ($linha = $consultar_dados_punido->fetch(PDO::FETCH_ASSOC)) {
                                $id_punicao = $linha['id'];
                                $datax2       = date("d-m-Y", strtotime($linha['liberdade']));
                                $data_inicio  = new DateTime($linha['inicio']);
                                $data_fim     = new DateTime($linha['liberdade']);
                                $dateInterval = $data_inicio->diff($data_fim);
                                $return .= " <tbody><tr class='danger' id='punicao$id_punicao'>";
                                $return .= "<td>" . ($linha["graduacao"]) . "</td>";
                                $return .= "<td>" . ($linha["numero"]) . "</td>";
                                $return .= "<td>" . strtoupper($linha["nomecompleto"]) . "</td>";
                                $return .= "<td>" . ($linha["su"]) . "</td>";
                                $return .= "<td>" . (date("d-m-Y", strtotime($linha["inicio"]))) . "</td>";
                                $return .= "<td>" . (date("d-m-Y", strtotime($linha["liberdade"]))) . "</td>";
                                $return .= "<td>" . ($dateInterval->days) . "</td>";

                                if ($linha['punicao'] == '1') {
                                    $return .= "<td class='td'><b><font color='blue'>Advertência</font></b></td>";
                                }
                                if ($linha['punicao'] == '2') {
                                    $return .= "<td class='td'><b><font color='green'>Impedimento Disciplinar</font></b></td>";
                                }

                                if ($linha['punicao'] == '3') {
                                    $return .= "<td class='td'><b><font color='black'>Repreensão</font></b></td>";
                                }

                                if ($linha['punicao'] == '4') {
                                    $return .= "<td class='td'><b><font color='orange'>Detenção</font></b></td>";
                                }

                                if ($linha['punicao'] == '5') {
                                    $return .= "<td class='td'><b><font color='purple'>Prisão</font></b></td>";
                                }

                                $return .= "<td>" . utf8_encode($linha["bi"]) . "</td>";
                                if ($nivel != 4) {

                                    $return .= "<td><a type='button' class='btn btn-sm btn-danger' onclick='deletarPunicao($id_punicao)'>EXCLUIR</a> 	</td>";
                                } else {
                                    $return .= "<td><button type='button' class='btn btn-sm btn-danger disabled' disabled >EXCLUIR</button> 	</td>";
                                }
                                $return .= "</tr>";
                            }
                            echo $return .= "</tbody></table></table>";
                            ?>
                        </table>
                    </form>
            </div>
        </div>
    </div>
<?php

                } else {
                    echo "<br><span class='label label-danger'> Selecione um nome ou clique em pesquisar por nome para obter a lista completa de punidos</span>";
                }
