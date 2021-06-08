<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <title>Inclusão de Perfis</title>
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
               <form id="formexcel" enctype="multipart/form-data">
                  <div class="form-group">
                     <label>Selecione o arquivo Excel, em XML, para atualizar o cadastro dos perfis:</label>
                     <br>
                     <input id="fileExcel" name='fileExcel' type="file">
                     <br>
                     <span id='errorExcel' class='error' ></span>
                  </div>
                  <div>
                     <input class="btn btn-primary btn-lg" type="submit">
                  </div>
               </form>
               </form>
            </div>
         </div>
      </div>
   </section>

</body>

<script language="javascript">
      $(document).ready(function(){
         // SUBMIT AJAX
         $('#formexcel').submit(function(e){     
            e.preventDefault();
            $.ajax({
               url: '../verificaExcel.php',
               type: 'POST',
               data: new FormData(this),
               cache: false,
               contentType: false,
               processData: false,
               dataType: "json",
               success: function(data) {
                  if(data.status == 'sucess'){
                     $('.error').html(data.msg).addClass('sucess').fadeIn(300);
                  } else {
                     $('.error').html(data.msg).addClass('error').fadeIn(300);
                  }
               },
            });
         });
      });
</script>   
</html>