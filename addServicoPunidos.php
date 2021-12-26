<script type="text/css" src="assets/jquery-autocomplete/jquery.autocomplete.css"></script>
<script type="text/javascript" src="assets/jquery-autocomplete/lib/jquery.js"></script>
<script type="text/javascript" src="assets/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="assets/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="assets/jquery-autocomplete/lib/thickbox-compressed.js"></script>
<script type="text/javascript" src="assets/jquery-autocomplete/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="assets/jquery-autocomplete/jquery.autocomplete.css" />
<?php
$removeExt = explode('.', $assinatura);
$assinatura = "%" . $removeExt[0] . "%";
$consultadiassv = $pdo->prepare("SELECT * FROM aosubcmt where (assinaturaAdj LIKE :assinaturaAdj) and assinaturaOfDia ='' ORDER BY doDia  ASC");
$consultadiassv->bindParam(':assinaturaAdj', $assinatura);
$consultadiassv->execute();
$result = $consultadiassv->rowCount();

?>

<div class="container theme-showcase" role="main">
    <div class="panel-group">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <center>Adicionar punido</center>
            </div>
            <div class="panel-body">
                <a href="#" onclick="window.open('ajudaADJ.pdf', 'Como criar um novo serviço', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=770, HEIGHT=900');">Clique aqui caso tenha alguma dúvida.</a>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <center>Selecione o seu SV</center>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Do dia</label>
                            <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                                <select class="form-control form-control-inline" name="doDia" id="doDia" onchange="validar()">
                                    <option value="Selecione"><?php echo "Selecione um serviço"; ?></option>
                                    <?php while ($resu = $consultadiassv->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $resu['doDia']; ?>"><?php echo "" . date("d-M-Y", strtotime($resu['doDia'])) . ""; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-success" id="painelInserirPunido" style="display:none">
                    <div class="panel-heading">
                        <center>Pesquisar militar e adicionar punição</center>
                    </div>
                    <div class="panel-body">

                        <div class="panel-body">
                            <div class="form-group">

                                <div class="col-xs-4 col-sm-10 col-md-8 col-lg-8">
                                    Digite o NOME DE GUERRA ou NÚMERO para pesquisar os dados do militar.
                                    <form id="search" action="#">
                                        <div class="search"></div>
                                        <input type="text" class="form-control" maxlength="500" placeholder="Digite o NOME DE GUERRA ou NÚMERO" onkeypress="validar()" id="porNomeNumero" name="porNomeNumero" />
                                    </form>
                                    Após a busca, clique no nome do militar para inserir automaticamente alguns dos dados nos campos abaixo
                                </div>
                            </div>
                            Caso falte um militar, entre em contato com o furriel e verifique se o militar encontra-se no sistema de Arranchamento.
                        </div>
                    </div>
                    <div class="form-class">
                        <form class="form-horizontal" id="form_cadastrar_punicao" action="" method="post">
                            <table class="table table-responsive">
                                <thead>
                                    <center>
                                        <tr>
                                            <th class="col-xs-4 col-sm-4 col-md-2 col-lg-2">Grad</th>
                                            <th class="col-xs-4 col-sm-4 col-md-3 col-lg-2">Nº do militar</th>
                                            <th class="col-xs-4 col-sm-4 col-md-12  col-lg-12">Nome <STRONG>COMPLETO</STRONG></th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="grad" id="grad">
                                                <optgroup label="Praça">
                                                    <option value="Sd Ef Vrl">Sd Ev</option>
                                                    <option value="Sd Ef Pfl">Sd Ep</option>
                                                    <option value="Cb Ef Vrl">Cb Ev</option>
                                                    <option value="Cb Ef Pfl">Cb Ep</option>
                                                    <option value="3º Sgt">3º Sgt</option>
                                                    <option value="2º Sgt">2º Sgt</option>
                                                    <option value="1º Sgt">1º Sgt</option>
                                                    <option value="S Ten">S Ten</option>
                                                </optgroup>
                                                <optgroup label="Oficiais">
                                                    <option value="Asp Of">Asp Of</option>
                                                    <option value="2º Ten">2º Ten</option>
                                                    <option value="1º Ten">1º Ten</option>
                                                    <option value="Cap">Cap</option>
                                                    <option value="Maj">Maj</option>
                                                    <option value="TC">Ten Cel</option>
                                                    <option value="CEL">Cel</option>
                                                </optgroup>
                                            </select>
                                        </td>
                                        <td><input class="form-control" type="text" maxlength="3" id="numero" name="numero" min="50" placeholder="410" value="0" required autofocus /></td>
                                        <td><input class="form-control" type="text" maxlength="50" id="nomecompleto" name="nomecompleto" placeholder="" required autofocus /></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-responsive">
                                <thead>
                                    <center>
                                        <tr>
                                            <th>Subunidade</th>
                                            <th>Inicio</th>
                                            <th>Liberdade</th>
                                            <th>Punição</th>
                                            <th>BI</th>
                                        </tr>
                                    </center>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control" name="su" id="su">
                                                <optgroup label="Baterias">
                                                    <option value="BC">Bateria de Comando</option>
                                                    <option value="1ªBO">1ª Bateria de Obuses</option>
                                                    <option value="2ªBO">2ª Bateria de Obuses</option>
                                                    <option value="3ªBO">3ª Bateria de Obuses</option>
                                                </optgroup>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" id="inicio" name="inicio" placeholder="" value="" required onkeypress="return Apenas_Numeros(event);" size="11" maxlength="10" />
                                            <p class="help-block"><small>Ex: 19-01-2010</small></p>
                                        </td>
                                        <td><input type="text" class="form-control" id="liberdade" name="liberdade" placeholder="" value="" required onkeypress="return Apenas_Numeros(event);" size="11" maxlength="10" /></td>
                                        <td><select class="form-control" name="punicao" id="punicao">
                                                <optgroup label="Selecione uma">
                                                    <option value="1">Advertência</option>
                                                    <option value="2">Impedimento disciplinar</option>
                                                    <option value="3">Repreenção</option>
                                                    <option value="4">Detenção disciplinar</option>
                                                    <option value="5">Prisão disciplinar</option>
                                                </optgroup>
                                            </select></td>
                                        <td><input type="text" class="form-control" maxlength="10" name="bi" placeholder="" required autofocus /></td>

                                    </tr>

                                </tbody>
                            </table>
                            <div class="form-group">
                                <input type="hidden" name="doDia" id="postDoDia" value="Selecione">
                                <input type="hidden" name="acao" value="cadastrar_punicao">
                                <center><button type="submit" class="btn btn-success" id="btn_cadastrar_punicao">Adicionar punição</button>
                                    <a class="btn btn-success" href="painel.php?func=editarServico" class="navbar-nav" role=""> Conferir serviço</a>
                                </center>
                            </div>
                        </form>
                        <div id="punidosDoDia">
                            a
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        let selectDoDia = document.getElementById('doDia')
        let spanDiaServico = document.getElementById('spanDiaServico')

        let postDoDia = document.getElementById('postDoDia')

        let painelInserirPunido = document.getElementById('painelInserirPunido')
        let formBusca = document.getElementById('search')
        let inputBusca = document.getElementById('porNomeNumero')
        var cloneInput = $('#porNomeNumero').clone();
        let selectSubUnidade = document.getElementById('su')
        let selectGraduacao = document.getElementById('grad')
        let inputNumero = document.getElementById('numero')
        let inputNomeCompleto = document.getElementById('nomecompleto')

        let validar = () => {
            if (selectDoDia.options[selectDoDia.selectedIndex].value == "Selecione") {
                Swal.fire({
                    title: 'Oops',
                    text: 'Você precisa selecionar a data do serviço',
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 1500
                })
                $(painelInserirPunido).css('display', 'none');
                selectDoDia.focus();
                postDoDia.value = "Selecione"
                return false
            } else {

                let data = new Date(selectDoDia.options[selectDoDia.selectedIndex].value);
                let dataFormatada = ((data.getDate() + 1)) + "/" + ((data.getMonth() + 1)) + "/" + data.getFullYear();
                $(painelInserirPunido).css('display', 'block');
                postDoDia.value = selectDoDia.options[selectDoDia.selectedIndex].value
                listarPunicoesDoDia(selectDoDia.options[selectDoDia.selectedIndex].value)
            }
        }
        let check = (punido) => {
            let bateria = punido.getAttribute('bateria')
            let grad = punido.getAttribute('graduacao')
            let nomeCompleto = punido.getAttribute('nomeCompleto')
            let numero = punido.getAttribute('numero')

            inputNumero.value = numero
            inputNomeCompleto.value = nomeCompleto
            selectSubUnidade.selectedIndex = bateria

            for (var i = 0; i < selectGraduacao.options.length; i++) {
                if (selectGraduacao.options[i].text == grad) {
                    selectGraduacao.selectedIndex = i;
                    break;
                }
            }
            new Swal('Sucesso', 'Dados PRÉ PREENCHIDOS, digite o restante e depois clique em adicionar punição!', 'success')
            limparBusca()
        }

        let limparBusca = () => {
            setTimeout(() => {
                inputBusca.value = ''
            }, 100)
        }

        function formata_data(obj) {
            switch (obj.value.length) {
                case 2:
                    obj.value = obj.value + "-";
                    break;
                case 5:
                    obj.value = obj.value + "-";
                    break;
                case 10:
                    return false
                    break;
            }
        }

        function Apenas_Numeros(caracter) {
            var nTecla = 0;
            if (document.forms) {
                nTecla = caracter.keyCode;
            } else {
                ///nTecla = caracter.which;
            }
            if ((nTecla > 47 && nTecla < 58) ||
                nTecla == 8 || nTecla == 127 ||
                nTecla == 0 || nTecla == 9 // 0 == Tab
                ||
                nTecla == 13) { // 13 == Enter
                return true;
            } else {
                return false;
            }
        }
        $(document).ready(function() {
            $("#porNomeNumero").autocomplete("acoes/controllerBuscaUsuariosExternos.php", {
                width: 800,
                selectFirst: false,
            });
        })

        function id(el) {
            return document.getElementById(el);
        }

        window.onload = function() {

            id('inicio').addEventListener('keydown', function() {
                formata_data(document.getElementById('inicio'));
            });
            id('liberdade').addEventListener('keydown', function() {
                formata_data(document.getElementById('liberdade'));
            });
        }
    </script>