<div class="container theme-showcase" role="main">
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <center>Editar serviço</center>
      </div>
      <div class="panel-body">
        <?php
        if ($nivel == 1) { ?>
          <a href="#" onclick="window.open('ajudaADJ.pdf', 'Ajuda Adjunto', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10');">Clique aqui caso tenha alguma dúvida sobre o Sistema.</a>
        <?php
        }
        if ($nivel == 2) { ?>
          <a href="#" onclick="window.open('ajudaOF.pdf', 'Ajuda Oficial de Dia', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10');">Clique aqui caso tenha alguma dúvida sobre o Sistema.</a>
        <?php
        } ?>
        <form id="form_Relatorio" action="" method="POST">
          <?php
          $removeExt = explode('.', $assinatura);
          $assinatura = "%" . $removeExt[0] . "%";
          $assinaturaUsuarioLogado = $removeExt[0];
          $ofdiaLogado = $grad . " " . $nome;
          $consultaservicos = $pdo->prepare("SELECT * FROM aosubcmt
            WHERE (assinaturaAdj LIKE :assinatura OR ofdia LIKE :ofdia )
            AND (assinaturaOfdia ='' and vistoScmt ='NO' and vistoFiscal='NO')
            ORDER BY doDia ASC");
          $consultaservicos->bindParam(':assinatura', $assinatura);
          $consultaservicos->bindParam(':ofdia', $ofdiaLogado);
          $consultaservicos->execute();
          $listaServicos = $consultaservicos->fetchAll(PDO::FETCH_ASSOC);
          ?>
          <div class="form-group">
            <label class="col-sm-4 control-label  hidden-print">Selecione uma data</label>
            <div class="col-sm-2">
              <select class="form-control form-control-inline hidden-print" name="doDia" id="doDia">
                <option value="Selecione"><?php echo "Selecione um serviço"; ?></option>
                <?php foreach ($listaServicos as $resultado) { ?>
                  <option value="<?php echo $resultado['doDia']; ?>"><?php echo "" . date("d-m-Y", strtotime($resultado['doDia'])) . ""; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <button type="submit" name="button" id="button" class="btn btn-success  hidden-print">Editar o serviço da data</button>
        </form>
        <hr>
        <?php
        if (isset($_POST["button"]) and ($_POST["doDia"] != "Selecione")) {
          $doDia = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING)));
          $_SESSION['dodiaedit']['salvar'] = $doDia;

          $consultaoficiais = $pdo->prepare("SELECT * FROM usuarios WHERE status='ATIVADO' and user_nivel='2' ORDER BY user_nome ASC");
          $consultaoficiais->execute();
          $listaOficiais = $consultaoficiais->fetchAll(PDO::FETCH_ASSOC);

          $consultaservicosdodia = $pdo->prepare("SELECT * FROM aosubcmt WHERE doDia = :doDia");
          $consultaservicosdodia->bindParam(':doDia', $doDia);
          $consultaservicosdodia->execute();
          $resultadododia = $consultaservicosdodia->fetch(PDO::FETCH_ASSOC);

          $idaoscmt = $resultadododia['id'];
          $paraOdia = $resultadododia['paraoDia'];
          $vistoScmt = $resultadododia['vistoScmt'];
          $vistoFiscal = $resultadododia['vistoFiscal'];
          $vistoS1 = $resultadododia['vistoS1'];
          $recebiDo = $resultadododia['recebiDo'];
          $pessoalDeSv = $resultadododia['pessoalDeSv'];
          $paradaDiaria = $resultadododia['paradaDiaria'];
          $RevistadoRecolher = $resultadododia['RevistadoRecolher'];
          $passeiAo = $resultadododia['passeiAo'];
          $assinaturaOfDia = $resultadododia['assinaturaOfDia'];
          $assinaturaAdj = $resultadododia['assinaturaAdj'];
          $ofdia = $resultadododia['ofdia'];

          $consultaocorrenciaScmt = $pdo->prepare("SELECT * FROM ocorrenciasaoscmt WHERE ocorrenciasaoscmt.data =:doDia");
          $consultaocorrenciaScmt->bindParam(':doDia', $doDia);
          $consultaocorrenciaScmt->execute();
          $resultadosScmt = $consultaocorrenciaScmt->fetch(PDO::FETCH_ASSOC);
          $ocorrenciaScmt = $resultadosScmt['descricao'];

          $consultacadeadosguarda = $pdo->prepare("SELECT * FROM cadeadosguarda WHERE cadeadosguarda.data =:doDia");
          $consultacadeadosguarda->bindParam(':doDia', $doDia);
          $consultacadeadosguarda->execute();
          $resultadoCadeadoGuarda = $consultacadeadosguarda->fetch(PDO::FETCH_ASSOC);
          $cadeadosguarda = $resultadoCadeadoGuarda['descricao'];
          if ($cadeadosguarda != null) {
          } else {
            $cadeadosguarda = '
            Cadeado do PA: Sem alteração.
            Cadeado do PL: Sem alteração.
            Cadeado do ARMÁRIO DOS FUZIS: Sem alteração.
            Cadeados das ARMARIAS: Sem alteração.
            Cadeado da LIXEIRA: Sem alteração.';
          }

          $consultaocorrenciaFiscal = $pdo->prepare("SELECT * FROM ocorrenciasaofiscal WHERE ocorrenciasaofiscal.data =:doDia");
          $consultaocorrenciaFiscal->bindParam(':doDia', $doDia);
          $consultaocorrenciaFiscal->execute();
          $resultadosFiscal = $consultaocorrenciaFiscal->fetch(PDO::FETCH_ASSOC);
          $ocorrenciaFiscal = $resultadosFiscal['descricao'];

          $consultainstalacoes = $pdo->prepare("SELECT * FROM instalacoes WHERE instalacoes.data =:doDia");
          $consultainstalacoes->bindParam(':doDia', $doDia);
          $consultainstalacoes->execute();
          $resultadoinstalacoes = $consultainstalacoes->fetch(PDO::FETCH_ASSOC);
          $instalacoes = $resultadoinstalacoes['descricao'];

          $consultamunicao = $pdo->prepare("SELECT * FROM municao WHERE municao.data =:doDia");
          $consultamunicao->bindParam(':doDia', $doDia);
          $consultamunicao->execute();
          $resultadomunicao = $consultamunicao->fetch(PDO::FETCH_ASSOC);
          $municao = $resultadomunicao['descricao'];

          $consultarondaOfdia = $pdo->prepare("SELECT * FROM rondaOfdia WHERE rondaOfdia.data =:doDia");
          $consultarondaOfdia->bindParam(':doDia', $doDia);
          $consultarondaOfdia->execute();
          $resultadoROndaOfdia = $consultarondaOfdia->fetch(PDO::FETCH_ASSOC);
          $ronda1 = $resultadoROndaOfdia['ronda1'];
          $ronda2 = $resultadoROndaOfdia['ronda2'];
          // $ronda3 = $resultadoROndaOfdia[4];

          $consultasobraseresiduos = $pdo->prepare("SELECT * FROM sobraseresiduos WHERE sobraseresiduos.data =:doDia");
          $consultasobraseresiduos->bindParam(':doDia', $doDia);
          $consultasobraseresiduos->execute();
          $resultadosobraseresiduos = $consultasobraseresiduos->fetch(PDO::FETCH_ASSOC);
          $sobras = $resultadosobraseresiduos['sobra'];
          $residuos = $resultadosobraseresiduos['residuos'];

          $consultaagua = $pdo->prepare("SELECT * FROM agua WHERE agua.data =:doDia");
          $consultaagua->bindParam(':doDia', $doDia);
          $consultaagua->execute();
          $resultadoagua = $consultaagua->fetch(PDO::FETCH_ASSOC);
          $atualagua = $resultadoagua['atual'];
          $anterioragua = $resultadoagua['anterior'];
          $consumoagua = $resultadoagua['consumo'];

          $consultaluz03 = $pdo->prepare("SELECT * FROM luz03 WHERE luz03.data =:doDia");
          $consultaluz03->bindParam(':doDia', $doDia);
          $consultaluz03->execute();
          $resultadoluz03 = $consultaluz03->fetch(PDO::FETCH_ASSOC);
          $atual03 = $resultadoluz03['atual'];
          $anterior03 = $resultadoluz03['anterior'];
          $consumo03 = $resultadoluz03['consumo'];

          $consultaluz24 = $pdo->prepare("SELECT * FROM luz24 WHERE luz24.data =:doDia");
          $consultaluz24->bindParam(':doDia', $doDia);
          $consultaluz24->execute();
          $resultadoluz24 = $consultaluz24->fetch(PDO::FETCH_ASSOC);
          $atual24 = $resultadoluz24['atual'];
          $anterior24 = $resultadoluz24['anterior'];
          $consumo24 = $resultadoluz24['consumo'];

          $consultaluz52 = $pdo->prepare("SELECT * FROM luz52 WHERE luz52.data =:doDia");
          $consultaluz52->bindParam(':doDia', $doDia);
          $consultaluz52->execute();
          $resultadoluz52 = $consultaluz52->fetch(PDO::FETCH_ASSOC);
          $atual52 = $resultadoluz52['atual'];
          $anterior52 = $resultadoluz52['anterior'];
          $consumo52 = $resultadoluz52['consumo'];

          $consultabc = $pdo->prepare("SELECT * FROM reservabc WHERE reservabc.data =:doDia");
          $consultabc->bindParam(':doDia', $doDia);
          $consultabc->execute();
          $resultadobc = $consultabc->fetch(PDO::FETCH_ASSOC);
          $gdhfechamentobc = $resultadobc['gdhfechamento'];
          $gdhaberturabc = $resultadobc['gdhabertura'];
          $lacrebc = $resultadobc['lacre'];
          $cadeadosbc = $resultadobc['cadeados'];

          $consulta1 = $pdo->prepare("SELECT * FROM reservaprimeira WHERE reservaprimeira.data =:doDia");
          $consulta1->bindParam(':doDia', $doDia);
          $consulta1->execute();
          $resultado1 = $consulta1->fetch(PDO::FETCH_ASSOC);
          $gdhfechamento1 = $resultado1['gdhfechamento'];
          $gdhabertura1 = $resultado1['gdhabertura'];
          $lacre1 = $resultado1['lacre'];
          $cadeados1 = $resultado1['cadeados'];

          $consulta2 = $pdo->prepare("SELECT * FROM reservasegunda WHERE reservasegunda.data =:doDia");
          $consulta2->bindParam(':doDia', $doDia);
          $consulta2->execute();
          $resultado2 = $consulta2->fetch(PDO::FETCH_ASSOC);
          $gdhfechamento2 = $resultado2['gdhfechamento'];
          $gdhabertura2 = $resultado2['gdhabertura'];
          $lacre2 = $resultado2['lacre'];
          $cadeados2 = $resultado2['cadeados'];

          $consulta3 = $pdo->prepare("SELECT * FROM reservaterceira WHERE reservaterceira.data =:doDia");
          $consulta3->bindParam(':doDia', $doDia);
          $consulta3->execute();
          $resultado3 = $consulta3->fetch(PDO::FETCH_ASSOC);
          $gdhfechamento3 = $resultado3['gdhfechamento'];
          $gdhabertura3 = $resultado3['gdhabertura'];
          $lacre3 = $resultado3['lacre'];
          $cadeados3 = $resultado3['cadeados'];

          $consultasalacombc = $pdo->prepare("SELECT * FROM salacombc WHERE salacombc.data =:doDia");
          $consultasalacombc->bindParam(':doDia', $doDia);
          $consultasalacombc->execute();
          $resultadosalacombc = $consultasalacombc->fetch(PDO::FETCH_ASSOC);
          $lacresalacom = $resultadosalacombc['lacre'];

          if ($assinaturaOfDia == '') { ?>
            <form id="form_alterar_servico" action="" method="POST">
              <p>
                <strong>01. RECEBIMENTO DO SERVIÇO:</strong> Eu
                <strong>
                  <select name="ofdia" id="ofdia">
                    <option value="<?php echo $ofdia; ?>"><?php echo $ofdia; ?></option>
                    <?php foreach ($listaOficiais as $oficial_de_sv) {
                      $gradofdia = $oficial_de_sv['grad'];
                      $nomecompletoofdia = strtoupper($oficial_de_sv['user_nome']); ?>
                      <option value="<?php echo "$gradofdia $nomecompletoofdia"; ?>"><?php echo "$gradofdia $nomecompletoofdia"; ?></option>
                    <?php } ?>
                  </select>
                </strong>, recebi o serviço do
                <strong>
                  <select name="recebido" id="recebido">
                    <option value="<?php echo $recebiDo; ?>"><?php echo $recebiDo; ?></option>
                    <?php foreach ($listaOficiais as $oficial_saindo) {
                      $gradof = $oficial_saindo['grad'];
                      $nomecompletoof = strtoupper($oficial_saindo['user_nome']); ?>
                      <option value="<?php echo "$gradof $nomecompletoof"; ?>"><?php echo "$gradof $nomecompletoof"; ?></option>
                    <?php } ?>
                  </select>
                </strong>, com todas as ordens em vigor.
              </p>
              <p>
                <strong>02. PESSOAL DE SERVIÇO:</strong> Conforme BI Nº <input type="text" size='50' maxlength="50" name="pessoaldesv" placeholder="001 de 01 de Janeiro de 2017, do 19º GAC." value="<?php echo $pessoalDeSv; ?>" required autofocus />.
              </p>
              <p>
                <strong>03. PARTE AOS CMT SU</strong>
                <textarea class="form-control" maxlength="5000" rows="8" name="paradadiaria" id="paradadiaria" required autofocus><?php echo $paradaDiaria; ?></textarea>
              </p>
              <p>
                <strong>04. REVISTA DO RECOLHER</strong><br>
                <textarea class="form-control" maxlength="5000" rows="5" name="revistadorecolher" id="revistadorecolher" required autofocus><?php echo $RevistadoRecolher; ?></textarea>
              </p>
              <p>
                <strong>04.a Ronda do Oficial de Dia</strong><br>
                Primeira ronda realizada as <input type="text" placaholder="00:01" maxlength="5" name="ronda1" value="<?php echo $ronda1; ?>" required autofocus /><br>
                Segunda ronda realizada as <input type="text" placaholder="00:01" maxlength="5" name="ronda2" value="<?php echo $ronda2; ?>" required autofocus /><br>
                <!--Terceira ronda realizada as <input type="text" placaholder="00:01" maxlength="5" name="ronda3" value="<?php ///echo $ronda3; ;;;;;;;;;;
                                                                                                                          ?>" required autofocus /><br-->
              </p>
              <p>
                <strong>05. RESERVA DE ARMAMENTO</strong>
              <table class="table table-responsive">
                <thead>
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
                    <td><input type="text" class="form-control" maxlength="50" name="gdhfechamentobc" value="<?php echo $gdhfechamentobc; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhaberturabc" value="<?php echo $gdhaberturabc; ?>" required autofocus /></td>
                    <td><input type="number" class="form-control" maxlength="20" name="lacrebc" value="<?php echo $lacrebc; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="10" name="cadeadobc" value="<?php echo $cadeadosbc; ?>" required autofocus /></td>
                  </tr>
                  <tr>
                    <td>1ª BO</td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhfechamento1" value="<?php echo $gdhfechamento1; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhabertura1" value="<?php echo $gdhabertura1; ?>" required autofocus /></td>
                    <td><input type="number" class="form-control" maxlength="20" name="lacre1" value="<?php echo $lacre1; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="10" name="cadeado1" value="<?php echo $cadeados1; ?>" required autofocus /></td>
                  </tr>
                  <tr>
                    <td>2ª BO</td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhfechamento2" value="<?php echo $gdhfechamento2; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhabertura2" value="<?php echo $gdhabertura2; ?>" required autofocus /></td>
                    <td><input type="number" class="form-control" maxlength="20" name="lacre2" value="<?php echo $lacre2; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="10" name="cadeado2" value="<?php echo $cadeados2; ?>" required autofocus /></td>
                  </tr>
                  <tr>
                    <td>3ª BO</td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhfechamento3" value="<?php echo $gdhfechamento3; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="50" name="gdhabertura3" value="<?php echo $gdhabertura3; ?>" required autofocus /></td>
                    <td><input type="number" class="form-control" maxlength="20" name="lacre3" value="<?php echo $lacre3; ?>" required autofocus /></td>
                    <td><input type="text" class="form-control" maxlength="10" name="cadeado3" value="<?php echo $cadeados3; ?>" required autofocus /></td>
                  </tr>
                  <tr>
                    <td>Sala COM BC</td>
                    <td></td>
                    <td></td>
                    <td><input type="number" class="form-control" maxlength="20" name="lacresalacombc" value="<?php echo $lacresalacom; ?>" required autofocus /> </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              </p>
              <p>
                <strong>06. PUNIDOS</strong>
                <?php $consultapunidos_do_dia = $pdo->prepare("SELECT * FROM punidos where :doDia BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
                $consultapunidos_do_dia->bindParam(':doDia', $doDia);
                $consultapunidos_do_dia->execute();
                $resultadopunidos = $consultapunidos_do_dia->rowCount();

                if ($resultadopunidos > 0) {
                  $tabela = "
                    <div class='table-responsive'>
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
                  // Captura os dados da consulta e inseri na tabela HTML
                  while ($linha = $consultapunidos_do_dia->fetch(PDO::FETCH_ASSOC)) {
                    $agora = date($doDia);
                    $datax2 = date("d-m-Y", strtotime($linha['liberdade']));
                    $data_inicio = new DateTime($linha['inicio']);
                    $data_fim = new DateTime($linha['liberdade']);
                    $dateInterval = $data_inicio->diff($data_fim);

                    if (strtotime($linha['liberdade']) > strtotime($agora)) {
                      $return .= " <tbody><tr class='info'>";
                    } elseif (strtotime($linha['liberdade']) == strtotime($agora)) {
                      $return .= " <tbody><tr class='warning'>";
                    } else {
                      $return .= " <tbody><tr class='danger'>";
                    }
                    $return .= "<td>" . ($linha["graduacao"]) . "</td>";
                    $return .= "<td>" . ($linha["numero"]) . "</td>";
                    $return .= "<td>" . strtoupper($linha["nomecompleto"]) . "</td>";
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
                  echo $return .= "</tbody></table></div>";
                } else {
                  echo "<br>Não há.";
                }
                ?>
              </p>
              <p>
                <strong>07. OCORRÊNCIAS</strong><BR>
                <textarea class="form-control" maxlength="5000" rows="5" name="ocorrenciasscmt" id="ocorrenciasscmt" required autofocus><?php echo $ocorrenciaScmt; ?></textarea>
              </p>

              <center>
                <h2>AO FISCAL ADM</h2>
              </center>
              <p>
                <strong>08. CADEADOS </strong>
                <textarea class="form-control" maxlength="5000" rows="10" name="cadeadosguarda" id="cadeadosguarda" required autofocus><?php echo $cadeadosguarda; ?></textarea>
              </p>

              <p>
                <strong>09. SOBRAS E RESIDUOS</strong>
              <p> Sobras: <input type="number" size="2" name="sobras" value="<?php echo $sobras; ?>" required autofocus /> kg</p>
              <p>Residuos: <input type="number" size="2" name="residuos" value="<?php echo $residuos; ?>" required autofocus />kg</p>
              </p>
              <p>
                <strong>10. CONSUMO D'ÁGUA E DE ENERGIA ELÉTRICA</strong>
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
                      <input type="text" maxlength="15" name="leituraatualagua" id="leituraatualagua" value="<?php echo $atualagua; ?>" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" value="<?php echo $anterioragua; ?>" name="leituraanterioragua" id="leituraanterioragua" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="5" name="consumoagua" id="consumoagua" value="<?php echo $consumoagua; ?>" readonly required autofocus />M³
                    </td>
                  </tr>
                  <tr>
                    <td>Luz - 03</td>
                    <td>
                      <input type="text" maxlength="15" name="leituraatual03" id="leituraatual03" value="<?php echo $atual03; ?>" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" value="<?php echo $anterior03; ?>" name="leituraanterior03" id="leituraanterior03" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" name="consumo03" id="consumo03" value="<?php echo $consumo03; ?>" readonly required autofocus />KW/H
                    </td>
                  </tr>

                  <tr>
                    <td>Luz - 24</td>
                    <td>
                      <input type="text" maxlength="15" name="leituraatual24" id="leituraatual24" value="<?php echo $atual24; ?>" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" name="leituraanterior24" value="<?php echo $anterior24; ?>" id="leituraanterior24" placeholder="09,5" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" name="consumo24" id="consumo24" value="<?php echo $consumo24; ?>" readonly required autofocus />KVA/H
                    </td>
                  </tr>
                  <tr>
                    <td>Luz - 52</td>
                    <td>
                      <input type="text" maxlength="15" name="leituraatual52" id="leituraatual52" value="<?php echo $atual52; ?>" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" value="<?php echo $anterior52; ?>" name="leituraanterior52" id="leituraanterior52" placeholder="09,5" required autofocus />
                    </td>
                    <td>
                      <input type="text" maxlength="15" name="consumo52" id="consumo52" value="<?php echo $consumo52; ?>" readonly required autofocus />DEM
                    </td>
                  </tr>
                </tbody>
              </table>
              </p>
              <p>
                <strong>11. MUNIÇÃO</strong><BR>
                <textarea class="form-control" maxlength="5000" rows="5" name="municao" id="municao" required autofocus><?php echo $municao; ?></textarea>
              </p>
              <p>
                <strong>12. INSTALAÇÕES</strong><BR>
                <textarea class="form-control" maxlength="5000" rows="5" name="instalacoes" id="instalacoes" required autofocus><?php echo $instalacoes; ?></textarea>
              </p>
              <p>
                <strong>13. OCORRÊNCIAS</strong><BR>
                <textarea class="form-control" maxlength="5000" rows="5" name="ocorrenciasfiscal" id="ocorrenciasfiscal" required autofocus><?php echo $ocorrenciaFiscal; ?></textarea>
              </p>
              <center>
                <div class="form-group">
                  <div id="adjunto"></div>
                  <input type="hidden" name="acao" value="alterar">
                  <input type="hidden" name="dodia" value="<?php echo $doDia; ?>">
                  <input type="hidden" name="paraodia" value="<?php echo $paraOdia; ?>">
                  <input type="hidden" name="assinaturaAdj" value="<?php echo $assinaturaAdj; ?>">
                  <button type="submit" id="btn_alterar_servico" class="btn btn-success">Alterar dados do serviço</button>
                </div>
              </center>
            </form>
      </div>
    </div>
  </div>
</div>
<?php
          } else {
            echo "Este serviço não pode ser alterado, pois foi assinado pelo OF dia.";
          }
        } else {
          echo "Selecione uma data de serviço.<br> Os serviços não podem ser alterados após a assinatura do Oficial de dia!";
        }
?>
<script type="text/javascript">
  function id(el) {
    return document.getElementById(el);
  }

  function total(un, qnt) {
    return parseFloat(un.replace(',', '.'), 10) - parseFloat(qnt.replace(',', '.'), 10);
  }
  window.onload = function() {
    id('leituraatualagua').addEventListener('keyup', function() {
      var result = total(this.value, id('leituraanterioragua').value);
      id('consumoagua').value = String(result.toFixed(2));
    });

    id('leituraanterioragua').addEventListener('keyup', function() {
      var result = total(id('leituraatualagua').value, this.value);
      id('consumoagua').value = String(result.toFixed(2));
    });

    id('leituraatual03').addEventListener('keyup', function() {
      var result = total(this.value, id('leituraanterior03').value);
      id('consumo03').value = String(result.toFixed(2));
    });

    id('leituraanterior03').addEventListener('keyup', function() {
      var result = total(id('leituraatual03').value, this.value);
      id('consumo03').value = String(result.toFixed(2));
    });

    id('leituraatual24').addEventListener('keyup', function() {
      var result = total(this.value, id('leituraanterior24').value);
      id('consumo24').value = String(result.toFixed(2));
    });

    id('leituraanterior24').addEventListener('keyup', function() {
      var result = total(id('leituraatual24').value, this.value);
      id('consumo24').value = String(result.toFixed(2));
    });

    id('leituraatual52').addEventListener('keyup', function() {
      var result = total(this.value, id('leituraanterior52').value);
      id('consumo52').value = String(result.toFixed(2));
    });

    id('leituraanterior52').addEventListener('keyup', function() {
      var result = total(id('leituraatual52').value, this.value);
      id('consumo52').value = String(result.toFixed(2));
    });

    $('#dodia').on('change', function() {
      var nome = document.getElementById('dodia').value;
      var msg = nome;
      var time = new Date(nome);
      var outraData = new Date();
      outraData.toDate('yyyy-mm-dd')
      outraData.setDate(time.getDate() + 2); // Adiciona 3 dias
      document.getElementById('paraodia').value = outraData.toDate('yyyy-mm-dd');
    });

  }
</script>