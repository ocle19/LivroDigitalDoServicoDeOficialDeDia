<?php
include "connection.php";
include "sairPagina.php";
sairPagina();

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo SITE_NOME; ?></title>
    <link rel="icon" href="favicon.ico">
    <link rel="shortcut icon" href="favicon.ico" title="Favicon" />
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/estilo.css?<?php echo VERSAO; ?>" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/font-awesome/css/font-awesome.min.css">
    <link href="assets/css/swal.css?<?php echo VERSAO; ?>" rel="stylesheet">
    <script src="assets/js/swal.js?<?php echo VERSAO; ?>"></script>
</head>

<body>
    <br> <br>
    <div class="container">
        <h3 align="center"><?php echo SITE_NOME; ?></h3></br>
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
            <form id='form_login' class="form" action="" method="post">
                <div align="center">
                    <h4>Entre com suas credenciais</h4>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user fa-fw">
                            </i>
                        </span>
                        <input type="text" maxlength="150" name="usuario" class="form-control" placeholder="Usuário" required autofocus />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-key fa-fw">
                            </i>
                        </span>
                        <input type="password" maxlength="150" name="senha" class="form-control" placeholder="Senha" required />
                    </div>
                </div>
                <br>
                <input type="hidden" name="acao" value="validar">
                <button type="submit" id='btn_logar' name="logar" class="btn btn-primary btn-lg btn-block" />Entrar</button>
            </form>
        </div>
    </div>

    </div>
    <br> <br>
    <h6 align="center"><a href="https://clebersiqueira.com.br" target="_blank" rel="noopener noreferrer">Desenvolvido por Cleber Siqueira.</a></h6>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js?<?php echo VERSAO; ?>"></script>
</body>

</html>