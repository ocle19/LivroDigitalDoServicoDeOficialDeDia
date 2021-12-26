<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Adjuntos ao Oficial de Dia</center>
            </div>
            <div class="panel-body">
                <table class="table">
                    <?php
                    $consultar_adjuntos = $pdo->prepare("SELECT * FROM usuarios WHERE user_nivel = '1' ORDER BY status, user_nome asc");
                    $consultar_adjuntos->execute();
                    $tabela = "
                    <div class='table-responsive'>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>GRAD</th>
                                    <th>Nome</th>
                                    <th>Nome Completo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>";
                    $return = "$tabela";
                    while ($linha = $consultar_adjuntos->fetch(PDO::FETCH_ASSOC)) {
                        $return .= " <tbody><tr class=''>";
                        $return .= "<td>" . ($linha["grad"]) . "</td>";
                        $return .= "<td>" . ($linha["user_nome"]) . "</td>";
                        $return .= "<td>" . ($linha["user_nomecompleto"]) . "</td>";
                        $return .= "<td><b>" . ($linha["status"]) . "</td>";
                        if ($nivel > 3) {
                            $return .= "<td><BR><a href='painel.php?func=editarUsuario&id=" . ($linha["user_id"]) . "'<button type='button' class='btn btn-sm btn-warning'>Editar</button></a></td>";
                        }
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