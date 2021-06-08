<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <title>Solicitação de Boletim</title>
</head>
<body id="page-top">
   <?php include ('headerNav.html'); ?>
   <section>
      <div class="container lead text-lead" align="justify">
         <div class="row">
            <div class="col-lg-11 mx-auto">
               <h2>Solicitação de Boletim</h2>
               <br>
               <p>Os Boletins de Jurisprudência do TCDF são publicações periódicas elaboradas pela Supervisão de Sistemas de Informação, Legislação e Jurisprudência – SSI com a finalidade de apresentar resumos das teses constantes em decisões desta Corte que se enquadrem em critérios de relevância, reiteração, ineditismo ou controvérsia. Ressalta-se, todavia, que as informações apresentadas não constituem resumo oficial da decisão proferida pelo Tribunal nem representam, necessariamente, o posicionamento prevalecente na Corte sobre a matéria. </p>
               <p style="font-weight: 400;">Para receber os Boletins de Jurisprudência preencha o formulário a seguir.</p>
               <form id="formcad">
                  <div class="form-group">
                     <label>Selecione o(s) assunto(s) de interesse:</label>
                     <span id="span-error"></span>
                     <br>
                     <?php 
                        require '../verificaUser.php';
                        if ($result = $mysqli -> query($sqlCheckBox)) {
                           while($row = mysqli_fetch_assoc($result)){
                              $perfil = $row['assunto'];
                              $idPerfil = $row['id'];
                              echo "<input grupock='propriedade' id='check' name='check' qde_min='1' type='checkbox' value='{$idPerfil}'> $perfil <br>";
                           }
                        }
                     ?>   
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-1 col-form-label">Nome:</label>
                     <div class="col-sm-11">
                        <input obrigatorio="sim" type="text" class="form-control field" id="nome" name="nome" placeholder="Seu nome">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-sm-1 col-form-label">Email:</label>
                     <div class="col-sm-11">
                        <input obrigatorio="sim" type="email" class="form-control field" id="email" name="email" placeholder="Seu email">
                     </div>
                  </div>
                  <div id="divError" style="display:none"></div>
                  <div>
                     <span id="msgCadastro"></span>
                  </div>
                  <br>
                  <input class="btn btn-primary btn-lg" type="submit">
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>
   <script language="javascript">
      $(document).ready(function(){
            $('#formcad').submit(function(e){
               e.preventDefault();

               $('#msgCadastro').removeClass('sucess');
               $('#msgCadastro').removeClass('error');

               var nome = $('#nome').val();
               var email = $('#email').val();
               var myChecks = new Array();
               $("input:checkbox[name=check]:checked").each(function(){
                  myChecks.push($(this).val());
               });

               $.ajax({
                     url: '../verificaUser.php',
                     data: {
                        email:email,
                        nome:nome,
                        check: myChecks
                     },
                     dataType: "json",
                     type: "POST",
                     success: function(data){
                        if(data.status == 'sucess'){
                           $('#msgCadastro').html(data.msg).addClass('sucess').fadeIn(300);
                        } else {
                           $('#msgCadastro').html(data.msg).addClass('error').fadeIn(300);
                        }
                     }
               });
            });
      });
   </script>
</body>
</html>