<?php
include "./../connection.php";
include "./../connectionMilitares.php";
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
$doDia = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING))) ?? 0;
$doDiaFormatado = date("d-m-Y", strtotime($doDia));
$anoCheck = date("Y", strtotime($doDia));
$consultar_dados_servico = $pdo->prepare("SELECT * FROM aosubcmt WHERE doDia = :doDia");
$consultar_dados_servico->bindParam(':doDia', $doDia);
$consultar_dados_servico->execute();
$servico_existe = $consultar_dados_servico->rowCount() >= 1 ? 1 : 0;

if ($doDia == 0 || empty($doDia)) {
    echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite uma data", 'status' => 'error'));
    return false;
}
if ($acao == "Selecione" || empty($acao)) {
    echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione o tipo de relatório (Scmt ou Fiscal)", 'status' => 'error'));
    return false;
}

if ((int) $anoCheck < 2017) {
    echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Não há serviço neste ano", 'status' => 'error'));
    return false;
}

if ($servico_existe == 1) {
    $resultado = $consultar_dados_servico->fetch(PDO::FETCH_ASSOC);
    $servicoID = $resultado['id'];
    $servicoDoDia = $resultado['doDia'];
    $servicoParaODia = $resultado['paraoDia'];
    $servicoVistoScmt = $resultado['vistoScmt'];
    $servicoVistoFiscal = $resultado['vistoFiscal'];
    $servicoVistoS1 = $resultado['vistoS1'];
    $servicoRecebidoDo = mb_strtoupper($resultado['recebiDo']);
    $servicoPessoalDeServico = $resultado['pessoalDeSv'];
    $servicoParadaDiaria = $resultado['paradaDiaria'];
    $servicoPernoite = $resultado['RevistadoRecolher'];
    $servicoPassadoAo = mb_strtoupper($resultado['passeiAo']);
    $servicoAssinaturaOfDia = $resultado['assinaturaOfDia'];
    $servicoAssinaturaAdjunto = $resultado['assinaturaAdj'];
    $servicoOfDia = mb_strtoupper($resultado['ofdia']);

    $consultar_rondas_of_dia = $pdo->prepare("SELECT * FROM rondaOfdia WHERE rondaOfdia.data = :servicoDoDia");
    $consultar_rondas_of_dia->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_rondas_of_dia->execute();
    $resultado_rondas_of_dia = $consultar_rondas_of_dia->fetch(PDO::FETCH_ASSOC);
    $ronda1 = $resultado_rondas_of_dia['ronda1'];
    $ronda2 = $resultado_rondas_of_dia['ronda2'];

    $consultar_ocorrencias_ao_scmt = $pdo->prepare("SELECT * FROM ocorrenciasaoscmt WHERE ocorrenciasaoscmt.data = :servicoDoDia");
    $consultar_ocorrencias_ao_scmt->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_ocorrencias_ao_scmt->execute();
    $resultado_ocorrencias_ao_scmt = $consultar_ocorrencias_ao_scmt->fetch(PDO::FETCH_ASSOC);
    $ocorrencias_scmt = $resultado_ocorrencias_ao_scmt['descricao'];

    $consultar_ocorrencias_ao_fiscal = $pdo->prepare("SELECT * FROM ocorrenciasaofiscal WHERE ocorrenciasaofiscal.data = :servicoDoDia");
    $consultar_ocorrencias_ao_fiscal->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_ocorrencias_ao_fiscal->execute();
    $resultado_ocorrencias_ao_fiscal = $consultar_ocorrencias_ao_fiscal->fetch(PDO::FETCH_ASSOC);
    $ocorrencias_fiscal = $resultado_ocorrencias_ao_fiscal['descricao'];

    $consultar_instalacoes = $pdo->prepare("SELECT * FROM instalacoes WHERE instalacoes.data = :servicoDoDia");
    $consultar_instalacoes->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_instalacoes->execute();
    $resultado_instalacoes = $consultar_instalacoes->fetch(PDO::FETCH_ASSOC);
    $instalacoes = $resultado_instalacoes['descricao'];

    $consultar_municao = $pdo->prepare("SELECT * FROM municao WHERE municao.data = :servicoDoDia");
    $consultar_municao->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_municao->execute();
    $resultado_municao = $consultar_municao->fetch(PDO::FETCH_ASSOC);
    $municao = $resultado_municao['descricao'];

    $consultar_sobras_e_residuos = $pdo->prepare("SELECT * FROM sobraseresiduos WHERE sobraseresiduos.data = :servicoDoDia");
    $consultar_sobras_e_residuos->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_sobras_e_residuos->execute();
    $resultado_sobras_e_residuos = $consultar_sobras_e_residuos->fetch(PDO::FETCH_ASSOC);
    $sobras = $resultado_sobras_e_residuos['sobra'];
    $residuos = $resultado_sobras_e_residuos['residuos'];

    $consultar_agua = $pdo->prepare("SELECT * FROM agua WHERE agua.data = :servicoDoDia");
    $consultar_agua->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_agua->execute();
    $resultado_agua = $consultar_agua->fetch(PDO::FETCH_ASSOC);
    $atualagua = $resultado_agua['atual'];
    $anterioragua = $resultado_agua['anterior'];
    $consumoagua = $resultado_agua['consumo'];

    $consultar_luz_03 = $pdo->prepare("SELECT * FROM luz03 WHERE luz03.data = :servicoDoDia");
    $consultar_luz_03->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_luz_03->execute();
    $resultado_luz_03 = $consultar_luz_03->fetch(PDO::FETCH_ASSOC);
    $atual03 = $resultado_luz_03['atual'];
    $anterior03 = $resultado_luz_03['anterior'];
    $consumo03 = $resultado_luz_03['consumo'];

    $consultar_luz_24 = $pdo->prepare("SELECT * FROM luz24 WHERE luz24.data = :servicoDoDia");
    $consultar_luz_24->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_luz_24->execute();
    $resultado_luz_24 = $consultar_luz_24->fetch(PDO::FETCH_ASSOC);
    $atual24 = $resultado_luz_24['atual'];
    $anterior24 = $resultado_luz_24['anterior'];
    $consumo24 = $resultado_luz_24['consumo'];

    $consultar_luz_52 = $pdo->prepare("SELECT * FROM luz52 WHERE luz52.data = :servicoDoDia");
    $consultar_luz_52->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_luz_52->execute();
    $resultado_luz_52 = $consultar_luz_52->fetch(PDO::FETCH_ASSOC);
    $atual52 = $resultado_luz_52['atual'];
    $anterior52 = $resultado_luz_52['anterior'];
    $consumo52 = $resultado_luz_52['consumo'];

    $consultar_armaria_bc = $pdo->prepare("SELECT * FROM reservabc WHERE reservabc.data = :servicoDoDia");
    $consultar_armaria_bc->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_armaria_bc->execute();
    $resultado_armaria_bc = $consultar_armaria_bc->fetch(PDO::FETCH_ASSOC);
    $gdhfechamentobc = $resultado_armaria_bc['gdhfechamento'];
    $gdhaberturabc = $resultado_armaria_bc['gdhabertura'];
    $lacrebc = $resultado_armaria_bc['lacre'];
    $cadeadosbc = $resultado_armaria_bc['cadeados'];

    $consultar_armaria_1 = $pdo->prepare("SELECT * FROM reservaprimeira WHERE reservaprimeira.data = :servicoDoDia");
    $consultar_armaria_1->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_armaria_1->execute();
    $resultado_armaria_1 = $consultar_armaria_1->fetch(PDO::FETCH_ASSOC);
    $gdhfechamento1 = $resultado_armaria_1['gdhfechamento'];
    $gdhabertura1 = $resultado_armaria_1['gdhabertura'];
    $lacre1 = $resultado_armaria_1['lacre'];
    $cadeados1 = $resultado_armaria_1['cadeados'];

    $consultar_armaria_2 = $pdo->prepare("SELECT * FROM reservasegunda WHERE reservasegunda.data = :servicoDoDia");
    $consultar_armaria_2->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_armaria_2->execute();
    $resultado_armaria_2 = $consultar_armaria_2->fetch(PDO::FETCH_ASSOC);
    $gdhfechamento2 = $resultado_armaria_2['gdhfechamento'];
    $gdhabertura2 = $resultado_armaria_2['gdhabertura'];
    $lacre2 = $resultado_armaria_2['lacre'];
    $cadeados2 = $resultado_armaria_2['cadeados'];

    $consultar_armaria_3 = $pdo->prepare("SELECT * FROM reservaterceira WHERE reservaterceira.data = :servicoDoDia");
    $consultar_armaria_3->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_armaria_3->execute();
    $resultado_armaria_3 = $consultar_armaria_3->fetch(PDO::FETCH_ASSOC);
    $gdhfechamento3 = $resultado_armaria_3['gdhfechamento'];
    $gdhabertura3 = $resultado_armaria_3['gdhabertura'];
    $lacre3 = $resultado_armaria_3['lacre'];
    $cadeados3 = $resultado_armaria_3['cadeados'];

    $consultar_sala_com = $pdo->prepare("SELECT * FROM salacombc WHERE salacombc.data = :servicoDoDia");
    $consultar_sala_com->bindParam(':servicoDoDia', $servicoDoDia);
    $consultar_sala_com->execute();
    $resultado_sala_com = $consultar_sala_com->fetch(PDO::FETCH_ASSOC);
    $lacrecom = $resultado_sala_com['lacre'];
} else {
    echo json_encode(array('resposta' => 'Oops', 'mensagem' => "SERVIÇO DO DIA $doDiaFormatado NÃO FOI CADASTRADO!", 'status' => 'error'));
    return false;
}

