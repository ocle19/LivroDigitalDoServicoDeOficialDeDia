<?php
session_start();
include __DIR__ . "/../connection.php";
$acao = $_POST["acao"] ?? null;
$nivel = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 0;

if (($acao == "cadastrar")) {
    if ($nivel <= 0) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
        return false;
    }
    ## S CMT
    $doDia = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'dodia', FILTER_SANITIZE_STRING)));
    $paraodia = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'paraodia', FILTER_SANITIZE_STRING)));

    /*$consultar_servico_posterior = $pdo->prepare("SELECT * FROM aosubcmt where :doDia = DATE_ADD(doDia, INTERVAL +1 DAY)");
    $consultar_servico_posterior->bindParam(':doDia', $doDia);
    $consultar_servico_posterior->execute();
    $resultado_servico_posterior = $consultar_servico_posterior->rowCount();
    NÃO UTILIZADO
     */

    $recebido = filter_input(INPUT_POST, 'recebido', FILTER_SANITIZE_STRING);
    $ofdia = filter_input(INPUT_POST, 'ofdia', FILTER_SANITIZE_STRING);

    $pessoaldesv = htmlentities(filter_input(INPUT_POST, 'pessoaldesv', FILTER_DEFAULT));
    $paradadiaria = htmlentities(filter_input(INPUT_POST, 'paradadiaria', FILTER_DEFAULT));

    $revistadorecolher = htmlentities(filter_input(INPUT_POST, 'revistadorecolher', FILTER_DEFAULT));
    $ronda1 = filter_input(INPUT_POST, 'ronda1', FILTER_SANITIZE_STRING);
    $ronda2 = filter_input(INPUT_POST, 'ronda2', FILTER_SANITIZE_STRING);

    $gdhfechamentobc = filter_input(INPUT_POST, 'gdhfechamentobc', FILTER_SANITIZE_STRING);
    $gdhaberturabc = filter_input(INPUT_POST, 'gdhaberturabc', FILTER_SANITIZE_STRING);
    $lacrebc = filter_input(INPUT_POST, 'lacrebc', FILTER_SANITIZE_STRING);
    $cadeadobc = filter_input(INPUT_POST, 'cadeadobc', FILTER_SANITIZE_STRING);

    $gdhfechamento1 = filter_input(INPUT_POST, 'gdhfechamento1', FILTER_SANITIZE_STRING);
    $gdhabertura1 = filter_input(INPUT_POST, 'gdhabertura1', FILTER_SANITIZE_STRING);
    $lacre1 = filter_input(INPUT_POST, 'lacre1', FILTER_SANITIZE_STRING);
    $cadeado1 = filter_input(INPUT_POST, 'cadeado1', FILTER_SANITIZE_STRING);

    $gdhfechamento2 = filter_input(INPUT_POST, 'gdhfechamento2', FILTER_SANITIZE_STRING);
    $gdhabertura2 = filter_input(INPUT_POST, 'gdhabertura2', FILTER_SANITIZE_STRING);
    $lacre2 = filter_input(INPUT_POST, 'lacre2', FILTER_SANITIZE_STRING);
    $cadeado2 = filter_input(INPUT_POST, 'cadeado2', FILTER_SANITIZE_STRING);

    $gdhfechamento3 = filter_input(INPUT_POST, 'gdhfechamento3', FILTER_SANITIZE_STRING);
    $gdhabertura3 = filter_input(INPUT_POST, 'gdhabertura3', FILTER_SANITIZE_STRING);
    $lacre3 = filter_input(INPUT_POST, 'lacre3', FILTER_SANITIZE_STRING);
    $cadeado3 = filter_input(INPUT_POST, 'cadeado3', FILTER_SANITIZE_STRING);

    $lacresalacom = filter_input(INPUT_POST, 'lacresalacombc', FILTER_SANITIZE_STRING);

    $ocorrenciasScmt = htmlentities(filter_input(INPUT_POST, 'ocorrenciasscmt', FILTER_DEFAULT));

    ##FISCAL
    $cadeadosguarda = htmlentities(filter_input(INPUT_POST, 'cadeadosguarda', FILTER_DEFAULT));
    $sobras = filter_input(INPUT_POST, 'sobras', FILTER_SANITIZE_STRING);
    $residuos = filter_input(INPUT_POST, 'residuos', FILTER_SANITIZE_STRING);
    $instalacoes = htmlentities(filter_input(INPUT_POST, 'intalacoes', FILTER_DEFAULT));

    $leituraatualagua = filter_input(INPUT_POST, 'leituraatualagua', FILTER_SANITIZE_STRING);
    $leituraanterioragua = filter_input(INPUT_POST, 'leituraanterioragua', FILTER_SANITIZE_STRING);
    $consumoagua = filter_input(INPUT_POST, 'consumoagua', FILTER_SANITIZE_STRING);

    $leituraatual03 = filter_input(INPUT_POST, 'leituraatual03', FILTER_SANITIZE_STRING);
    $leituraanterior03 = filter_input(INPUT_POST, 'leituraanterior03', FILTER_SANITIZE_STRING);
    $consumo03 = filter_input(INPUT_POST, 'consumo03', FILTER_SANITIZE_STRING);

    $leituraatual24 = filter_input(INPUT_POST, 'leituraatual24', FILTER_SANITIZE_STRING);
    $leituraanterior24 = filter_input(INPUT_POST, 'leituraanterior24', FILTER_SANITIZE_STRING);
    $consumo24 = filter_input(INPUT_POST, 'consumo24', FILTER_SANITIZE_STRING);

    $leituraatual52 = filter_input(INPUT_POST, 'leituraatual52', FILTER_SANITIZE_STRING);
    $leituraanterior52 = filter_input(INPUT_POST, 'leituraanterior52', FILTER_SANITIZE_STRING);
    $consumo52 = filter_input(INPUT_POST, 'consumo52', FILTER_SANITIZE_STRING);

    $assinatura = filter_input(INPUT_POST, 'assinaturaAdj', FILTER_SANITIZE_STRING);

    $municao = htmlentities(filter_input(INPUT_POST, 'municao', FILTER_DEFAULT));
    $ocorrenciasfiscaladm = htmlentities(filter_input(INPUT_POST, 'ocorrenciasfiscal', FILTER_DEFAULT));

    $consultar_servico_existe = $pdo->prepare("SELECT doDia, paraoDia FROM aosubcmt WHERE doDia = :doDia OR paraoDia= :paraodia");
    $consultar_servico_existe->bindParam(':doDia', $doDia);
    $consultar_servico_existe->bindParam(':paraodia', $paraodia);
    $consultar_servico_existe->execute();
    $servico_existe = $consultar_servico_existe->rowCount();

    if ($servico_existe > 0) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Já tem um serviço registrado nessa data!', 'status' => 'error'));
        return false;
    } else {
        if (empty($assinatura)) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Não foi localizada uma assinatura para o ADJ, tente recarregar a página, se o erro persistir, contate o administrador do sistema.', 'status' => 'error'));
            return false;
        } else if (empty($ofdia) || $ofdia == "Selecione") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione o Oficial de dia que está entrando de serviço. ', 'status' => 'error'));
            return false;
        } else if (empty($recebido) || $recebido == "Selecione") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione o Oficial que está saindo de serviço. ', 'status' => 'error'));
            return false;
        } else if ($ofdia == $recebido) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'O Oficial de Dia que está entrando não pode ser o mesmo que está saindo de serviço!', 'status' => 'error'));
            return false;
        } else if ($doDia == $paraodia) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'As datas não podem ser iguais', 'status' => 'error'));
            return false;
        } else if (strlen($pessoaldesv) <= 10) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite pelo menos 10 caracteres na parte do PESSOAL DE SERVIÇO. ', 'status' => 'error'));
            return false;
        } else if (strlen($ronda1) <= 4) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um horário na 1ª RONDA DO OF DIA no seguinte formato: 10:00 ', 'status' => 'error'));
            return false;
        } else if (strlen($ronda2) <= 4) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um horário na 2ª RONDA DO OF DIA no seguinte formato: 10:00 ', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamentobc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($gdhaberturabc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamento1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da 1ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhabertura1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da 1º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamento2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhabertura2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamento3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da 3º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhabertura3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da 3ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacrebc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($cadeadobc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($lacre1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da 1ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($cadeado1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da 1º BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacre2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($cadeado2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacre3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da 3º BO', 'status' => 'error'));
            return false;
        } else if (strlen($cadeado3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da 3ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacresalacom) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da SALA COM BC', 'status' => 'error'));
            return false;
        } else if (strlen($sobras) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a sobra de alimentos', 'status' => 'error'));
            return false;
        } else if (strlen($residuos) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o redisuo de alimentos', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatualagua) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual da água', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterioragua) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior da água', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatual03) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual luz 03', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterior03) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior luz 03', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatual24) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual luz 24', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterior24) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior luz 24', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatual52) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual luz 52', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterior52) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior luz 52', 'status' => 'error'));
            return false;
        } else if (strlen($consumoagua) <= 0 || $consumoagua == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da água novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        } else if (strlen($consumo03) <= 0 || $consumo03 == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da luz 03 novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        } else if (strlen($consumo24) <= 0 || $consumo24 == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da luz 24 novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        } else if (strlen($consumo52) <= 0 || $consumo52 == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da luz 52 novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        }
        try {

            $pdo->beginTransaction();
            $erros = 1;
            try {
                $pdo->prepare("START TRANSACTION");
                $query_aoscmt = $pdo->prepare("INSERT INTO aosubcmt
                    (ofdia, doDia, paraoDia, recebiDo, pessoalDeSv, paradaDiaria, RevistadoRecolher, assinaturaAdj)
                    VALUES (:ofdia, :doDia, :paraodia, :recebido, :pessoaldesv, :paradadiaria, :revistadorecolher, :assinatura)");

                $query_aoscmt->bindParam(':ofdia', $ofdia);
                $query_aoscmt->bindParam(':doDia', $doDia);
                $query_aoscmt->bindParam(':paraodia', $paraodia);
                $query_aoscmt->bindParam(':recebido', $recebido);
                $query_aoscmt->bindParam(':pessoaldesv', $pessoaldesv);
                $query_aoscmt->bindParam(':paradadiaria', $paradadiaria);
                $query_aoscmt->bindParam(':revistadorecolher', $revistadorecolher);
                $query_aoscmt->bindParam(':assinatura', $assinatura);
                $query_aoscmt->execute();
                $erros += $query_aoscmt->rowCount();

                $query_rondasOfdia = $pdo->prepare("INSERT INTO rondaOfdia (rondaOfdia.data, ronda1, ronda2) VALUES (:doDia, :ronda1, :ronda2)");
                $query_rondasOfdia->bindParam(':doDia', $doDia);
                $query_rondasOfdia->bindParam(':ronda1', $ronda1);
                $query_rondasOfdia->bindParam(':ronda2', $ronda2);
                $query_rondasOfdia->execute();
                $erros += $query_rondasOfdia->rowCount();

                $query_ocorrenciasaoscmt = $pdo->prepare("INSERT INTO ocorrenciasaoscmt (ocorrenciasaoscmt.data, descricao) VALUES (:doDia, :descricao)");
                $query_ocorrenciasaoscmt->bindParam(':doDia', $doDia);
                $query_ocorrenciasaoscmt->bindParam(':descricao', $ocorrenciasScmt);
                $query_ocorrenciasaoscmt->execute();
                $erros += $query_ocorrenciasaoscmt->rowCount();

                $query_cadeadosguarda = $pdo->prepare("INSERT INTO cadeadosguarda (cadeadosguarda.data, descricao) VALUES (:doDia, :descricao)");
                $query_cadeadosguarda->bindParam(':doDia', $doDia);
                $query_cadeadosguarda->bindParam(':descricao', $cadeadosguarda);
                $query_cadeadosguarda->execute();
                $erros += $query_cadeadosguarda->rowCount();

                $query_ocorrenciasaofiscao = $pdo->prepare("INSERT INTO ocorrenciasaofiscal (ocorrenciasaofiscal.data, descricao) VALUES (:doDia, :descricao)");
                $query_ocorrenciasaofiscao->bindParam(':doDia', $doDia);
                $query_ocorrenciasaofiscao->bindParam(':descricao', $ocorrenciasfiscaladm);
                $query_ocorrenciasaofiscao->execute();
                $erros += $query_ocorrenciasaofiscao->rowCount();

                $query_municao = $pdo->prepare("INSERT INTO municao (municao.data, descricao) VALUES (:doDia, :descricao)");
                $query_municao->bindParam(':doDia', $doDia);
                $query_municao->bindParam(':descricao', $municao);
                $query_municao->execute();
                $erros += $query_municao->rowCount();

                $query_instalacoes = $pdo->prepare("INSERT INTO instalacoes (instalacoes.data, descricao) VALUES (:doDia, :descricao)");
                $query_instalacoes->bindParam(':doDia', $doDia);
                $query_instalacoes->bindParam(':descricao', $municao);
                $query_instalacoes->execute();
                $erros += $query_instalacoes->rowCount();

                $query_agua = $pdo->prepare("INSERT INTO agua (agua.data, atual, anterior, consumo) VALUES (:doDia, :atual, :anterior, :consumo)");
                $query_agua->bindParam(':doDia', $doDia);
                $query_agua->bindParam(':atual', $leituraatualagua);
                $query_agua->bindParam(':anterior', $leituraanterioragua);
                $query_agua->bindParam(':consumo', $consumoagua);
                $query_agua->execute();
                $erros += $query_agua->rowCount();

                $query_luz03 = $pdo->prepare("INSERT INTO luz03 (luz03.data, atual, anterior, consumo) VALUES (:doDia, :atual, :anterior, :consumo)");
                $query_luz03->bindParam(':doDia', $doDia);
                $query_luz03->bindParam(':atual', $leituraatual03);
                $query_luz03->bindParam(':anterior', $leituraanterior03);
                $query_luz03->bindParam(':consumo', $consumo03);
                $query_luz03->execute();
                $erros += $query_luz03->rowCount();

                $query_luz24 = $pdo->prepare("INSERT INTO luz24 (luz24.data, atual, anterior, consumo) VALUES (:doDia, :atual, :anterior, :consumo)");
                $query_luz24->bindParam(':doDia', $doDia);
                $query_luz24->bindParam(':atual', $leituraatual24);
                $query_luz24->bindParam(':anterior', $leituraanterior24);
                $query_luz24->bindParam(':consumo', $consumo24);
                $query_luz24->execute();
                $erros += $query_luz24->rowCount();

                $query_luz52 = $pdo->prepare("INSERT INTO luz52 (luz52.data, atual, anterior, consumo) VALUES (:doDia, :atual, :anterior, :consumo)");
                $query_luz52->bindParam(':doDia', $doDia);
                $query_luz52->bindParam(':atual', $leituraatual52);
                $query_luz52->bindParam(':anterior', $leituraanterior52);
                $query_luz52->bindParam(':consumo', $consumo52);
                $query_luz52->execute();
                $erros += $query_luz52->rowCount();

                $query_reserva1 = $pdo->prepare("INSERT INTO reservaprimeira
                    (reservaprimeira.data, gdhfechamento, gdhabertura, lacre, cadeados)
                    VALUES (:doDia, :gdhfechamento, :gdhabertura, :lacre, :cadeados)");
                $query_reserva1->bindParam(':doDia', $doDia);
                $query_reserva1->bindParam(':gdhfechamento', $gdhfechamento1);
                $query_reserva1->bindParam(':gdhabertura', $gdhabertura1);
                $query_reserva1->bindParam(':lacre', $lacre1);
                $query_reserva1->bindParam(':cadeados', $cadeado1);
                $query_reserva1->execute();
                $erros += $query_reserva1->rowCount();

                $query_reserva2 = $pdo->prepare("INSERT INTO reservasegunda
                    (reservasegunda.data, gdhfechamento, gdhabertura, lacre, cadeados)
                    VALUES (:doDia, :gdhfechamento, :gdhabertura, :lacre, :cadeados)");
                $query_reserva2->bindParam(':doDia', $doDia);
                $query_reserva2->bindParam(':gdhfechamento', $gdhfechamento2);
                $query_reserva2->bindParam(':gdhabertura', $gdhabertura2);
                $query_reserva2->bindParam(':lacre', $lacre2);
                $query_reserva2->bindParam(':cadeados', $cadeado2);
                $query_reserva2->execute();
                $query_reserva2->execute();
                $erros += $query_reserva2->rowCount();

                $query_reserva3 = $pdo->prepare("INSERT INTO reservaterceira
                    (reservaterceira.data, gdhfechamento, gdhabertura, lacre, cadeados)
                    VALUES (:doDia, :gdhfechamento, :gdhabertura, :lacre, :cadeados)");
                $query_reserva3->bindParam(':doDia', $doDia);
                $query_reserva3->bindParam(':gdhfechamento', $gdhfechamento3);
                $query_reserva3->bindParam(':gdhabertura', $gdhabertura3);
                $query_reserva3->bindParam(':lacre', $lacre3);
                $query_reserva3->bindParam(':cadeados', $cadeado3);
                $query_reserva3->execute();
                $erros += $query_reserva3->rowCount();

                $query_reservabc = $pdo->prepare("INSERT INTO reservabc
                    (reservabc.data, gdhfechamento, gdhabertura, lacre, cadeados)
                    VALUES (:doDia, :gdhfechamento, :gdhabertura, :lacre, :cadeados)");
                $query_reservabc->bindParam(':doDia', $doDia);
                $query_reservabc->bindParam(':gdhfechamento', $gdhfechamentobc);
                $query_reservabc->bindParam(':gdhabertura', $gdhaberturabc);
                $query_reservabc->bindParam(':lacre', $lacrebc);
                $query_reservabc->bindParam(':cadeados', $cadeadobc);
                $query_reservabc->execute();
                $erros += $query_reservabc->rowCount();

                $query_reservacom = $pdo->prepare("INSERT INTO salacombc (salacombc.data, lacre) VALUES (:doDia, :lacre)");
                $query_reservacom->bindParam(':doDia', $doDia);
                $query_reservacom->bindParam(':lacre', $lacresalacom);
                $query_reservacom->execute();
                $erros += $query_reservacom->rowCount();

                $query_sobraseresiduos = $pdo->prepare("INSERT INTO sobraseresiduos
                    (sobraseresiduos.data, sobra, residuos)
                    VALUES (:doDia, :sobras, :residuos)");
                $query_sobraseresiduos->bindParam(':doDia', $doDia);
                $query_sobraseresiduos->bindParam(':sobras', $sobras);
                $query_sobraseresiduos->bindParam(':residuos', $residuos);
                $query_sobraseresiduos->execute();
                $erros += $query_sobraseresiduos->rowCount();
            } catch (PDOException $exception) {
                $pdo->rollBack();
                echo json_encode(array('resposta' => 'Oops', 'mensagem' => $exception->getMessage(), 'status' => 'error'));
                $erros = 20;
                return false;
            }

            if ($erros == 18) {
                $pdo->commit();
                echo json_encode(array('resposta' => 'Serviço cadastrado!', 'mensagem' => 'ok', 'status' => 'success', 'irpara' => 'painel.php?func=editarServico'));
                return false;
            } else {
                $pdo->rollBack();
                echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Ocorreu algum erro em alguma inserção. Verifique os dados e tente novamente!' . $erros, 'status' => 'error'));
                return false;
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Erro ao adicionar primeira parte do SV! z \n Tente novamente', 'status' => 'error'));
            return false;
        }
    }
} elseif ($acao == "alterar") {
    if ($nivel <= 0) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
        return false;
    }
    ## S CMT
    $doDia = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'dodia', FILTER_SANITIZE_STRING)));
    $paraodia = date("Y-m-d", strtotime(filter_input(INPUT_POST, 'paraodia', FILTER_SANITIZE_STRING)));

    /*$consultar_servico_posterior = $pdo->prepare("SELECT * FROM aosubcmt where :doDia = DATE_ADD(doDia, INTERVAL +1 DAY)");
    $consultar_servico_posterior->bindParam(':doDia', $doDia);
    $consultar_servico_posterior->execute();
    $resultado_servico_posterior = $consultar_servico_posterior->rowCount();
    NÃO UTILIZADO
     */

    $recebido = filter_input(INPUT_POST, 'recebido', FILTER_SANITIZE_STRING);
    $ofdia = filter_input(INPUT_POST, 'ofdia', FILTER_SANITIZE_STRING);

    $pessoaldesv = htmlentities(filter_input(INPUT_POST, 'pessoaldesv', FILTER_DEFAULT));
    $paradadiaria = htmlentities(filter_input(INPUT_POST, 'paradadiaria', FILTER_DEFAULT));

    $revistadorecolher = htmlentities(filter_input(INPUT_POST, 'revistadorecolher', FILTER_DEFAULT));
    $ronda1 = filter_input(INPUT_POST, 'ronda1', FILTER_SANITIZE_STRING);
    $ronda2 = filter_input(INPUT_POST, 'ronda2', FILTER_SANITIZE_STRING);

    $gdhfechamentobc = filter_input(INPUT_POST, 'gdhfechamentobc', FILTER_SANITIZE_STRING);
    $gdhaberturabc = filter_input(INPUT_POST, 'gdhaberturabc', FILTER_SANITIZE_STRING);
    $lacrebc = filter_input(INPUT_POST, 'lacrebc', FILTER_SANITIZE_STRING);
    $cadeadobc = filter_input(INPUT_POST, 'cadeadobc', FILTER_SANITIZE_STRING);

    $gdhfechamento1 = filter_input(INPUT_POST, 'gdhfechamento1', FILTER_SANITIZE_STRING);
    $gdhabertura1 = filter_input(INPUT_POST, 'gdhabertura1', FILTER_SANITIZE_STRING);
    $lacre1 = filter_input(INPUT_POST, 'lacre1', FILTER_SANITIZE_STRING);
    $cadeado1 = filter_input(INPUT_POST, 'cadeado1', FILTER_SANITIZE_STRING);

    $gdhfechamento2 = filter_input(INPUT_POST, 'gdhfechamento2', FILTER_SANITIZE_STRING);
    $gdhabertura2 = filter_input(INPUT_POST, 'gdhabertura2', FILTER_SANITIZE_STRING);
    $lacre2 = filter_input(INPUT_POST, 'lacre2', FILTER_SANITIZE_STRING);
    $cadeado2 = filter_input(INPUT_POST, 'cadeado2', FILTER_SANITIZE_STRING);

    $gdhfechamento3 = filter_input(INPUT_POST, 'gdhfechamento3', FILTER_SANITIZE_STRING);
    $gdhabertura3 = filter_input(INPUT_POST, 'gdhabertura3', FILTER_SANITIZE_STRING);
    $lacre3 = filter_input(INPUT_POST, 'lacre3', FILTER_SANITIZE_STRING);
    $cadeado3 = filter_input(INPUT_POST, 'cadeado3', FILTER_SANITIZE_STRING);

    $lacresalacom = filter_input(INPUT_POST, 'lacresalacombc', FILTER_SANITIZE_STRING);

    $ocorrenciasScmt = htmlentities(filter_input(INPUT_POST, 'ocorrenciasscmt', FILTER_DEFAULT));

    ##FISCAL
    $cadeadosguarda = htmlentities(filter_input(INPUT_POST, 'cadeadosguarda', FILTER_DEFAULT));
    $sobras = filter_input(INPUT_POST, 'sobras', FILTER_SANITIZE_STRING);
    $residuos = filter_input(INPUT_POST, 'residuos', FILTER_SANITIZE_STRING);
    $instalacoes = htmlentities(filter_input(INPUT_POST, 'instalacoes', FILTER_DEFAULT));

    $leituraatualagua = filter_input(INPUT_POST, 'leituraatualagua', FILTER_SANITIZE_STRING);
    $leituraanterioragua = filter_input(INPUT_POST, 'leituraanterioragua', FILTER_SANITIZE_STRING);
    $consumoagua = filter_input(INPUT_POST, 'consumoagua', FILTER_SANITIZE_STRING);

    $leituraatual03 = filter_input(INPUT_POST, 'leituraatual03', FILTER_SANITIZE_STRING);
    $leituraanterior03 = filter_input(INPUT_POST, 'leituraanterior03', FILTER_SANITIZE_STRING);
    $consumo03 = filter_input(INPUT_POST, 'consumo03', FILTER_SANITIZE_STRING);

    $leituraatual24 = filter_input(INPUT_POST, 'leituraatual24', FILTER_SANITIZE_STRING);
    $leituraanterior24 = filter_input(INPUT_POST, 'leituraanterior24', FILTER_SANITIZE_STRING);
    $consumo24 = filter_input(INPUT_POST, 'consumo24', FILTER_SANITIZE_STRING);

    $leituraatual52 = filter_input(INPUT_POST, 'leituraatual52', FILTER_SANITIZE_STRING);
    $leituraanterior52 = filter_input(INPUT_POST, 'leituraanterior52', FILTER_SANITIZE_STRING);
    $consumo52 = filter_input(INPUT_POST, 'consumo52', FILTER_SANITIZE_STRING);

    $municao = htmlentities(filter_input(INPUT_POST, 'municao', FILTER_DEFAULT));
    $ocorrenciasfiscaladm = htmlentities(filter_input(INPUT_POST, 'ocorrenciasfiscal', FILTER_DEFAULT));

    $consultar_servico_existe = $pdo->prepare("SELECT doDia, paraoDia FROM aosubcmt WHERE (doDia = :doDia OR paraoDia= :paraodia) and assinaturaOfDia = ''");
    $consultar_servico_existe->bindParam(':doDia', $doDia);
    $consultar_servico_existe->bindParam(':paraodia', $paraodia);
    $consultar_servico_existe->execute();
    $servico_existe = $consultar_servico_existe->rowCount();

    if ($servico_existe != 1) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Não há um serviço registrado nesta data ou já foi assinado pelo oficial de dia!', 'status' => 'error'));
        return false;
    } else {
        if (empty($ofdia) || $ofdia == "Selecione") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione o Oficial de dia que está entrando de serviço. ', 'status' => 'error'));
            return false;
        } else if (empty($recebido) || $recebido == "Selecione") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione o Oficial que está saindo de serviço. ', 'status' => 'error'));
            return false;
        } else if ($ofdia == $recebido) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'O Oficial de Dia que está entrando não pode ser o mesmo que está saindo de serviço!', 'status' => 'error'));
            return false;
        } else if ($doDia == $paraodia) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'As datas não podem ser iguais', 'status' => 'error'));
            return false;
        } else if (strlen($pessoaldesv) <= 10) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite pelo menos 10 caracteres na parte do PESSOAL DE SERVIÇO. ', 'status' => 'error'));
            return false;
        } else if (strlen($ronda1) <= 4) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um horário na 1ª RONDA DO OF DIA no seguinte formato: 10:00 ', 'status' => 'error'));
            return false;
        } else if (strlen($ronda2) <= 4) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um horário na 2ª RONDA DO OF DIA no seguinte formato: 10:00 ', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamentobc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($gdhaberturabc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamento1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da 1ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhabertura1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da 1º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamento2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhabertura2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhfechamento3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de fechamento na armaria da 3º BO', 'status' => 'error'));
            return false;
        } else if (strlen($gdhabertura3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite um GDH de abertura na armaria da 3ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacrebc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($cadeadobc) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da BC', 'status' => 'error'));
            return false;
        } else if (strlen($lacre1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da 1ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($cadeado1) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da 1º BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacre2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($cadeado2) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da 2º BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacre3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da armaria da 3º BO', 'status' => 'error'));
            return false;
        } else if (strlen($cadeado3) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o cadeado da armaria da 3ª BO', 'status' => 'error'));
            return false;
        } else if (strlen($lacresalacom) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o lacre da SALA COM BC', 'status' => 'error'));
            return false;
        } else if (strlen($sobras) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a sobra de alimentos', 'status' => 'error'));
            return false;
        } else if (strlen($residuos) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite o redisuo de alimentos', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatualagua) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual da água', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterioragua) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior da água', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatual03) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual luz 03', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterior03) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior luz 03', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatual24) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual luz 24', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterior24) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior luz 24', 'status' => 'error'));
            return false;
        } else if (strlen($leituraatual52) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura atual luz 52', 'status' => 'error'));
            return false;
        } else if (strlen($leituraanterior52) <= 0) {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite a leitura anterior luz 52', 'status' => 'error'));
            return false;
        } else if (strlen($consumoagua) <= 0 || $consumoagua == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da água novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        } else if (strlen($consumo03) <= 0 || $consumo03 == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da luz 03 novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        } else if (strlen($consumo24) <= 0 || $consumo24 == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da luz 24 novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        } else if (strlen($consumo52) <= 0 || $consumo52 == "NaN") {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma das leituras da luz 52 novamente, o campo consumo não pode ficar vazio e nem como NaN', 'status' => 'error'));
            return false;
        }
        try {
            $pdo->beginTransaction();
            $erros = 1;
            try {
                $pdo->prepare("START TRANSACTION");
                $query_salvarRondaOfDIa = $pdo->prepare("UPDATE `rondaOfdia`
                    SET `ronda1` = :ronda1, `ronda2` = :ronda2
                    WHERE `rondaOfdia`.`data` = :doDia");
                $query_salvarRondaOfDIa->bindParam(':ronda1', $ronda1);
                $query_salvarRondaOfDIa->bindParam(':ronda2', $ronda2);
                $query_salvarRondaOfDIa->bindParam(':doDia', $doDia);
                $query_salvarRondaOfDIa->execute();

                $query_salvaraoscmt = $pdo->prepare("UPDATE `aosubcmt`
                    SET `recebiDo` = :recebiDo, `pessoalDeSv` = :pessoalDeSv, `paradaDiaria` = :paradaDiaria,
                    `RevistadoRecolher` = :RevistadoRecolher, `ofdia` = :ofdia
                    WHERE `aosubcmt`.`doDia` = :doDia");
                $query_salvaraoscmt->bindParam(':recebiDo', $recebido);
                $query_salvaraoscmt->bindParam(':pessoalDeSv', $pessoaldesv);
                $query_salvaraoscmt->bindParam(':paradaDiaria', $paradadiaria);
                $query_salvaraoscmt->bindParam(':RevistadoRecolher', $revistadorecolher);
                $query_salvaraoscmt->bindParam(':ofdia', $ofdia);
                $query_salvaraoscmt->bindParam(':doDia', $doDia);
                $query_salvaraoscmt->execute();
                $erros += $query_salvaraoscmt->rowCount();

                $query_salvarreservabc = $pdo->prepare("UPDATE `reservabc` 
                    SET `gdhfechamento` = :gdhfechamento, `gdhabertura` = :gdhabertura, `lacre` = :lacre, `cadeados` = :cadeados 
                    WHERE `reservabc`.`data` = :doDia");
                $query_salvarreservabc->bindParam(':gdhfechamento', $gdhfechamentobc);
                $query_salvarreservabc->bindParam(':gdhabertura', $gdhaberturabc);
                $query_salvarreservabc->bindParam(':lacre', $lacrebc);
                $query_salvarreservabc->bindParam(':cadeados', $cadeadobc);
                $query_salvarreservabc->bindParam(':doDia', $doDia);
                $query_salvarreservabc->execute();
                $erros += $query_salvarreservabc->rowCount();

                $query_salvarreserva1 = $pdo->prepare("UPDATE `reservaprimeira` 
                    SET `gdhfechamento` = :gdhfechamento, `gdhabertura` = :gdhabertura, `lacre` = :lacre, `cadeados` = :cadeados 
                    WHERE `reservaprimeira`.`data` = :doDia");
                $query_salvarreserva1->bindParam(':gdhfechamento', $gdhfechamento1);
                $query_salvarreserva1->bindParam(':gdhabertura', $gdhabertura1);
                $query_salvarreserva1->bindParam(':lacre', $lacre1);
                $query_salvarreserva1->bindParam(':cadeados', $cadeado1);
                $query_salvarreserva1->bindParam(':doDia', $doDia);
                $query_salvarreserva1->execute();
                $erros += $query_salvarreserva1->rowCount();

                $query_salvarreserva2 = $pdo->prepare("UPDATE `reservasegunda` 
                    SET `gdhfechamento` = :gdhfechamento, `gdhabertura` = :gdhabertura, `lacre` = :lacre, `cadeados` = :cadeados 
                    WHERE `reservasegunda`.`data` = :doDia");
                $query_salvarreserva2->bindParam(':gdhfechamento', $gdhfechamento2);
                $query_salvarreserva2->bindParam(':gdhabertura', $gdhabertura2);
                $query_salvarreserva2->bindParam(':lacre', $lacre2);
                $query_salvarreserva2->bindParam(':cadeados', $cadeado2);
                $query_salvarreserva2->bindParam(':doDia', $doDia);
                $query_salvarreserva2->execute();
                $erros += $query_salvarreserva2->rowCount();

                $query_salvarreserva3 = $pdo->prepare("UPDATE `reservaterceira` 
                    SET `gdhfechamento` = :gdhfechamento, `gdhabertura` = :gdhabertura, `lacre` = :lacre, `cadeados` = :cadeados 
                    WHERE `reservaterceira`.`data` = :doDia");
                $query_salvarreserva3->bindParam(':gdhfechamento', $gdhfechamento3);
                $query_salvarreserva3->bindParam(':gdhabertura', $gdhabertura3);
                $query_salvarreserva3->bindParam(':lacre', $lacre3);
                $query_salvarreserva3->bindParam(':cadeados', $cadeado3);
                $query_salvarreserva3->bindParam(':doDia', $doDia);
                $query_salvarreserva3->execute();
                $erros += $query_salvarreserva3->rowCount();

                $query_salvarreservasala = $pdo->prepare("UPDATE `salacombc` 
                    SET `lacre` = :lacre 
                    WHERE `salacombc`.`data` = :doDia");
                $query_salvarreservasala->bindParam(':lacre', $lacresalacom);
                $query_salvarreservasala->bindParam(':doDia', $doDia);
                $query_salvarreservasala->execute();
                $erros += $query_salvarreservasala->rowCount();

                $query_salvarocorrenciascmt = $pdo->prepare("UPDATE `ocorrenciasaoscmt` 
                    SET `descricao` = :descricao 
                    WHERE `ocorrenciasaoscmt`.`data` = :doDia");
                $query_salvarocorrenciascmt->bindParam(':descricao', $ocorrenciasScmt);
                $query_salvarocorrenciascmt->bindParam(':doDia', $doDia);
                $query_salvarocorrenciascmt->execute();
                $erros += $query_salvarocorrenciascmt->rowCount();

                $query_salvarocorrenciafiscal = $pdo->prepare("UPDATE `ocorrenciasaofiscal` 
                    SET `descricao` = :descricao 
                    WHERE `ocorrenciasaofiscal`.`data` = :doDia");
                $query_salvarocorrenciafiscal->bindParam(':descricao', $ocorrenciasfiscaladm);
                $query_salvarocorrenciafiscal->bindParam(':doDia', $doDia);
                $query_salvarocorrenciafiscal->execute();
                $erros += $query_salvarocorrenciafiscal->rowCount();

                $query_cadeadosguarda = $pdo->prepare("UPDATE `cadeadosguarda` 
                    SET `descricao` = :descricao 
                    WHERE `cadeadosguarda`.`data` = :doDia");
                $query_cadeadosguarda->bindParam(':descricao', $cadeadosguarda);
                $query_cadeadosguarda->bindParam(':doDia', $doDia);
                $query_cadeadosguarda->execute();
                $erros += $query_cadeadosguarda->rowCount();

                $query_salvarosobraseresiduos = $pdo->prepare("UPDATE `sobraseresiduos` 
                    SET `sobra` = :sobra,`residuos` = :residuos  
                    WHERE `sobraseresiduos`.`data` = :doDia");
                $query_salvarosobraseresiduos->bindParam(':sobra', $sobras);
                $query_salvarosobraseresiduos->bindParam(':residuos', $residuos);
                $query_salvarosobraseresiduos->bindParam(':doDia', $doDia);
                $query_salvarosobraseresiduos->execute();
                $erros += $query_salvarosobraseresiduos->rowCount();

                $query_salvarinstalacoes = $pdo->prepare("UPDATE `instalacoes` 
                    SET `descricao` = :descricao 
                    WHERE `instalacoes`.`data` = :doDia");
                $query_salvarinstalacoes->bindParam(':descricao', $instalacoes);
                $query_salvarinstalacoes->bindParam(':doDia', $doDia);
                $query_salvarinstalacoes->execute();
                $erros += $query_salvarinstalacoes->rowCount();

                $query_salvarmunicao = $pdo->prepare("UPDATE `municao` 
                    SET `descricao` = :descricao 
                    WHERE `municao`.`data` = :doDia");
                $query_salvarmunicao->bindParam(':descricao', $municao);
                $query_salvarmunicao->bindParam(':doDia', $doDia);
                $query_salvarmunicao->execute();
                $erros += $query_salvarmunicao->rowCount();

                $query_salvaragua = $pdo->prepare("UPDATE `agua` 
                    SET `atual` = :atual,`anterior` = :anterior, `consumo` = :consumo 
                    WHERE `agua`.`data` = :doDia");
                $query_salvaragua->bindParam(':atual', $leituraatualagua);
                $query_salvaragua->bindParam(':anterior', $leituraanterioragua);
                $query_salvaragua->bindParam(':consumo', $consumoagua);
                $query_salvaragua->bindParam(':doDia', $doDia);
                $query_salvaragua->execute();
                $erros += $query_salvaragua->rowCount();

                $query_salvarluz03 = $pdo->prepare("UPDATE `luz03` 
                    SET `atual` = :atual,`anterior` = :anterior, `consumo` = :consumo 
                    WHERE `luz03`.`data` = :doDia");
                $query_salvarluz03->bindParam(':atual', $leituraatual03);
                $query_salvarluz03->bindParam(':anterior', $leituraanterior03);
                $query_salvarluz03->bindParam(':consumo', $consumo03);
                $query_salvarluz03->bindParam(':doDia', $doDia);
                $query_salvarluz03->execute();
                $erros += $query_salvarluz03->rowCount();

                $query_salvarluz24 = $pdo->prepare("UPDATE `luz24` 
                    SET `atual` = :atual,`anterior` = :anterior, `consumo` = :consumo  
                    WHERE `luz24`.`data` = :doDia");
                $query_salvarluz24->bindParam(':atual', $leituraatual24);
                $query_salvarluz24->bindParam(':anterior', $leituraanterior24);
                $query_salvarluz24->bindParam(':consumo', $consumo24);
                $query_salvarluz24->bindParam(':doDia', $doDia);
                $query_salvarluz24->execute();
                $erros += $query_salvarluz24->rowCount();

                $query_salvarluz52 = $pdo->prepare("UPDATE `luz52` 
                    SET `atual` = :atual,`anterior` = :anterior, `consumo` = :consumo  
                    WHERE `luz52`.`data` = :doDia");
                $query_salvarluz52->bindParam(':atual', $leituraatual52);
                $query_salvarluz52->bindParam(':anterior', $leituraanterior52);
                $query_salvarluz52->bindParam(':consumo', $consumo52);
                $query_salvarluz52->bindParam(':doDia', $doDia);
                $query_salvarluz52->execute();
                $erros += $query_salvarluz52->rowCount();
            } catch (PDOException $exception) {
                $pdo->rollBack();
                echo json_encode(array('resposta' => 'Oops', 'mensagem' => $exception->getMessage(), 'status' => 'error'));
                $erros = 99;
                return false;
            }

            if ($erros != 99) {
                $pdo->commit();
                echo json_encode(array('resposta' => 'Serviço alterado!', 'mensagem' => 'ok', 'status' => 'success', 'irpara' => 'painel.php?func=editarServico'));
                return false;
            } else {
                $pdo->rollBack();
                echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Ocorreu algum erro em alguma inserção. Verifique os dados e tente novamente!' . $erros, 'status' => 'error'));
                return false;
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Erro ao alterar o SV! z \n Tente novamente', 'status' => 'error'));
            return false;
        }
    }
} elseif ($acao == 'passar_servico') {
    if ($nivel <= 1) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
        return false;
    }
    $doDia1    = filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING);
    $assinaturaofdia = filter_input(INPUT_POST, 'assinatura', FILTER_SANITIZE_STRING);
    $passeiAo    = filter_input(INPUT_POST, 'passeiAo', FILTER_SANITIZE_STRING);
    if (empty($assinaturaofdia)) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Não foi localizada uma assinatura para o ADJ, tente recarregar a página, se o erro persistir, contate o administrador do sistema.', 'status' => 'error'));
        return false;
    } else if (empty($passeiAo) || $passeiAo == "Selecione") {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione o Oficial de dia para qual irá passar o serviço.', 'status' => 'error'));
        return false;
    } else if ($assinaturaofdia == $passeiAo) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione um oficial de dia diferente.', 'status' => 'error'));
        return false;
    } else if (empty($doDia1) || $doDia1 == "Selecione") {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Data do serviço inválida, você precisa selecionar um serviço!', 'status' => 'error'));
        return false;
    } else {
        $pdo->beginTransaction();
        $pdo->prepare("START TRANSACTION");
        $prepare_passasv = $pdo->prepare("UPDATE `aosubcmt` SET `passeiAo` = :passeiAo, `assinaturaOfDia` =  :assinatura WHERE `aosubcmt`.`doDia` = :doDia and passeiAo = ''");
        $prepare_passasv->bindParam(':passeiAo', $passeiAo);
        $prepare_passasv->bindParam(':assinatura', $assinaturaofdia);
        $prepare_passasv->bindParam(':doDia', $doDia1);
        $prepare_passasv->execute();

        if ($prepare_passasv->rowCount() == 1) {
            $pdo->commit();
            echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'doDia' => $doDia1, 'status' => 'success'));
            return false;
        } else {
            $pdo->rollBack();
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Este serviço já foi passado!\nCaso não tenha sido, entre em contato com o administrador, ou verifique na aba Voltar Serviço", 'status' => 'warning'));
            return false;
        }
    }
} elseif ($acao == 'voltar_servico') {
    if ($nivel <= 1) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
        return false;
    }
    $doDia1 = filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING);
    if (empty($doDia1) || $doDia1 == "Selecione") {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Data do serviço inválida, você precisa selecionar um serviço!', 'status' => 'error'));
        return false;
    }

    $pdo->beginTransaction();
    $pdo->prepare("START TRANSACTION");
    $query_passasv = $pdo->prepare("UPDATE `aosubcmt` SET `passeiAo` = '', `assinaturaOfDia` = '' WHERE `aosubcmt`.`doDia` = :doDia");
    $query_passasv->bindParam(':doDia', $doDia1);
    $query_passasv->execute();
    if ($query_passasv->rowCount() == 1) {
        $pdo->commit();
        echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'doDia' => $doDia1, 'status' => 'success'));
        return false;
    } else {
        $pdo->rollBack();
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Ocorreu um problema ao voltar o serviço, tente novamente.", 'status' => 'warning'));
        return false;
    }
} elseif ($acao == 'adicionar_adjunto') {
    $doDia1 = filter_input(INPUT_POST, 'doDia', FILTER_SANITIZE_STRING);
    $adj    = filter_input(INPUT_POST, 'adj', FILTER_SANITIZE_STRING);

    if ($nivel <= 5) {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
        return false;
    }

    if (empty($doDia1) || $doDia1 == "Selecione") {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Data do serviço inválida, você precisa selecionar um serviço!', 'status' => 'error'));
        return false;
    }
    if (empty($adj) || $adj == "Selecione") {
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Selecione um adjunto', 'status' => 'error'));
        return false;
    }
    $pdo->beginTransaction();
    $pdo->prepare("START TRANSACTION");
    $adicionar_adjunto = $pdo->prepare("UPDATE `aosubcmt` SET `assinaturaAdj` = :adj WHERE `aosubcmt`.`doDia` = :doDia and assinaturaAdj = ''");
    $adicionar_adjunto->bindParam(':adj', $adj);
    $adicionar_adjunto->bindParam(':doDia', $doDia1);
    $adicionar_adjunto->execute();

    if ($adicionar_adjunto->rowCount() == 1) {
        $pdo->commit();
        echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'doDia' => $doDia1, 'status' => 'success'));
        return false;
    } else {
        $pdo->rollBack();
        echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Não foi possível adicionar o adjunto ao serviço selecionado, tente novamente.", 'status' => 'warning'));
        return false;
    }
}
