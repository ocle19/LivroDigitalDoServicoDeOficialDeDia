<?php
session_start();
include "config.php";
include "connection.php";
include "connectionMilitares.php";
include "protegerPagina.php";
protegerPagina();

$user              =  filter_var($_SESSION["user_id"], FILTER_SANITIZE_NUMBER_INT);
$consultausuariologado = $pdo->prepare("SELECT * FROM usuarios where user_id = :user");
$consultausuariologado->bindParam(':user', $user);
$consultausuariologado->execute();
$resultados = $consultausuariologado->fetch(PDO::FETCH_ASSOC);
$id           = $resultados['user_id'];
$nome         = $resultados['user_nome'];
$grad         = $resultados['grad'];
$nomecompleto = $resultados['user_nomecompleto'];
$nivel        = $resultados['user_nivel'];
$assinatura   = $resultados['assinatura'];
$_SESSION['nivel'] = $nivel;
?>


<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo SITE_NOME; ?></title>
  <link rel="icon" href="favicon.ico">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <link href="assets/css/swal.css?<?php echo VERSAO; ?>" rel="stylesheet">
  <script src="assets/js/swal.js?<?php echo VERSAO; ?>"></script>
  <style>
    .update-nag {
      display: inline-block;
      font-size: 14px;
      text-align: left;
      background-color: #fff;
      height: 40px;
      -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .2);
      box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
      margin-bottom: 10px;
    }

    .update-nag:hover {
      cursor: pointer;
      -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .4);
      box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .3);
    }

    .update-nag>.update-split {
      background: #337ab7;
      width: 33px;
      float: left;
      color: #fff !important;
      height: 100%;
      text-align: center;
    }

    .update-nag>.update-split>.glyphicon {
      position: relative;
      top: calc(50% - 9px) !important;
      /* 50% - 3/4 of icon height */
    }

    .update-nag>.update-split.update-success {
      background: #5cb85c !important;
    }

    .update-nag>.update-split.update-danger {
      background: #d9534f !important;
    }

    .update-nag>.update-split.update-info {
      background: #5bc0de !important;
    }



    .update-nag>.update-text {
      line-height: 19px;
      padding-top: 11px;
      padding-left: 45px;
      padding-right: 20px;
    }
  </style>
</head>

<?php
include "menu.php";
?>

<body>
  <?php
  if (isset($saiuu)) {
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('d-m-Y H:i:s');
  } else {
    if (isset($_GET["func"])) {
      $page = $_GET["func"];
      include "$page.php";
    } else {
      $usuario = $nome;
  ?>
      <div class="container theme-showcase" role="main">
        <div class="panel-group">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <center> Bem vindo ao Sistema de Serviço, <font color='yellow'><?php echo "$grad $nomecompleto"; ?> </font>.</center>
            </div>

            <div class="panel-body">
              <?php

              if ($nivel == 1) { ?>
                <a href="#" onclick="window.open('ajudaADJ.pdf', 'Como criar um novo serviço', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10');">Clique aqui caso tenha alguma dúvida sobre o Sistema.</a>
              <?php
              }
              ?>
              <?php
              if ($nivel == 2) { ?>
                <a href="#" onclick="window.open('ajudaOF.pdf', 'Ajuda Oficial de Dia', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10');">Clique aqui caso tenha alguma dúvida sobre o Sistema.</a>
              <?php
              }
              ?>

              <div class="container">
                <?php
                include "check.php";
                ?>
              </div>
            </div>
        <?php
      }
    }
        ?>
          </div>
        </div>
      </div>
      </div>
      <footer>
        <div class="text-center center-block">

          <p class="txt-railway">
            <font color="blue"><a href="https://clebersiqueira.com.br" target="_blank" rel="noopener noreferrer">Desenvolvido por Cleber Siqueira.</a>
          </p>
        </div>
      </footer>

</body>

</html>
<script type="text/javascript" src="assets/js/scripts.js?<?php echo VERSAO; ?>"></script>