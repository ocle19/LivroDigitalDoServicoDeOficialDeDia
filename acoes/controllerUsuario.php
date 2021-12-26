<?php
session_start();
include('./../connection.php');
$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
$nivel_logado = isset($_SESSION['nivel']) ? $_SESSION['nivel'] : 0;

if ($acao == 'validar') {
   $usuario =  filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
   $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

   if ($usuario == "" or $senha == "") {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Insira um nome de usuário e senha', 'status' => 'error'));
      return false;
   }
   $validar_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE user_nome= :user AND user_senha= :pass AND status='ATIVADO'");
   $validar_usuario->bindParam(':user', $usuario);
   $validar_usuario->bindParam(':pass', $senha);
   $validar_usuario->execute();
   $existe = $validar_usuario->rowCount();
   if ($existe > 0) {
      $dados_do_usuario = $validar_usuario->fetch(PDO::FETCH_ASSOC);

      if ($dados_do_usuario["user_nivel"] >= 1) {
         $_SESSION["user_id"] = $dados_do_usuario['user_id'];
         $_SESSION["Usuario"]     = $usuario;
         $_SESSION['start_login'] = time();
         $_SESSION['logout_time'] = $_SESSION['start_login'] + 500;
         echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => 'ok', 'status' => 'success', 'irpara' => 'painel.php'));
         return false;
      } else {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Você não tem permissão para acessar este sistema', 'status' => 'error'));
      }
   } else {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Credenciais incorretas', 'status' => 'error'));
      return false;
   }
}

if ($acao == 'cadastrar_usuario') {
   if ($nivel_logado <= 5) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
      return false;
   }
   $nome         = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
   $nomecompleto = filter_input(INPUT_POST, 'nomecompleto', FILTER_SANITIZE_STRING);
   $grad         = filter_input(INPUT_POST, 'grad', FILTER_SANITIZE_STRING);
   $nivel        = filter_input(INPUT_POST, 'nivel', FILTER_SANITIZE_NUMBER_INT);
   $senha        = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
   //$Fotox   = $_FILES["assinatura"];
   $status = "ATIVADO";
   if (empty($nome)) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o nome de guerra", 'status' => 'error'));
      return false;
   } else if (empty($nomecompleto)) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o nome completo", 'status' => 'error'));
      return false;
   } else if (empty($grad) || $grad == 'Selecione') {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione uma graduação", 'status' => 'error'));
      return false;
   } else if (empty($nivel) || $nivel < 1 || $nivel > 6) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione um nível válido!", 'status' => 'error'));
      return false;
   } else if (empty($senha)) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite uma senha", 'status' => 'error'));
      return false;
   } else {

      $checar_usuario_existe = $pdo->prepare("SELECT * FROM usuarios WHERE user_nomecompleto= :nomeCompleto or user_nome= :nome");
      $checar_usuario_existe->bindParam(':nomeCompleto', $nomecompleto);
      $checar_usuario_existe->bindParam(':nome', $nome);
      $checar_usuario_existe->execute();
      $row    = $checar_usuario_existe->rowCount();
      if ($row > 0) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Usuário já cadastrado!", 'status' => 'error'));
         return false;
      } else {

         //$file = $Fotox;
         //$filename = $file['name'];
         //$NomeDaFotoInput = $filename;
         //$nome_info = pathinfo ($NomeDaFotoInput);
         $nome_foto = $grad . ' ' . $nome; //. $nome_info['extension'];
         //$path     = $file['tmp_name'];
         //$new_path = "assinaturas/".$nome_foto;
         $status = "ATIVADO";
         //if(!move_uploaded_file($path, $new_path))
         //{
         //    echo "<script> alert('Erro na ASSINATURA!!');' </script>";
         //exit;
         //}
         $pdo->beginTransaction();
         $pdo->prepare("START TRANSACTION");
         $cadastrar_usuario = $pdo->prepare("INSERT INTO usuarios (user_nome, user_nomecompleto, grad, user_senha, user_nivel, assinatura, status) 
                VALUES (:user_nome, :user_nomecompleto, :grad, :user_senha, :user_nivel, :assinatura, :status_user)");

         $cadastrar_usuario->bindParam(':user_nome', $nome);
         $cadastrar_usuario->bindParam(':user_nomecompleto', $nomecompleto);
         $cadastrar_usuario->bindParam(':grad', $grad);
         $cadastrar_usuario->bindParam(':user_senha', $senha);
         $cadastrar_usuario->bindParam(':user_nivel', $nivel);
         $cadastrar_usuario->bindParam(':assinatura', $nome_foto);
         $cadastrar_usuario->bindParam(':status_user', $status);
         $cadastrar_usuario->execute();

         if ($cadastrar_usuario) {
            $pdo->commit();
            echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'status' => 'success'));
            return false;
         } else {
            $pdo->rollBack();
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Ocorreu um erro! Tente novamente mais tarde", 'status' => 'error'));
            return false;
         }
      }
   }
}

