<?php

$consultaoficiais = $pdo->prepare("SELECT * FROM usuarios WHERE status='ATIVADO' and user_nivel='2' ORDER BY user_nome ASC");
$consultaoficiais->execute();
$listaoficiais = $consultaoficiais->fetchAll(PDO::FETCH_ASSOC);

$consultaagua = $pdo->prepare("SELECT * FROM agua ORDER BY id DESC LIMIT 1");
$consultaagua->execute();
$resultadoagua = $consultaagua->fetch(PDO::FETCH_ASSOC);
$anterioragua = $resultadoagua[1] ?? 0;

$consultafaltapassar = $pdo->prepare("SELECT * FROM aosubcmt Where passeiAo ='' or assinaturaOfDia = '' ORDER BY doDia ASC");
$consultafaltapassar->execute();

$consultanrdocANO = $pdo->prepare("SELECT COUNT(*) as TOTAL FROM aosubcmt where passeiAo ='' or assinaturaOfDia = '' ORDER BY doDia ASC");
$consultanrdocANO->execute();
$numero = $consultanrdocANO->fetch(PDO::FETCH_ASSOC);
?>
<div class="container theme-showcase" role="main">
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <center>Adicionar serviço</center>
      </div>
      <div class="panel-body">

        <a href="#" onclick="window.open('ajudaADJ.pdf', 'Como criar um novo serviço', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=770, HEIGHT=900');">Clique aqui caso tenha alguma dúvida.</a>


        <form class="form-horizontal" id="form_cadastrar_servico" action="" method="post">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <center>Ao SCmt</center>
            </div>
            <div class="panel-body">

              <div class="form-group">
                <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Do dia</label>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <input class="form-control" name="dodia" type="text" id="dodia" required onChange="validarDatasSV();" onkeypress="return Apenas_Numeros(event);formata_data(this,document.forms[0].paraodia);" size="11" maxlength="10">
                  <p class="help-block"><strong>Formato da data: 19-01-2010</strong></p>
                </div>

                <label for="inputParaodia" class="col-xs-6 col-sm-6 col-md-3 col-lg-2">Para o dia</label>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <input class="form-control" type="text" name="paraodia" id="paraodia" onChange="validarDatasSV();" required onkeypress="return Apenas_Numeros(event);formata_data(this,document.forms[0].ofdia);" size="11" maxlength="10">

                  <p class="help-block"><strong>Formato da data: 20-01-2010</strong></p>
                </div>
              </div>

              <div class="form-group">
                <label for="inputDodia1" class="col-xs-6 col-sm-6 col-md-3 col-lg-2">Eu </LABEL>
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                  <select class="form-control form-control-inline" name="ofdia" id="ofdia">
                    <option value="Selecione"><?php echo "Selecione um oficial"; ?></option>
                    <?php
                    foreach ($listaoficiais as $oficial) {
                      $gradofdia = $oficial['grad'];
                      $nomecompletoofdia = strtoupper($oficial['user_nome']);
                    ?>
                      <option value="<?php echo "$gradofdia $nomecompletoofdia"; ?>"><?php echo "$gradofdia $nomecompletoofdia"; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-3 col-lg-2">Recebi do</LABEL>
                <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
                  <select class="form-control form-control-inline" name="recebido" id="recebido">
                    <option value="Selecione"><?php echo "Selecione um oficial"; ?></option>
                    <?php
                    foreach ($listaoficiais as $oficial) {
                      $gradofdia = $oficial['grad'];
                      $nomecompletoofdia = strtoupper($oficial['user_nome']);
                    ?>
                      <option value="<?php echo "$gradofdia $nomecompletoofdia"; ?>"><?php echo "$gradofdia $nomecompletoofdia"; ?></option>
                    <?php } ?>
                  </select>
                  <p class="help-block"><strong>Com todas as ordens em vigor.</strong></p>
                </div>
              </div>

              <div class="form-group">
                <label for="inputPessoaldeSV" class="col-xs-6 col-sm-6 col-md-3 col-lg-2">Pessoal de SV</label>
                <div class="col-xs-4 col-sm-4 col-md-5 col-lg-4">
                  <p><strong>Conforme o BI nº</strong></p>
                  <input type="text" class="form-control" maxlength="50" name="pessoaldesv" placeholder="001, de 01 de Janeiro de 2018, do 19º GAC." required autofocus />
                </div>
              </div>

              <div class="form-group">
                <label for="inputOcorrenciasScmt" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Parte aos Cmt SU</label>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="5" name="paradadiaria" id="paradadiaria" required autofocus style="display:none;">
Bateria Comando: Sem alteração.
Primeira Bateria: Sem alteração.
Segunda Bateria: Sem alteração.
Terceira Bateria: Sem alteração.</textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>

              <div class="form-group">
                <label for="inputRevistadoRecolher" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Revista do Recolher:</label><BR>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="5" name="revistadorecolher" id="revistadorecolher" required autofocus style="display:none;">Sem alteração</textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <div class="panel-heading">
                    <h4>Ronda do Oficial de Dia</h4>
                  </div>
                  <div class="panel-body">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th>Horário da 1ª ronda</th>
                          <th>Horário da 2ª ronda</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="5" name="ronda1" id="ronda1" placeholder="01:01" required autofocus />
                            </div>

                          </td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="5" name="ronda2" id="ronda2" placeholder="01:01" required autofocus />
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <div class="panel-heading">
                    <h4>Reservas de armamento:</h4>
                  </div>
                  <div class="panel-body">

                    <table class="table table-responsive">
                      <thead>
                        <center>
                          <tr>
                            <th>SU</th>
                            <th>GDH Fechamento</th>
                            <th>GDH Abertura</th>
                            <th>Lacre</th>
                            <th>Cadeados</th>
                          </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>BC</td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhfechamentobc" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhaberturabc" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="20" name="lacrebc" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="10" name="cadeadobc" placeholder="" required autofocus /></td>

                        </tr>
                        <tr>
                          <td>1ª BO</td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhfechamento1" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhabertura1" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="20" name="lacre1" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="10" name="cadeado1" placeholder="" required autofocus /></td>
                        </tr>
                        <tr>
                          <td>2ª BO</td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhfechamento2" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhabertura2" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="20" name="lacre2" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="10" name="cadeado2" placeholder="" required autofocus /></td>
                        </tr>
                        <tr>
                          <td>3ª BO</td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhfechamento3" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="50" name="gdhabertura3" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="20" name="lacre3" placeholder="" required autofocus /></td>
                          <td><input type="text" class="form-control" maxlength="10" name="cadeado3" placeholder="" required autofocus /></td>
                        </tr>

                        <tr>
                          <td>Sala COM BC</td>
                          <td></td>
                          <td></td>
                          <td><input type="text" class="form-control" maxlength="20" name="lacresalacombc" placeholder="" required autofocus /></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>



              <div class="form-group">
                <label for="inputRevistadoRecolher" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Ocorrências:</label><BR>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="5" name="ocorrenciasscmt" id="ocorrenciasscmt" required autofocus style="display:none;">Sem alteração.</textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>




              <div class="form-group">
                <label for="inputRevistadoRecolher" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">PUNIDOS</label><BR>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">


                  <?php

                  $diaHoje = date('Y-m-d');
                  $consultapunidos_do_dia = $pdo->prepare("SELECT * FROM punidos where :dia BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
                  $consultapunidos_do_dia->bindParam(':dia', $diaHoje);
                  $consultapunidos_do_dia->execute();
                  $resultadopunidos = $consultapunidos_do_dia->rowCount();
                  if ($resultadopunidos > 0) {
                    $tabela = "
                  <table class='table'>
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
                    while ($resultado = $consultapunidos_do_dia->fetch(PDO::FETCH_ASSOC)) {

                      $agora = date($diaHoje);
                      $datax2 = date("d-m-Y", strtotime($resultado['liberdade']));
                      $data_inicio = new DateTime($resultado['inicio']);
                      $data_fim = new DateTime($resultado['liberdade']);
                      $dateInterval = $data_inicio->diff($data_fim);

                      if (strtotime($resultado['liberdade']) > strtotime($agora)) {
                        $return .= " <tbody><tr class='info'>";
                      } elseif (strtotime($resultado['liberdade']) == strtotime($agora)) {
                        $return .= " <tbody><tr class='warning'>";
                      } else {
                        $return .= " <tbody><tr class='danger'>";
                      }

                      $return .= "<td>" . ($resultado["graduacao"]) . "</td>";
                      $return .= "<td>" . ($resultado["numero"]) . "</td>";
                      $return .= "<td>" . strtoupper($resultado["nomecompleto"]) . "</td>";
                      $return .= "<td>" . ($resultado["su"]) . "</td>";
                      $return .= "<td>" . (date("d-m-Y", strtotime($resultado["inicio"]))) . "</td>";
                      $return .= "<td>" . (date("d-m-Y", strtotime($resultado["liberdade"]))) . "</td>";
                      $return .= "<td>" . ($dateInterval->days) . "</td>";

                      if ($resultado['punicao'] == '1') {
                        $return .= "<td class='td'><b><font color='blue'>Advertência</font></b></td>";
                      }
                      if ($resultado['punicao'] == '2') {
                        $return .= "<td class='td'><b><font color='green'>Impedimento Disciplinar</font></b></td>";
                      }

                      if ($resultado['punicao'] == '3') {
                        $return .= "<td class='td'><b><font color='black'>Repreensão</font></b></td>";
                      }

                      if ($resultado['punicao'] == '4') {
                        $return .= "<td class='td'><b><font color='orange'>Detenção</font></b></td>";
                      }

                      if ($resultado['punicao'] == '5') {
                        $return .= "<td class='td'><b><font color='purple'>Prisão</font></b></td>";
                      }

                      $return .= "<td>" . utf8_encode($resultado["bi"]) . "</td>";

                      $return .= "</tr>";
                    }
                    echo $return .= "</tbody></table>";
                  } else {
                    echo "<br>Não há.";
                  }

                  ?>

                  <label class="alert alert-info col-lg-12">
                    <center>Para adicionar um novo punido, vá até -> <strong>ADICIONAR PUNIDOS</strong> após registrar a primeira parte do serviço.</center>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-danger">
            <div class="panel-heading">
              <center>Ao Fiscal Administrativo</center>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="inputOcorrenciasScmt" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Cadeados</label>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="6" name="cadeadosguarda" id="cadeadosguarda" required autofocus style="display:none;">
Cadeado do PA: Sem alteração.
Cadeado do PL: Sem alteração.
Cadeado do ARMÁRIO DOS FUZIS: Sem alteração.
Cadeados das ARMARIAS: Sem alteração.
Cadeado da LIXEIRA: Sem alteração.
                    </textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>

              <div class="form-group">
                <label for="inputDodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Sobras</label>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-1">
                  <input type="number" class="form-control" name="sobras" placeholder="10" required autofocus /> Kg
                </div>

                <label for="inputParaodia" class="col-xs-6 col-sm-6 col-md-2 col-lg-1">Resíduos</label>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-1">
                  <input type="number" class="form-control" name="residuos" placeholder="05" required autofocus /> Kg
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <div class="panel-heading">
                    <h4>Consumo de água e Energia Elétrica:</h4>
                  </div>
                  <div class="panel-body">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>Discriminação</th>
                          <th>Leitura Atual</th>
                          <th>Leitura Anterior</th>
                          <th>Consumo</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Água</td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="leituraatualagua" id="leituraatualagua" required autofocus />
                            </div>
                          </td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" value="" name="leituraanterioragua" id="leituraanterioragua" required autofocus />
                            </div>
                          </td>

                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="consumoagua" id="consumoagua" readonly required autofocus />
                              <p class="help-block"><strong>M³</strong></p>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td>Luz - 03</td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="leituraatual03" id="leituraatual03" required autofocus />
                            </div>
                          </td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" value="" name="leituraanterior03" id="leituraanterior03" required autofocus />
                            </div>
                          </td>

                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="consumo03" id="consumo03" readonly required autofocus />
                              <p class="help-block"><strong>KW/H</strong></p>
                            </div>
                          </td>
                        </tr>

                        <tr>
                          <td>Luz - 24</td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="leituraatual24" id="leituraatual24" required autofocus />
                            </div>
                          </td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="leituraanterior24" value="" id="leituraanterior24" required autofocus />
                            </div>
                          </td>

                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="consumo24" id="consumo24" readonly required autofocus />
                              <p class="help-block"><strong>KVA/R</strong></p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Luz - 52</td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="leituraatual52" id="leituraatual52" required autofocus />
                            </div>
                          </td>
                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" value="" name="leituraanterior52" id="leituraanterior52" required autofocus />
                            </div>
                          </td>

                          <td>
                            <div class="col-xs-4 col-sm-4 col-md-6 col-lg-5">
                              <input type="text" class="form-control" maxlength="15" name="consumo52" id="consumo52" readonly required autofocus />
                              <p class="help-block"><strong>DEM</strong></p>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="inputMunicao" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Munição:</label>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="5" name="municao" id="municao" required autofocus style="display:none;">Sem alteração.</textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>

              <div class="form-group">
                <label for="inputInstalacoes" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Instalações:</label>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="5" name="intalacoes" id="intalacoes" required autofocus style="display:none;">Sem alteração.</textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>

              <div class="form-group">
                <label for="inputMunicao" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 control">Ocorrências:</label>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-12">
                  <textarea class="form-control" maxlength="5000" rows="5" name="ocorrenciasfiscal" id="ocorrenciasfiscal" required autofocus style="display:none;">Sem alteração.</textarea>
                  <font color="red">Disponível apenas na hora de editar o serviço!</font>
                </div>
              </div>
            </div>

            <center>
              <div class="form-group">
                <div id="adjunto"></div>
                <input type="hidden" name="acao" value="cadastrar">
                <input type="hidden" name="assinaturaAdj" value="<?php echo explode('.', $assinatura)[0]; ?>">
                <button type="submit" id="btn_cadastrar_servico" disabled class="btn btn-success">Registrar a 1ª parte do SV</button>
              </div>
            </center>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  // Função responsável por atualizar as frases
  function atualizar() {
    <?php $pngAdj = str_replace(".jpg", "", $assinatura); ?>
    // Exibindo frase
    $('#adjunto').html('<i>' + '<CENTER>Adjunto ao Oficial de Dia: <?php echo $pngAdj; ?>' + '</i>');
  }

  function id(el) {
    return document.getElementById(el);
  }

  function total(un, qnt) {
    return parseFloat(un.replace(',', '.'), 10) - parseFloat(qnt.replace(',', '.'), 10);
  }
  window.onload = function() {

    id('dodia').addEventListener('keydown', function() {
      formata_data(document.getElementById('dodia'), document.forms[0].paraodia);
      atualizar();
      validarDatasSV()
    });
    id('paraodia').addEventListener('keydown', function() {
      formata_data(document.getElementById('paraodia'), document.forms[0].ofdia);
      atualizar();
      validarDatasSV()
    });

    id('leituraatualagua').addEventListener('keydown', function() {
      var result = total(this.value, id('leituraanterioragua').value);
      id('consumoagua').value = String(result.toFixed(2));
    });

    id('leituraanterioragua').addEventListener('keydown', function() {
      var result = total(id('leituraatualagua').value, this.value);
      id('consumoagua').value = String(result.toFixed(2));
    });

    id('leituraatual03').addEventListener('keydown', function() {
      var result = total(this.value, id('leituraanterior03').value);
      id('consumo03').value = String(result.toFixed(2));
    });

    id('leituraanterior03').addEventListener('keydown', function() {
      var result = total(id('leituraatual03').value, this.value);
      id('consumo03').value = String(result.toFixed(2));
    });

    id('leituraatual24').addEventListener('keydown', function() {
      var result = total(this.value, id('leituraanterior24').value);
      id('consumo24').value = String(result.toFixed(2));
    });

    id('leituraanterior24').addEventListener('keydown', function() {
      var result = total(id('leituraatual24').value, this.value);
      id('consumo24').value = String(result.toFixed(2));
    });

    id('leituraatual52').addEventListener('keydown', function() {
      var result = total(this.value, id('leituraanterior52').value);
      id('consumo52').value = String(result.toFixed(2));
    });

    id('leituraanterior52').addEventListener('keydown', function() {
      var result = total(id('leituraatual52').value, this.value);
      id('consumo52').value = String(result.toFixed(2));
    });


  }

  function validarDatasSV() {

    let dataString1 = document.getElementById("dodia").value.split("-");
    let dataString2 = document.getElementById("paraodia").value.split("-");
    let dataHoje = new Date();

    let data1 = new Date(dataString1[2], dataString1[1] - 1, dataString1[0]);
    let data2 = new Date(dataString2[2], dataString2[1] - 1, dataString2[0]);

    var date1 = data1;
    var date2 = data2;

    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var timeDiff2 = Math.abs(dataHoje.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    var diffDays2 = Math.ceil(timeDiff2 / (1000 * 3600 * 24));
    if (diffDays <= 1 && diffDays2 <= 5 && date1 ^ date2) {
      document.getElementById("btn_cadastrar_servico").innerHTML = "Registrar a 1ª parte do SV";
      document.getElementById("btn_cadastrar_servico").disabled = false;
      //document.getElementById("demo").innerHTML = "";
    } else {
      document.getElementById("btn_cadastrar_servico").innerHTML = "ERRO - VERIFIQUE AS DATAS!";
      document.getElementById("btn_cadastrar_servico").disabled = true;
    }
  };

  function formata_data(obj, prox) {
    switch (obj.value.length) {
      case 2:
        obj.value = obj.value + "-";
        break;
      case 5:
        obj.value = obj.value + "-";
        break;
      case 10:
        prox.focus();
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
</script>