<?php

include ('conexao.php'); 

// CONSULTA PARA CHECKBOX DO FORMULARIO DE INCLUSAO DE ARQUIVO
$sqlCheckBox = "SELECT * FROM perfil";

# Path arquivo no servidor
$path = 'C:/xampp/mysql/data/boletim/arquivos/';
#Variavel de resposta AJAX
$response = array();

if(!empty($_POST['nome']) && $_FILES['file']['tmp_name'] && !empty($_POST['radio'])) {

   $fileName = $_FILES['file']['name'];
   $tmp = $_FILES['file']['tmp_name'];
   $targetFilePath = $path . $fileName; 

   // $tmpExcel = $_FILES['fileExcel']['tmp_name'];
   // $arquivoXML = new DomDocument();
   // $arquivoXML->load($tmpExcel);
   // $linhas = $arquivoXML->getElementsByTagName('Row');

   // $primeiraLinha = true;
   // foreach($linhas as $linha){
   //    if($primeiraLinha == false){
   //       $nomeXML = $linha->getElementsByTagName('Data')->item(5)->nodeValue;
   //       echo "Nome: $nomeXML <br>";
   //       $emailXML = $linha->getElementsByTagName('Data')->item(6)->nodeValue;
   //       echo "Email: $emailXML <br>";
   //       $checkXML = $linha->getElementsByTagName('Data')->item(7)->nodeValue;
   //       echo "CheckBox: $checkXML <br>";
   //       $arrayCheck = explode(';', $checkXML);

   //       # verfica email existente
   //       $sqlEmail = "SELECT * FROM usuario WHERE email = '{$emailXML}'";
   //       $result = $mysqli -> query($sqlEmail);
   //       # insere usuario 
   //       $sqlCadastro = "INSERT INTO usuario(nome,email) VALUES('{$nomeXML}','{$emailXML}')";
   //       # insere usuario/assunto de interesse

   //       #Se o retorno for maior do que zero, diz que já existe um email no banco.
   //       if ($result->num_rows > 0) {
   //          $response['status'] = 'error';
   //          $response['msg'] = "Email ({$emailXML}) já existente no banco.";
   //       } else {
   //          //CADASTRA USUÁRIO -> EMAIL E NOME
   //          if ($resultado = $mysqli -> query($sqlCadastro)) {
   //             //PEGA ID DO CADASTRO ACIMA
   //             $sqlAux = "SELECT id FROM usuario WHERE email = '{$emailXML}'";
   //             if ($aux = $mysqli -> query($sqlAux)) {
   //                $row= mysqli_fetch_array($aux);
   //                $user = $row['id'];
   //                //LOOP NO CHECKBOX/ARRAY
   //                foreach($arrayCheck as $valores){
   //                   // PEGA ID DO ASSUNTO/PERFIL
   //                   $sqlAuxs = "SELECT id FROM perfil WHERE assunto = '{$valores}'";
   //                   if ($auxs = $mysqli -> query($sqlAuxs)) {
   //                      $rows = mysqli_fetch_array($auxs);
   //                      $idPerfil = $rows['id'];
   //                      // CADASTRA PERFIL/ASSUNTO
   //                      $sqlCadPerfil = "INSERT INTO usuarioperfil(idUsuario,idPerfil) VALUES('{$user}', '{$idPerfil}')";
   //                      if($results = $mysqli -> query($sqlCadPerfil)){
   //                         $response['status'] = 'sucess';
   //                         $response['msg'] = 'Cadastro realizado com sucesso!';
   //                      } else {
   //                         $response['status'] = 'error';
   //                         $response['msg'] = 'Erro no cadastro perfil/usuario.';
   //                      }
   //                   }

   //                }
   //                exit();
   //             }
   //          } else {
   //             $response['status'] = 'error';
   //             $response['msg'] = 'Erro ao cadastrar perfil no banco.'; 
   //          }
   //       }
   //    }
   //    $primeiraLinha = false;
   // }

   //MOVE ARQUIVO PARA SERVIDOR
   if(move_uploaded_file( $tmp, $targetFilePath)) {
      $nome = $_POST['nome'];
      $descricao = $_POST['descricao'];
      $radio = $_POST['radio'];

      #Consultas Banco de dados 
      $sqlInsert = "INSERT INTO arquivo (nome_doc, descricao, caminho, perfil) VALUES('{$nome}','{$descricao}', '{$targetFilePath}', '{$radio}')";
      $sqlConsult = "SELECT nome_doc FROM arquivo WHERE nome_doc='{$nome}'";

      //CONSULTA NOME DOS ARQUIVOS EXISTENTES, SE JA HOUVER DA ERRO
      if ($resultado = $mysqli -> query($sqlConsult)) {
         if(mysqli_fetch_assoc($resultado) >= 1){
            $response['status'] = 'error';
            $response['msg'] = 'Um arquivo com esse nome já está cadastrado.'; 
         } else {
            // CASO NAO TENHA NENHUM ARQUIVO COM ESSE NOME, INSERE NO BANCO
            if($result = $mysqli -> query($sqlInsert)){
               $response['status'] = 'sucess';
               $response['msg'] = 'Arquivo salvo! Enviando...';
               require './email.php';
               arquivo();  //função para enviar e-mail
               $response['status'] = 'sucess';
               $response['msg'] = 'Arquivo salvo e encaminhado com sucesso!';
            } else {
               $response['status'] = 'error';
               $response['msg'] = 'Erro ao inserir dados no banco.'; 
            }
         }
      }

   } else {
      $response['status'] = 'error';
      $response['msg'] = 'Erro ao transferir arquivo para servidor.'; 
   }

   echo json_encode($response);
} else {
   $response['status'] = 'error';
   $response['msg'] = 'Preencha os campos corretamente.'; 
}

?>