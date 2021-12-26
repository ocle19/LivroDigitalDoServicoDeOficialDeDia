<style>
  .menu .nav>li>a {
    padding-top: 15px;
    padding-bottom: 0px;
  }

  .menu .navbar-toggle {
    padding: 1px;
  }
</style>
<div class="menu">
  <nav class="navbar navbar-inverse navbar-static-top ">
    <div class="container">

    </div>
    <div id="navbar3" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="">
          <a href="painel.php" class="navbar-nav" role=""><span class="glyphicon glyphicon-dashboard"></span> Painel</a>
        </li>

        <?php
        if ($nivel == 1) {
        ?>
          <li class="">
            <a href="painel.php?func=addServico" class="navbar-nav" role=""><span class=" 	glyphicon glyphicon-play-circle"></span> Novo serviço</a>
          </li>

          <li class="">
            <a href="painel.php?func=addServicoPunidos" class="navbar-nav" role=""><span class="glyphicon glyphicon-ban-circle 	glyphicon glyphicon-alert"></span> Adicionar punidos</a>
          </li>

        <?php
        }
        if ($nivel == 1 or $nivel == 2) {; //OR ($_SESSION['usuarioNivel'] == 2 )){
        ?>
          <li class="">
            <a href="painel.php?func=editarServico" class="navbar-nav" role=""><span class="glyphicon glyphicon-edit"></span> Editar Serviço</a>
          </li>

        <?php
        }

        if ($nivel == 2) {
        ?>

          <li class="">
            <a href="painel.php?func=addServicoPassagem" class="navbar-nav" role=""><span class="glyphicon glyphicon-transfer"></span> Passar</a>
          </li>


          <li class="">
            <a href="painel.php?func=voltarSv" class="navbar-nav" role=""><span class="glyphicon glyphicon-transfer"></span> Voltar serviço</a>
          </li>
        <?php
        }

        if ($nivel == 6) {
        ?>

          <li class="">
            <a href="painel.php?func=novoUsuario" class="navbar-nav" role=""><span class="glyphicon glyphicon-dashboard"></span> Novo Usuário</a>
            <a href="painel.php?func=addAdjunto" class="navbar-nav" role=""><span class="glyphicon glyphicon-dashboard"></span> Add Adjunto ao SV</a>
            <a href="painel.php?func=voltarSv" class="navbar-nav" role=""><span class="glyphicon glyphicon-dashboard"></span> Voltar Sv</a>
          </li>
        <?php
        }
        ?>

        <li class="dropdown">
          <a href="painel.php?func=relatorioServico" class="navbar-nav" role=""><span class="glyphicon glyphicon-list-alt"></span> Gerar Relatório</a>
        </li>

        <li class="dropdown" class="nav navbar-right">
          <a href="index.php?func=sairPagina" class="navbar-right" role=""><span class="glyphicon glyphicon-off"></span> Sair
            <span class="label label-warning"><?php echo "$grad $nomecompleto"; ?></span></a>


        </li>
      </ul>
    </div>
</div>

</nav>

</div>