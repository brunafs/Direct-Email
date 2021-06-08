<?php

include ('conexao.php'); 

// CONSULTA PARA CHECKBOX DO FORMULARIO DE INCLUSAO DE ARQUIVO
$sqlCheckBox = "SELECT * FROM perfil";

# Path arquivo no servidor
$path = 'C:/xampp/mysql/data/boletim/arquivos/';
#Variavel de resposta AJAX
$response = array();

if($_FILES['fileExcel']['tmp_name'] ) {

   $tmpExcel = $_FILES['fileExcel']['tmp_name'];
   $arquivoXML = new DomDocument();
   $arquivoXML->load($tmpExcel);
   $linhas = $arquivoXML->getElementsByTagName('Row');

   $primeiraLinha = true;
   foreach($linhas as $linha){
      if($primeiraLinha == false){
         $nomeXML = $linha->getElementsByTagName('Data')->item(5)->nodeValue;
         echo "Nome: $nomeXML <br>";
         $emailXML = $linha->getElementsByTagName('Data')->item(6)->nodeValue;
         echo "Email: $emailXML <br>";
         $checkXML = $linha->getElementsByTagName('Data')->item(7)->nodeValue;
         echo "CheckBox: $checkXML <br>";
         $arrayCheck = explode(';', $checkXML);

         # verfica email existente
         $sqlEmail = "SELECT * FROM usuario WHERE email = '{$emailXML}'";
         $result = $mysqli -> query($sqlEmail);
         # insere usuario 
         $sqlCadastro = "INSERT INTO usuario(nome,email) VALUES('{$nomeXML}','{$emailXML}')";

         #Se o retorno for maior do que zero,email já consta no banco -> Atualizar tabela ASSUNTO/PERFIL
         if ($result->num_rows > 0) {
            $nrow= mysqli_fetch_array($result);
            $sqlUpdate = "UPDATE  ";
            var_dump($nrow);
            // exit();
            $response['msg'] = "Email ({$emailXML}) já existente no banco. Perfil atualizado.";
         } else {
            //CADASTRA USUÁRIO -> EMAIL E NOME
            if ($resultado = $mysqli -> query($sqlCadastro)) {
               //PEGA ID DO CADASTRO ACIMA
               $sqlAux = "SELECT id FROM usuario WHERE email = '{$emailXML}'";
               if ($aux = $mysqli -> query($sqlAux)) {
                  $row= mysqli_fetch_array($aux);
                  $user = $row['id'];
                  //LOOP NO CHECKBOX/ARRAY
                  foreach($arrayCheck as $valores){
                     // PEGA ID DO ASSUNTO/PERFIL
                     $sqlAuxs = "SELECT id FROM perfil WHERE assunto = '{$valores}'";
                     if ($auxs = $mysqli -> query($sqlAuxs)) {
                        $rows = mysqli_fetch_array($auxs);
                        $idPerfil = $rows['id'];
                        // CADASTRA PERFIL/ASSUNTO
                        $sqlCadPerfil = "INSERT INTO usuarioperfil(idUsuario,idPerfil) VALUES('{$user}', '{$idPerfil}')";
                        if($results = $mysqli -> query($sqlCadPerfil)){
                           $response['status'] = 'sucess';
                           $response['msg'] = 'Cadastro realizado com sucesso!';
                        } else {
                           $response['status'] = 'error';
                           $response['msg'] = 'Erro no cadastro perfil/usuario.';
                        }
                     } 
                  }
               }
            } else {
               $response['status'] = 'error';
               $response['msg'] = 'Erro ao cadastrar perfil no banco.'; 
            }
         }
      }
      $primeiraLinha = false;
   }
   echo json_encode($response);
} else {
   $response['status'] = 'error';
   $response['msg'] = 'Adicione um arquivo .xml.'; 

   echo json_encode($response);
} 