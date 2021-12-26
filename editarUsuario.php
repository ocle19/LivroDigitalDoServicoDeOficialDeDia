<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</head>
<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Editar Usuário</center>
            </div>

            <div class="panel-body">
                <?php
                if ($_GET['id'] != '') {
                    $id                    = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                    $consultar_dados_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE user_id = :id");
                    $consultar_dados_usuario->bindParam(':id', $id);
                    $consultar_dados_usuario->execute();
                    $resultado_dados_usuario = $consultar_dados_usuario->fetch(PDO::FETCH_ASSOC);

                    $idmilitarEditar    = $resultado_dados_usuario['user_id'];
                    $nomeEditar         = $resultado_dados_usuario['user_nome'];
                    $gradEditar         = $resultado_dados_usuario['grad'];
                    $nomecompletoEditar = $resultado_dados_usuario['user_nomecompleto'];
                    $senhaEditar        = $resultado_dados_usuario['user_senha'];
                    $nivelEditar        = $resultado_dados_usuario['user_nivel'];
                    $assinaturaEditar   = $resultado_dados_usuario['assinatura'];
                    $statusEditar       = $resultado_dados_usuario['status'];

                ?>
                    <form class="form-horizontal" id="form_editar_usuario" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Nome Completo</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" maxlength="50" name="nomecompleto" value="<?php echo $nomecompletoEditar; ?>" required autofocus />
                                <input type="hidden" name="usuario" value="<?php echo $idmilitarEditar; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Nome de Guerra</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" maxlength="20" name="nome" value="<?php echo $nomeEditar; ?>" required autofocus />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Graduação</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="grad" id="grad">
                                    <option value="<?php echo $gradEditar; ?>"><?php echo $gradEditar; ?></option>
                                    <optgroup label="Cmt Fração">
                                        <option value="3º Sgt">3º Sargento</option>
                                        <option value="2º Sgt">2º Sargento</option>
                                        <option value="1º Sgt">1º Sargento</option>
                                    </optgroup>
                                    <optgroup label="Cmt Pel">
                                        <option value="Asp Of">Aspirante</option>
                                        <option value="2º Ten">2º Tenente</option>
                                        <option value="1º Ten">1º Tenente</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Tipo de perfil</label>
                            <div class="col-sm-4">

                                <select class="form-control" name="nivel" id="nivel">
                                    <?php
                                    if ($nivelEditar == 1) {
                                        $nivelstring = "Adjunto ao Oficial de Dia";
                                    }
                                    if ($nivelEditar == 2) {
                                        $nivelstring = "Oficial de Dia";
                                    }
                                    if ($nivelEditar == 4) {
                                        $nivelstring = "Consulta";
                                    }
                                    if ($nivelEditar == 6) {
                                        $nivelstring = "Administrador";
                                    }
                                    ?>
                                    <option value="<?php echo $nivelEditar; ?>"><?php echo $nivelstring; ?></option>

                                    <option value="1"> Adjunto ao Oficial de Dia</option>
                                    <option value="2"> Oficial de Dia</option>
                                    <option value="4"> Consulta</option>
                                    <?php
                                    if ($nivel == 6) {
                                    ?>
                                        <option value="6">Administrador</option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Senha</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?php echo $senhaEditar; ?>" maxlength="20" name="senha" required autofocus />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">STATUS</label>
                            <div class="col-sm-2">
                                <select class="form-control  hidden-print" id="status" name="status">

                                    <option value="<?php echo $statusEditar; ?>"><?php echo $statusEditar; ?></option>
                                    <option value="ATIVADO">ATIVADO</option>
                                    <option value="DESATIVADO">DESATIVADO</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="acao" value="editar_usuario">
                        <center><button type="button" id="btn_editar_usuario" class="btn btn-success">Salvar</button> </center>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php

                } else {
                    echo "Selecione um militar!";
                }
?>