if ($acao == "gerar_relatorio_scmt") {

    if ($servicoAssinaturaOfDia != "") {

        $html = " <div  align='center'> <img src='" . $path . 'logo.jpg' . "' height='105' width='210'> </div>";
        $html .= "<div style='margin-left:550px;margin-top:-100'><table width='150'>
    <tbody>
      <tr><th>VISTO:<br><br>______________<br>S Cmt</th></tr></tbody></table></div> ";
        $html .= "<div  style='margin-top:30' align='center'> <b> RELATÓRIO DE PARTE DO SERVIÇO DE OFICIAL DE DIA  </b> </div>";

        $html .= "<div  align='center'> <b> AO S CMT </b> </div> ";
        $html .= "<p><strong>01. RECEBIMENTO DO SERVIÇO: </strong> Recebi do <strong>$servicoRecebidoDo</strong>, com todas as ordens em vigor.</p>";

        $html .= "<p><strong>02. PESSOAL DE SERVIÇO: </strong> Conforme BI Nº $servicoPessoalDeServico.</p>";
        $html .= "<p><strong>03. PARTE AOS CMT SU</strong> <BR>";
        $parada = nl2br($servicoParadaDiaria);
        $html .= "$parada</p>";
        $revistarecolher = nl2br($servicoPernoite);
        $html .= "<p><strong>04. REVISTA DO RECOLHER</strong>:<BR>$revistarecolher.</p>";
        $html .= "
      <p><strong>04.a. RONDA DO OFICIAL DE DIA</strong><br>
         Primeira ronda realizada as $ronda1.<br>
         Segunda ronda realizada as $ronda2.<br>
      </p>";
        $html .= "
      <p><strong>05. RESERVA DE ARMAMENTO</strong>
         <table>
            <thead>
               <tr>
                  <th>SU</th>
                  <th>GDH FECHAMENTO</th>
                  <th>GDH ABERTURA</th>
                  <th>LACRE</th>
                  <th>CADEADOS</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>BC</td>
                  <td>$gdhfechamentobc</td>
                  <td>$gdhaberturabc</td>
                  <td>$lacrebc</td>
                  <td>$cadeadosbc</td>
               </tr>
               <tr>
                  <td>1ª BO</td>
                  <td> $gdhfechamento1</td>
                  <td>$gdhabertura1</td>
                  <td>$lacre1</td>
                  <td>$cadeados1</td>
               </tr>
               <tr>
                  <td>2ª BO</td>
                  <td>$gdhfechamento2</td>
                  <td>$gdhabertura2</td>
                  <td>$lacre2</td>
                  <td>$cadeados2</td>
               </tr>
               <tr>
                  <td>3ª BO</td>
                  <td>$gdhfechamento3</td>
                  <td>$gdhabertura3</td>
                  <td>$lacre3</td>
                  <td>$cadeados3</td>
               </tr>
               <tr>
                  <td>Sala COM BC</td>
                  <td></td>
                  <td></td>
                  <td>$lacrecom</td>
                  <td></td>
               </tr>
            </tbody>
         </table>
      </p>";
        $consultar_punidos_do_dia = $pdo->prepare("SELECT * FROM punidos where :servicoDoDia BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
        $consultar_punidos_do_dia->bindParam(':servicoDoDia', $servicoDoDia);
        $consultar_punidos_do_dia->execute();
        $resultado_punidos = $consultar_punidos_do_dia->rowCount();

        $html .= "<p><strong>06. PUNIDOS</strong> ";
        if ($resultado_punidos > 0) {
            $html .= "
         <table>
            <tr>
               <th>GRAD</th>
               <th>Nº</th>
               <th>NOME</th>
               <th>SU</th>
               <th>INÍCIO</th>
               <th>LIBERDADE</th>
               <th>DIAS</th>
               <th>PUNIÇÃO</th>
               <th>BI</th>
            </tr>
         ";

            while ($resultado = $consultar_punidos_do_dia->fetch(PDO::FETCH_ASSOC)) {
                $agora = date($servicoDoDia);
                $datax2 = date("d-m-Y", strtotime($resultado['liberdade']));
                $data_inicio = new DateTime($resultado['inicio']);
                $data_fim = new DateTime($resultado['liberdade']);
                $dateInterval = $data_inicio->diff($data_fim);

                if (strtotime($resultado['liberdade']) > strtotime($agora)) {
                    $html .= " <tbody><tr class='info'>";
                } elseif (strtotime($resultado['liberdade']) == strtotime($agora)) {
                    $html .= " <tbody><tr class='warning'>";
                } else {
                    $html .= " <tbody><tr class='danger'>";
                }

                $html .= "<td>" . ($resultado["graduacao"]) . "</td>";
                $html .= "<td>" . ($resultado["numero"]) . "</td>";
                $html .= "<td>" . strtoupper($resultado["nomecompleto"]) . "</td>";
                $html .= "<td>" . ($resultado["su"]) . "</td>";
                $html .= "<td>" . (date("d-m-Y", strtotime($resultado["inicio"]))) . "</td>";
                $html .= "<td>" . (date("d-m-Y", strtotime($resultado["liberdade"]))) . "</td>";
                $html .= "<td>" . ($dateInterval->days) . "</td>";

                if ($resultado['punicao'] == '1') {
                    $html .= "<td class='td'><font color='black'>ADVERTÊNCIA</font></td>";
                }
                if ($resultado['punicao'] == '2') {
                    $html .= "<td class='td'><font color='black'>IMP DISCIPLINAR</font></td>";
                }

                if ($resultado['punicao'] == '3') {
                    $html .= "<td class='td'><font color='black'>REPREENSÃO</font></td>";
                }

                if ($resultado['punicao'] == '4') {
                    $html .= "<td class='td'><font color='black'>DETENÇÃO</font></td>";
                }

                if ($resultado['punicao'] == '5') {
                    $html .= "<td class='td'><font color='black'>PRISÇAO</font></td>";
                }

                $html .= "<td>" . utf8_encode($resultado["bi"]) . "</td>";

                $html .= "</tr>";
            }
            $html .= "</tbody></table>";
        } else {
            $html .= "<br>Não há.";
        }

        $ocorrencias_scmt1 = nl2br($ocorrencias_scmt);
        $ocorrencias_fiscal2 = nl2br($ocorrencias_fiscal);
        $html .= "<p><strong>07. OCORRÊNCIAS</strong><BR> $ocorrencias_scmt1</p>";
        $html .= "<p><strong>08.PASSAGEM DO SERVIÇO: </strong> Fiz ao <strong>$servicoPassadoAo</strong>, ao qual transmiti todas as ordens em vigor.</p><br><br><br>";

        $html .= " <div  align='center'>______________________________________________________</div>";
        $html .= " <div  align='center'> <strong>$servicoOfDia - Of Dia</strong></div>";

        $DIAPASSAGEM = date("d-m-Y", strtotime($servicoParaODia));
        $html .= "<div  align='center'> SANTIAGO, RS $DIAPASSAGEM.</div>";

        $stylesheet = "
         table{
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
         }
         th{
            border: 1px solid black;
         }
         td{
            border: 1px solid black;
         }
         @page {
            background: transparent url('" . $path . 'logo2.png' . "') no-repeat 50% 50%;
         }
         ";

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDisplayMode('fullpage');
        $titulo = "Passagem de servico do dia $doDiaFormatado para o dia $DIAPASSAGEM ao S Cmt";
        $mpdf->SetTitle($titulo);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $mpdf->showWatermarkImage = true;
        //$mpdf->Output("relatorios/APROV - Militares arranchados do dia $data_inicio_formatada ao dia $data_fim_formatada.pdf", \Mpdf\Output\Destination::INLINE);
        ob_clean();
        $mpdf->Output($path . "relatorios/scmt/$titulo.pdf", \Mpdf\Output\Destination::FILE);
        $pdf = "relatorios/scmt/$titulo.pdf";
        echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => 'ok', 'pdf' => $pdf, 'status' => 'success'));
    } else {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "SERVIÇO DO DIA $doDiaFormatado NÃO FOI ASSINADO", 'status' => 'error'));
        return false;
    }
}

