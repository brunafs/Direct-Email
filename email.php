<?php 
// Arquivo de configuração para envio do e-mail

require "vendor/phpmailer/class.phpmailer.php"; 
require "vendor/phpmailer/class.smtp.php"; 

include ('conexao.php'); 

header('Content-Type: text/html; charset=UTF-8');

function send_email($enviar_email, $enviar_nome, $enviar_arquivo){
   // DADOS SERVIDOR E-MAIL
   $mail = new PHPMailer();
   $mail->isSMTP();
   $mail->Host="smtp.gmail.com";
   $mail->Port=587;
   $mail->SMTPAuth = true;
   $mail->Username='email@gmail.com';
   $mail->Password='senha';

   // CONFIGURAR MENSAGEM
   $mail->CharSet='UTF-8';
   $mail->setFrom('email@gmail.com',"Seu Nome");
   $mail->addAddress($enviar_email, $enviar_nome);
   $mail-> Subject = "Boletim de Jurisprudência";
   $mail->addAttachment($enviar_arquivo);
   $mail->AddEmbeddedImage('vendor/img/tcdfemail.png', 'logo_ref');
   $mail-> msgHTML("
      <p><b>Olá, {$enviar_nome}!</b></p>
      <p>Segue em anexo seu Boletim solicitado.</p>
      </br></br>
      <p>Atenciosamente,</p>
      <p>Equipe da Biblioteca TCDF</p>
      <img src='cid:logo_ref' style='max-height: 180px; max-width:180px'/>
   ");

   // ENVIO
   if($mail->send()){
      // echo"E-mail enviado";
   } else {
      die ("Erro no envio do e-mail: {$mail -> ErrorInfo}");
   }
}

function arquivo(){
   # CONSULTAS SQL
   $sqlArquivo = "SELECT * FROM arquivo";
   $sqlPerfil = "SELECT * FROM usuarioperfil";
   $sqlStatus = "UPDATE TABLE arquivo SET status=1 WHERE ";
   include ('conexao.php'); 
   // PEGA TODOS OS ARQUIVOS
   if ($result = $mysqli -> query($sqlArquivo)) {
      while($row = mysqli_fetch_assoc($result)){
         $status = $row['status'];
         $perfilArquivo = $row['perfil'];
         $caminho = $row['caminho'];
         // PEGA ARQUIVOS COM STATUS DE NAO ENVIADO AINDA
         if ($status == 0){
            // PEGA PERFIL/USUARIO
            if ($resultado = $mysqli -> query($sqlPerfil)) {
               while($linha = mysqli_fetch_assoc($resultado)){
                  $perfilUsuario = $linha['idPerfil'];
                  $usuario = $linha['idUsuario'];
                  // SE O PERFIL DO USUARIO = PERFIL ARQUIVO --> ENVIA EMAIL
                  if($perfilUsuario == $perfilArquivo){
                     if ($results = $mysqli -> query("SELECT * FROM usuario WHERE id=$usuario")) {
                        while($rows = mysqli_fetch_assoc($results)){
                           $email = $rows['email'];
                           $nome = $rows['nome'];
                           send_email($email, $nome, $caminho);
                        }
                     }
                  }
               }
            }
            // ALTERAR STATUS DO ARQUIVO
            $idArquivo = $row['id'];
            $atualizar = $mysqli -> query("UPDATE arquivo SET status=1 WHERE id = $idArquivo");
            ($atualizar) ? print '' : die('Falha ao alterar dados'. $mysqli->connect_error);
         }
      }
      $result -> free_result();
   }
   $mysqli -> close();
}