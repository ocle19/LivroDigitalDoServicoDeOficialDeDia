<?php
session_start();
include('./../connection.php');
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 0;

if ($acao == 'deletar_punicao') {
   if ($nivel <= 0) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
      return false;
   }
   $pdo->beginTransaction();
   $pdo->prepare("START TRANSACTION");
   $id_punicao = filter_input(INPUT_POST, 'punicao', FILTER_SANITIZE_STRING);
   $deletar_punicao = $pdo->prepare("DELETE FROM punidos WHERE id= :id");
   $deletar_punicao->bindParam(':id', $id_punicao);
   $deletar_punicao->execute();

   if ($deletar_punicao) {
      $pdo->commit();
      echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'status' => 'success'));
      return false;
   } else {
      $pdo->rollBack();
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Ocorreu um problema ao deletar a punição, tente novamente", 'status' => 'success'));
      return false;
   }
}

if ($acao == 'cadastrar_punicao') {
   if ($nivel <= 0) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
      return false;
   }

   $doDia = filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING);
   if ($doDia != "Selecione") {
      $nomecompletopunido = filter_input(INPUT_POST, 'nomecompleto', FILTER_SANITIZE_STRING);
      $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
      $su = filter_input(INPUT_POST, 'su', FILTER_SANITIZE_STRING);
      $inicio = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'inicio', FILTER_SANITIZE_STRING)));

      $liberdade = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'liberdade', FILTER_SANITIZE_STRING)));
      $grad = filter_input(INPUT_POST, 'grad', FILTER_SANITIZE_STRING);
      $punicao = filter_input(INPUT_POST, 'punicao', FILTER_SANITIZE_STRING);
      $bi = filter_input(INPUT_POST, 'bi', FILTER_SANITIZE_STRING);
      $d = filter_input(INPUT_POST, 'punicao', FILTER_SANITIZE_STRING);
      if (empty($nomecompletopunido)) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o nome completo.", 'status' => 'warning'));
         return false;
      } else if ($numero <= -1) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o número, digite 0 (zero) caso não haja.", 'status' => 'warning'));
         return false;
      } else if (empty($su)) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione a subUnidade", 'status' => 'warning'));
         return false;
      } else if (empty($punicao)) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione o tipo de punição", 'status' => 'warning'));
         return false;
      } else if (empty($bi)) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o número do BI", 'status' => 'warning'));
         return false;
      } else {
         $consultapunido = $pdo->prepare("SELECT nomecompleto FROM punidos WHERE nomecompleto = :nomecompletopunido and liberdade > :doDia");
         $consultapunido->bindParam(':nomecompletopunido', $nomecompletopunido);
         $consultapunido->bindParam(':doDia', $doDia);
         $consultapunido->execute();
         ///$consultapunido->debugDumpParams();

         $resultadopunido = $consultapunido->rowCount();
         if ($resultadopunido > 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => $nomecompletopunido . " já está cadastrado nesse período!", 'status' => 'warning'));
            return false;
         } else {
            $pdo->beginTransaction();
            $pdo->prepare("START TRANSACTION");
            $query_punido = $pdo->prepare("INSERT INTO punidos 
               (graduacao, numero, nomecompleto, su, inicio, liberdade, punicao, bi) 
               VALUES (:graduacao, :numero, :nomecompleto, :su, :inicio, :liberdade, :punicao, :bi)");
            $query_punido->bindParam(':graduacao', $grad);
            $query_punido->bindParam(':numero', $numero);
            $query_punido->bindParam(':nomecompleto', $nomecompletopunido);
            $query_punido->bindParam(':su', $su);
            $query_punido->bindParam(':inicio', $inicio);
            $query_punido->bindParam(':liberdade', $liberdade);
            $query_punido->bindParam(':punicao', $punicao);
            $query_punido->bindParam(':bi', $bi);
            $query_punido->execute();

            if ($query_punido) {
               $pdo->commit();
               echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'dia' => $doDia, 'status' => 'success'));
               return false;
            } else {
               $pdo->rollBack();
               echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Não foi possível cadastrar, tente novamente.", 'status' => 'error'));
               return false;
            }
         }
      }
   } else {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione um serviço!", 'status' => 'success'));
      return false;
   }
}

if ($acao == 'listar_punidos_do_dia') {
   if ($nivel <= 0) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
      return false;
   }
   $doDia = filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING);
   $consultapunidos_do_dia = $pdo->prepare("SELECT * FROM punidos where :doDia BETWEEN inicio and DATE_ADD(liberdade, INTERVAL -1 DAY)");
   $consultapunidos_do_dia->bindParam(':doDia', $doDia);
   $consultapunidos_do_dia->execute();
   $resultadopunidos = $consultapunidos_do_dia->rowCount();
   // Verifica se a consulta retornou linhas

   if ($resultadopunidos > 0) {
      $diadia = date("d-m-Y", strtotime($doDia));
      // Atribui o código HTML para montar uma tabela
      $tabela = "
      <div class='panel-group'>
         <div class='panel panel-primary'>
            <div class='panel-heading'><center> Punidos dentro do período do dia $diadia...</center></div>
               <div class='panel-body'>
                  <div class='col-md-12'>
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
         //  echo $dateInterval->days;

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
         //  $return.= "<td>" . utf8_encode($datax2) . "</td>";
         // $return.= "<td>" . $datax2 . "</td>";

         if ($linha['punicao'] == '1') {
            $return .= "<td class='td'><b><font color='blue'>Advertência</font></b></td>";
         }
         if ($linha['punicao'] == '2') {
            $return .= "<td class='td'><b><font color='green'>Impedido Disciplinarmente</font></b></td>";
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
      echo $return .= "
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>";
   } else {
      echo 'Não há punições cadastradas.';
   }
}
