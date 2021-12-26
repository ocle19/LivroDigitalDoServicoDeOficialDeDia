<head>
    <title> <?php echo SITE_NOME; ?> - Oficiais</title>
</head>
<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Oficiais de Dia</center>
            </div>
            <div class="panel-body">
                <table class="table">
                    <?php
                    $consultar_oficiais = $pdo->prepare("SELECT * FROM usuarios WHERE user_nivel = '2' ORDER BY status, user_nome asc");
                    $consultar_oficiais->execute();
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
                    while ($linha = $consultar_oficiais->fetch(PDO::FETCH_ASSOC)) {

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