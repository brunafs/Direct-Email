<?php

include ('conexao.php'); 

// CONSULTA PARA CHECKBOX DO FORMULARIO DE INCLUSAO DE ARQUIVO
$sqlCheckBox = "SELECT * FROM perfil";

if(!empty($_POST['email']) && !empty($_POST['check']) && !empty($_POST['nome']) ){ 

   $emailPostado = $_POST['email'];
   $nome = $_POST['nome'];
   $check = $_POST['check'];

   #Consultas Banco de dados 
   # verfica email existente
   $sqlEmail = "SELECT * FROM usuario WHERE email = '{$emailPostado}'";
   $result = $mysqli -> query($sqlEmail);
   # insere usuario 
   $sqlCadastro = "INSERT INTO usuario(nome,email) VALUES('{$nome}','{$emailPostado}')";

   #Variavel de resposta AJAX
   $response = array();

   #Se o retorno for maior do que zero, diz que já existe um email no banco.
   if ($result->num_rows > 0) {
      $response['status'] = 'error';
      $response['msg'] = 'Email já existente no banco.';
   } else {
      //CADASTRA EMAIL E NOME
      if ($resultado = $mysqli -> query($sqlCadastro)) {
         //PEGA ID DO CADASTRO ACIMA
         $sqlAux = "SELECT id FROM usuario WHERE email = '{$emailPostado}'";
         if ($aux = $mysqli -> query($sqlAux)) {
            $row= mysqli_fetch_array($aux);
            $user = $row['id'];
            //LOOP NO CHECKBOX
            foreach($check as $value){
               //CADASTRA PEFIL/USUARIO
               $sqlCadPerfil = "INSERT INTO usuarioperfil(idUsuario,idPerfil) VALUES('{$user}', '{$value}')";
               if($results = $mysqli -> query($sqlCadPerfil)){
                  $response['status'] = 'sucess';
                  $response['msg'] = 'Cadastro realizado com sucesso!';
               } else {
                  $response['status'] = 'error';
                  $response['msg'] = 'Erro no cadastro perfil/usuario.';
               }
            } 
         } else {
            $response['status'] = 'error';
            $response['msg'] = 'Erro ao pegar id de cadastro.';
         }
      } else {
         $response['status'] = 'error';
         $response['msg'] = 'Erro ao cadastrar e-mail.';
      }
   }
   echo json_encode($response);
}

?>