<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Punições ativas</center>
            </div>
            <div class="panel-body">
                </center>
                <table class="table">
                    <?php
                    $data               = date('Y-m-d');
                    $consultar_punidos = $pdo->prepare("SELECT * FROM punidos where :dataCheck BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
                    $consultar_punidos->bindParam(':dataCheck', $data);
                    $consultar_punidos->execute();
                    if ($consultar_punidos->rowCount() > 0) {
                        $tabela = "
                    <div class='table-responsive'>
                        <table class='table table-striped'>
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
                                    <th>AÇÃO</th>
                                </tr>
                            </thead>";
                        $return = "$tabela";
                        while ($linha = $consultar_punidos->fetch(PDO::FETCH_ASSOC)) {
                            $idPunicao    = $linha["id"];
                            $datax2       = date("d-m-Y", strtotime($linha['liberdade']));
                            $data_inicio  = new DateTime($linha['inicio']);
                            $data_fim     = new DateTime($linha['liberdade']);
                            $dateInterval = $data_inicio->diff($data_fim);
                            $return .= " <tbody><tr id='punicao$idPunicao'>";
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

                            $return .= '<td> <a type="button" class="btn btn-sm btn-danger" onclick="deletarPunicao('.$idPunicao.')"> EXCLUIR</a> </td>';

                            $return .= "</tr>";
                        }
                        echo $return .= "</tbody>
                        </table>
                    </div>";
                    } else {
                        echo "<td><center>Não há.</center></td>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>