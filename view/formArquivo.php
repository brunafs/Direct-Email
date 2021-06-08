<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <title>Inclusão de Boletim</title>
</head>
<body id="page-top">
   <?php include ('headerNav.html'); ?>
   <section>
      <div class="container lead text-lead" align="justify">
         <div class="row">
            <div class="col-lg-11 mx-auto">
               <h2>Inclusão de Boletim</h2>
               <br>
               <p style="font-weight: 400;">Para incluir os Boletins de Jurisprudência preencha o formulário a seguir.</p>
               <form id="formarq" enctype="multipart/form-data">
<!-- 
                  <div class="form-group">
                     <label>Selecione o arquivo Excel, em XML, para atualizar o cadastro dos perfis:</label>
                     <br>
                     <input id="fileExcel" name='fileExcel' type="file">
                     <br>
                     <span id='errorExcel' class='error' ></span>
                  </div> -->

                  <div class="form-group">
                     <label>Selecione o assunto do boletim:</label>
                     <span id="span-erro"></span>
                     <br>
                     <?php 
                        require '../verificaArquivo.php';
                        if ($result = $mysqli -> query($sqlCheckBox)) {
                           while($row = mysqli_fetch_assoc($result)){
                              $perfil = $row['assunto'];
                              $idPerfil = $row['id'];
                              echo "<input name='radio' id='radio'  type='radio' value='$idPerfil'> $perfil <br>";
                           }
                        }
                     ?>
                  </div>
                  <div class="form-group">
                     <label>Selecione o arquivo desejado:</label>
                     <br>
                     <input id="file" name='file' type="file">
                     <br>
                     <span id='extError' class='error' ></span>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-1 col-form-label">Nome:</label>
                     <div class="col-sm-11">
                        <input obrigatorio="sim" type="text" class="form-control field" id="nome" name="nome" placeholder="Nome do arquivo">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-1 col-form-label">Descrição:</label>
                     <div class="col-sm-11">
                        <textarea type="textarea" class="form-control" id="descricao" name="descricao" placeholder="Descrição do arquivo"></textarea>
                     </div>
                  </div>
                  <div>
                     <ul id="divError" style="display:none"></ul>
                     <div id="load" class="field-sucess"></div>
                     <div class="mensagem"></div>
                  </div>
                  <br>
                  <input class="btn btn-primary btn-lg" type="submit">
               </form>
            </div>
         </div>
      </div>
   </section>

   <script language="javascript">
      $(document).ready(function(){
         var radio = $("input[name='radio']:checked").val();
         // SUBMIT AJAX
         $('#formarq').submit(function(e){     
            e.preventDefault();
            $('.mensagem').html('').removeClass('sucess').removeClass('error');

            $.ajax({
               url: '../verificaArquivo.php',
               type: 'POST',
               data: new FormData(this),
               cache: false,
               contentType: false,
               processData: false,
               dataType: "json",
               success: function(data) {
                  if(data.status == 'sucess'){
                     $('#load').html('');
                     $('.mensagem').html(data.msg).addClass('sucess').fadeIn(300);
                  } else {
                     $('#load').html('');
                     $('.mensagem').html(data.msg).addClass('error').fadeIn(300);
                  }
               },
            });
         });
      });
   </script>   
</body>
</html>