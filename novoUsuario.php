<head>
  <title> <?php echo SITE_NOME; ?> - Criar usuário</title>
</head>
<script>
  function formatar(mascara, documento) {
    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida) {
      documento.value += texto.substring(0, 1);
    }
  }
</script>
<div class="container theme-showcase" role="main">
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <center>Adicionar militar ( ADJ / OF Dia )</center>
      </div>
      <div class="panel-body">

        <form class="form-horizontal" id="form_cadastrar_usuario" enctype="multipart/form-data" method="POST">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Nome Completo</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" maxlength="50" name="nomecompleto" required autofocus />
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Nome de Guerra</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" maxlength="20" name="nome" required autofocus />
            </div>
          </div>


          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Graduação</label>
            <div class="col-sm-2">
              <select class="form-control" name="grad" id="grad">
                <optgroup label="Praça">
                  <option value="2º Sgt">2º Sargento</option>
                  <option value="1º Sgt">1º Sargento</option>
                  <option value="Cad">Cadete</option>
                </optgroup>
                <optgroup label="Oficiais">
                  <option value="Asp Of">Aspirante</option>
                  <option value="2º Ten">2º Tenente</option>
                  <option value="1º Ten">1º Tenente</option>
                  <option value="Cap">Capitão</option>
                  <option value="Maj">Major</option>
                  <option value="TC">Tenente Coronel</option>
                  <option value="Cel">Coronel</option>
                </optgroup>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Tipo de perfil</label>
            <div class="col-sm-2">

              <select class="form-control" name="nivel" id="nivel">
                <option value="1">Adjunto Of Dia</option>
                <option value="2">Oficial de Dia</option>
                <option value="3">Fiscal Administrativo</option>
                <option value="4">Sub Comandante</option>
                <option value="5">Comandante</option>
                <?php

                if ($nivel == 3) {
                ?>
                  <option value="5">Administrador</option>
                <?php

                }
                ?>

              </select>

            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Senha</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" maxlength="15" name="senha" required autofocus />
            </div>
          </div>



          <!--div class="form-group">
			<label for="foto" class="col-sm-4 control-label">Assinatura</label>
			<div class="col-sm-4">
			  <input type="file" class="form-control" id="assinatura" name="assinatura"required autofocus />
			   <p class="help-block">Nome da assinatura deve ser <strong>CURTO!</strong></p>

			</div>
		  </div-->
                <input type="hidden" name="acao" value="cadastrar_usuario">
          <div class="form-group">
            <center><button type="button" id="btn_cadastrar_usuario" class="btn btn-success">Cadastrar usuário</button>
          </div>
        </form>