if ($acao == "gerar_relatorio_fiscal_adm") {

    if ($servicoAssinaturaOfDia != "") {

        $html = " <div  align='center'> <img src='" . $path . 'logo.jpg' . "'height='105' width='210'></div>";
        $html .= "
         <div style='margin-left:550px;margin-top:-100'>
            <table width='150'>
            <tbody>
               <tr>
                  <th>VISTO:<br><br>______________<br>Fisc Adm</th>
               </tr>
            </tbody>
            </table>
         </div> ";
        $html .= "<div  style='margin-top:30' align='center'> <b> RELATÓRIO DE PARTE DO SERVIÇO DE OFICIAL DE DIA  </b> </div>";

        $html .= "<div  align='center'> <b> AO FISCAL ADMINISTRATIVO </b> </div> ";
        $html .= "<p><strong>01. RECEBIMENTO DO SERVIÇO: </strong> Recebi do <strong>$servicoRecebidoDo</strong>, com todas as ordens em vigor.</p>";

        $cadeadosguarda = nl2br($cadeadosguarda);
        $html .= "<p><strong>02. CADEADOS</strong><BR> $cadeadosguarda</p>";

        $html .= "
         <p>
            <strong>03. SOBRAS E RESIDUOS </strong><br>
            Sobras: $sobras kg.<br>
            Residuos: $residuos kg.
         </p>";
        $html .= "
         <p>
            <strong>04. CONSUMO D'ÁGUA E DE ENERGIA ELÉTRICA</strong>
            <table>
               <thead>
                  <tr>
                  <th>DISCRIMINAÇÃO</th>
                  <th>LEITURA ATUAL</th>
                  <th>LEITURA ANTERIOR</th>
                  <th>CONSUMO</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>ÁGUA</td>
                     <td>$atualagua</td>
                     <td>$anterioragua</td>
                     <td>$consumoagua M³</td>
                  </tr>
                  <tr>
                     <td>LUZ - 03</td>
                     <td>$atual03</td>
                     <td>$anterior03</td>
                     <td>$consumo03 KW/H</td>
                  </tr>
                  <tr>
                     <td>LUZ - 24</td>
                     <td>$atual24</td>
                     <td>$anterior24</td>
                     <td>$consumo24 KVA/H</td>
                  </tr>
                  <tr>
                     <td>LUZ - 52</td>
                     <td>$atual52</td>
                     <td>$anterior52</td>
                     <td>$consumo52 DEM</td>
                  </tr>
               </tbody>
            </table>
         </p>";
        $municao1 = nl2br($municao);
        $instalacoes1 = nl2br($instalacoes);
        $ocorrencias_fiscal1 = nl2br($ocorrencias_fiscal);
        $html .= "<p><strong>05. MUNIÇÃO</strong><BR>$municao1</p>";
        $html .= "<p><strong>06. INSTALAÇÕES</strong><BR>$instalacoes1</p>";

        $html .= "<p><strong>07. OCORRÊNCIAS</strong><BR> $ocorrencias_fiscal1</p>";

        $html .= "<p><strong>08.PASSAGEM DO SERVIÇO: </strong> Fiz ao <strong>$servicoPassadoAo</strong>, ao qual transmiti todas as ordens em vigor.</p></b></b></b></b>";

        $html .= " <div  align='center'>______________________________________________________</div>";
        $html .= " <div  align='center'> <strong>$servicoOfDia - Of Dia</strong></div>";

        $DIAPASSAGEM = date("d-m-Y", strtotime($servicoParaODia));
        $html .= "<div  align='center'> SANTIAGO, RS $DIAPASSAGEM.</div>";

        $stylesheet = "
         table{
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
         }
         th{
            order: 1px solid black;
         }
         td{
            border: 1px solid black;
         }
         @page {
            background: transparent url('" . $path . 'logo2.png' . "') no-repeat 50% 50%;
         }
         ";
        ///$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
        /*$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs      = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData          = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
        'fontDir'      => array_merge($fontDirs, [
        __DIR__ . '/fonts',
        ]),
        'fontdata'     => $fontData + [
        'frutiger' => [
        'R' => 'calibril.ttf',
        'I' => 'calibrili.ttf',
        ],
        ],
        'default_font' => 'calibril',
        ]);*/
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDisplayMode('fullpage');
        $titulo = "Passagem de servico do dia $doDiaFormatado para o dia $DIAPASSAGEM ao Fiscal Adm";
        $mpdf->SetTitle($titulo);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $mpdf->showWatermarkImage = true;
        //$mpdf->Output("relatorios/APROV - Militares arranchados do dia $data_inicio_formatada ao dia $data_fim_formatada.pdf", \Mpdf\Output\Destination::INLINE);
        ob_clean();
        $mpdf->Output($path . "relatorios/fiscaladm/$titulo.pdf", \Mpdf\Output\Destination::FILE);
        $pdf = "relatorios/fiscaladm/$titulo.pdf";
        echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => 'ok', 'pdf' => $pdf, 'status' => 'success'));
    } else {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "SERVIÇO DO DIA $doDiaFormatado NÃO FOI ASSINADO", 'status' => 'error'));
        return false;
    }
}