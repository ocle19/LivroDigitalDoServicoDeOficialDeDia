<head>
    <title> <?php echo SITE_NOME; ?> - Punições Encerradas</title>
</head>

<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-body">
                <br>
                <center>
                    <h3>
                        <div><span class='label label-success'>Punições Encerradas<br></span></div>
                    </h3>
                </center>
                <table class="table">
                    <?php
                    $data               = date('Y-m-d');
                    $consultanomePunido = $pdo->prepare("SELECT * FROM punidos WHERE liberdade <= :dataCheck ORDER BY `punidos`.`liberdade` DESC");
                    $consultanomePunido->bindParam(':dataCheck', $data);
                    $consultanomePunido->execute();
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
                                </tr>
                            </thead>";
                    $return = "$tabela";

                    while ($linha = $consultanomePunido->fetch(PDO::FETCH_ASSOC)) {

                        $datax2       = date("d-m-Y", strtotime($linha['liberdade']));
                        $data_inicio  = new DateTime($linha['inicio']);
                        $data_fim     = new DateTime($linha['liberdade']);
                        $dateInterval = $data_inicio->diff($data_fim);
                        $return .= " <tbody><tr>";
                        $return .= "<td>" . ($linha["graduacao"]) . "</td>";
                        $return .= "<td>" . ($linha["numero"]) . "</td>";
                        $return .= "<td>" . ($linha["nomecompleto"]) . "</td>";
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

                        $return .= "</tr>";
                    }
                    echo $return .= "</tbody>
                        </table>
                    </div>"; ?>
                </table>
            </div>
        </div>
    </div>
</div>