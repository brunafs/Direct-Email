// VALIDAÇÃO DE CAMPOS
$(document).ready(function(){
   $("#formcad").submit(validar);  
   $("#formarq").submit(validar);

   // VALIDA EXT FILE EM FORMARQ
   $("#file").change(function() {
      var file = this.files[0];
      var fileType = file.type;
      var match = ['application/pdf'];
      if(!(fileType == match[0])){
         $("#file").val('');
         $('#extError').html('Somente arquivos .pdf !');
         return false;
      }
      if((fileType == match[0])){
         $('#extError').html('');
         return true;
      }
   }); 
   // VALIDA EXT FILE EXCEL/XML EM FORMARQ
   $("#fileExcel").change(function() {
      var file = this.files[0];
      var fileType = file.type;
      var match = ['text/xml'];
      if(!(fileType == match[0])){
         $("#fileExcel").val('');
         $('#errorExcel').html('Somente arquivos .xml !');
         return false;
      }
      if((fileType == match[0])){
         $('#errorExcel').html('');
         return true;
      }
   }); 
 });

function validar(){
   var status = 0;
   var msg="";
   var mss="";
   var mgg="";
   $('.field').removeClass('field-error');
   $("#span-error").html('');
   $("#divError").html('');
   $("#span-erro").html('');
   $('#msgCadastro').html('');

   // VALIDA CAMPO RADIO
   var radio = $("input[type='radio']").is(':checked');
   if(radio == false){
      mgg += '*Selecione um assunto!';
      $("#span-erro").html(mgg).addClass('error').fadeIn(300);
      status = 1;
   } 

   // VALIDA ARQUIVO EXISTENTE
   if(!($('#file').val())){
      $('#extError').html('Escolha um arquivo !');
      status = 1;
   }

   // VALIDA ARQUIVO EXCEL/XML EXISTENTE
   if(!($('#fileExcel').val())){
      $('#errorExcel').html('Escolha um arquivo !');
      status = 1;
   }

   $("[obrigatorio=sim]").each(function(){
      // VALIDA CHECKBOX FORMULARIO CADASTRO
      if( $('[grupock=propriedade]:checked').length == 0){
         mss += "*Um assunto deve ser escolhido";
         mss = "*Pelo menos um assunto deve ser escolhido";
         $("#span-error").html(mss).addClass('error').fadeIn(300);
      }
      // VALIDA CAMPOS VAZIOS FORMULARIO CADASTRO E ARQUIVO   
      if( $(this).val() == '' ) {
         msg += '<li>O campo '+ $(this).attr("id")+' é obrigatório !</li>';
         $(this).addClass('field-error');
         $("#divError").html(msg).addClass('error').fadeIn(300);
      }
   });

   if ( $("#divError").html() == '' || $("#span-error").html == '' ){
      status = 0;
   }else {
      status = 1;
   }

   if (status == 1) {
      status = 0;
      return false;
   } else {
      $('#load').html('Enviando...');
      return true;
   }

}
// FIM VALIDAÇÃO DE CAMPOS