if ($acao == 'editar_usuario') {
   if ($nivel_logado <= 5) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Você não tem permissão!", 'status' => 'error'));
      return false;
   }
   $usuario             = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_NUMBER_INT);
   $nomeGuerra          = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
   $nomeCompletoeditado = filter_input(INPUT_POST, 'nomecompleto', FILTER_SANITIZE_STRING);
   $Nivel               = filter_input(INPUT_POST, 'nivel', FILTER_SANITIZE_NUMBER_INT);
   $graduacao           = filter_input(INPUT_POST, 'grad', FILTER_SANITIZE_STRING);
   $senha               = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
   $status              = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

   if (empty($nomeGuerra)) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o nome de guerra", 'status' => 'error'));
      return false;
   } else if (empty($nomeCompletoeditado)) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite o nome completo", 'status' => 'error'));
      return false;
   } else if (empty($graduacao) || $graduacao == 'Selecione') {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione uma graduação", 'status' => 'error'));
      return false;
   } else if (empty($Nivel) || $Nivel < 1 || $Nivel > 6) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione um nível válido!", 'status' => 'error'));
      return false;
   } else if (empty($status) || ($status != "DESATIVADO" && $status != "ATIVADO")) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Selecione um status válido!", 'status' => 'error'));
      return false;
   } else if (empty($senha)) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Digite uma senha", 'status' => 'error'));
      return false;
   } else {
      $atualizar_dados = $pdo->prepare("UPDATE `usuarios` SET `user_nivel` = :nivel,`user_nome` = :nome,`user_nomecompleto` = :nomeCompleto,`grad` = :grad,`status` = :statusUser,`user_senha` = :senha WHERE `usuarios`.`user_id` = :usuario");
      $atualizar_dados->bindParam(':nivel', $Nivel);
      $atualizar_dados->bindParam(':nome', $nomeGuerra);
      $atualizar_dados->bindParam(':nomeCompleto', $nomeCompletoeditado);
      $atualizar_dados->bindParam(':grad', $graduacao);
      $atualizar_dados->bindParam(':statusUser', $status);
      $atualizar_dados->bindParam(':senha', $senha);
      $atualizar_dados->bindParam(':usuario', $usuario);
      $atualizar_dados->execute();

      if ($atualizar_dados) {
         echo json_encode(array('resposta' => 'Sucesso', 'mensagem' => "ok", 'status' => 'success'));
         return false;
      } else {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => "Não foi possível alterar os dados, tente novamente!", 'status' => 'error'));
         return false;
      }
   }
}

if ($acao == 'trocar_senha') {
   $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
   $nova  = filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING);
   $nova_r = filter_input(INPUT_POST, 'nova_senha_r', FILTER_SANITIZE_STRING);
   $usuario_logado = filter_var($_SESSION["user_id"], FILTER_SANITIZE_NUMBER_INT);

   $consultaNomeGuerra = $pdo->prepare("SELECT * FROM usuarios WHERE user_nome = :nomeGuerra AND user_id = :id AND STATUS ='ATIVADO'");
   $consultaNomeGuerra->bindParam(':id', $usuario_logado);
   $consultaNomeGuerra->bindParam(':nomeGuerra', $nova);
   $consultaNomeGuerra->execute();

   if ($consultaNomeGuerra->rowCount() > 0) {
      echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Você não pode deixar a senha igual o seu nome de guerra!.', 'status' => 'warning'));
      return false;
   } else {
      if ($nova != $nova_r) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'A nova senha não confere com a repetição.', 'status' => 'error'));
         return false;
      }
      if (strlen($nova) < 5) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Digite uma senha com no mínimo 5 digitos.', 'status' => 'error'));
         return false;
      }
      $consultaSenhaAtual = $pdo->prepare("SELECT * FROM usuarios WHERE user_senha = :senha AND user_id = :id AND STATUS ='ATIVADO'");
      $consultaSenhaAtual->bindParam(':id', $usuario_logado);
      $consultaSenhaAtual->bindParam(':senha', $senha);
      $consultaSenhaAtual->execute();

      if ($consultaSenhaAtual->rowCount() <= 0) {
         echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'A senha atual está incorreta.', 'status' => 'warning'));
         return false;
      } else {
         $atualizaSenha = $pdo->prepare("UPDATE usuarios SET user_senha = :nova WHERE user_id = :id");
         $atualizaSenha->bindParam(':id', $usuario_logado);
         $atualizaSenha->bindParam(':nova', $nova);

         if ($atualizaSenha->execute()) {
            $_SESSION['senha'] = $nova;
            echo json_encode(array('resposta' => 'Sucesso!', 'mensagem' => 'Senha alterada!', 'status' => 'success'));
            return false;
         } else {
            echo json_encode(array('resposta' => 'Oops', 'mensagem' => 'Erro ao alterar a senha!', 'status' => 'error'));
            return false;
         }
      }
   }
}
