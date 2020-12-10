var timerID;
var timerID_show_status;
var timerID_status_cartao;

function ajaxInit() {
var ajax;

	//verifica se o browser tem suporte a ajax
	try {
		    ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e) {
		    try {
		      ajax = new ActiveXObject("Msxml2.XMLHTTP");
		    }
			catch(ex) {
		      try {
		          ajax = new XMLHttpRequest();
		      }
			  catch(exc) {
		          alert("Esse browser n�o tem recursos para uso do Ajax");
		          ajax = null;
		      }
		    }
	}

	return ajax;

}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
function filtrar(){
var sUrlRaiz            = document.getElementById('sUrlRaiz').value;
var id_especialidade    = document.getElementById('id_especialidade').value;
var id_nivel            = document.getElementById('id_nivel').value;

window.location.href = sUrlRaiz + "controle/questoes/cadastro/index.php?id_especialidade="+id_especialidade+"&id_nivel="+id_nivel;

return;
}

function alternativas(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/questoes/cadastro/alternativas.php";

   
    var alternativas = document.getElementsByName('chk_alternativa');
    for (var i = 0; i < alternativas.length; i++){    
         alternativas[i].checked = false;
    } 
    
    var radios1 = document.getElementsByName("ftt_per_tipo");
    for (var i = 0; i < radios1.length; i++) {
        if (radios1[i].checked) {
            //console.log("Escolheu: " + radios1[i].value);
            ftt_per_tipo = radios1[i].value;
        }
    }
    
    switch(ftt_per_tipo) {
          case "1":
            document.getElementById('alternativas').style.display = 'none';
            return;
          case "2":
            document.getElementById('alternativas').style.display = 'block';
            return;            
          case "3":
            document.getElementById('alternativas').style.display = 'block';
            return;
              
    }
    
   
    
}    



function seleciona_alternativa(alt){
    
    var radios1 = document.getElementsByName("ftt_per_tipo");
    
    for (var i = 0; i < radios1.length; i++) {
          if (radios1[i].checked) {
  //            console.log("Escolheu: " + radios1[i].value);
              var ftt_per_tipo = radios1[i].value;
          }
    }
    
//    var alternativas = document.getElementsByName('chk_alternativa');
//    for (var i = 0; i < alternativas.length; i++){    
//        
//    }
//    

    
  
    if (ftt_per_tipo == 2){
        switch(alt) {
          case 1:
              document.getElementById('chk_alternativa_1').checked = true;
              document.getElementById('chk_alternativa_2').checked = false;
              document.getElementById('chk_alternativa_3').checked = false;
              document.getElementById('chk_alternativa_4').checked = false;
              document.getElementById('chk_alternativa_5').checked = false;
              break;
          case 2:
              document.getElementById('chk_alternativa_1').checked = false;
              document.getElementById('chk_alternativa_2').checked = true;
              document.getElementById('chk_alternativa_3').checked = false;
              document.getElementById('chk_alternativa_4').checked = false;
              document.getElementById('chk_alternativa_5').checked = false;
              break;
          case 3:
              document.getElementById('chk_alternativa_1').checked = false;
              document.getElementById('chk_alternativa_2').checked = false;
              document.getElementById('chk_alternativa_3').checked = true;
              document.getElementById('chk_alternativa_4').checked = false;
              document.getElementById('chk_alternativa_5').checked = false;
              break;
          case 4:
              document.getElementById('chk_alternativa_1').checked = false;
              document.getElementById('chk_alternativa_2').checked = false;
              document.getElementById('chk_alternativa_3').checked = false;
              document.getElementById('chk_alternativa_4').checked = true;
              document.getElementById('chk_alternativa_5').checked = false;
              break;
          case 5:
              document.getElementById('chk_alternativa_1').checked = false;
              document.getElementById('chk_alternativa_2').checked = false;
              document.getElementById('chk_alternativa_3').checked = false;
              document.getElementById('chk_alternativa_4').checked = false;
              document.getElementById('chk_alternativa_5').checked = true;
              break;
          }

      } 
    
    document.getElementById('ftt_alt_correta').value = alt;
    
    //console.log("Escolheu: " + document.getElementById('ftt_alt_correta').value);

} 




function registrar_pergunta(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/questoes/cadastro/cadastra_pergunta.php";
//alert("sdsdsds");
var ftt_per_id;
var ftt_per_descricao;
var ftt_per_tipo;
var ftt_per_nivel;
var ftt_per_id_especialidade;
var txt_alternativa_1 = "";
var txt_alternativa_2 = "";
var txt_alternativa_3 = "";
var txt_alternativa_4 = "";
var txt_alternativa_5 = "";


    var chk_alternativa_1 = document.getElementById('chk_alternativa_1').checked;
    var chk_alternativa_2 = document.getElementById('chk_alternativa_2').checked;
    var chk_alternativa_3 = document.getElementById('chk_alternativa_3').checked;
    var chk_alternativa_4 = document.getElementById('chk_alternativa_4').checked;
    var chk_alternativa_5 = document.getElementById('chk_alternativa_5').checked;
    


    var ftt_per_descricao = $('#ftt_per_descricao').summernote('code');
//    console.log(ftt_per_descricao);
//    return;    
    
    // Atribui valores as vari�veis
    ftt_per_id        		= document.getElementById('ftt_per_id').value;
    ftt_per_id_especialidade    = document.getElementById('ftt_per_id_especialidade').value;
    
    txt_alternativa_1 = $('#txt_alternativa_1').summernote('code');
    txt_alternativa_2 = $('#txt_alternativa_2').summernote('code');
    txt_alternativa_3 = $('#txt_alternativa_3').summernote('code');
    txt_alternativa_4 = $('#txt_alternativa_4').summernote('code');
    txt_alternativa_5 = $('#txt_alternativa_5').summernote('code');
    
    var ftt_alt_correta         = document.getElementById('ftt_alt_correta').value;
    
    if (ftt_per_descricao.trim()==""){
        alert ("A pergunta deve ser digitada!");
        return;
    }
    
    if (ftt_per_id_especialidade==0){
        alert ("A especialidade deve ser escolhida!");
        return;
    }//   optionsRadios1      		= document.getElementById('optionsRadios1').che
//   optionsRadios2   		= document.getElementById('optionsRadios2').value;

    var radios1 = document.getElementsByName("ftt_per_tipo");
    for (var i = 0; i < radios1.length; i++) {
        if (radios1[i].checked) {
//            console.log("Escolheu: " + radios1[i].value);
            ftt_per_tipo = radios1[i].value;
        }
    }
    
    if (ftt_per_tipo == 2 || ftt_per_tipo == 3){ 
        
        if (document.getElementById('chk_alternativa_1').checked == false &&
            document.getElementById('chk_alternativa_2').checked == false &&
            document.getElementById('chk_alternativa_3').checked == false &&
            document.getElementById('chk_alternativa_4').checked == false &&
            document.getElementById('chk_alternativa_5').checked == false){
               alert("Ops!! Você não escolheu a alternativa correta.");
               return;
        }
    
        if (document.getElementById('chk_alternativa_1').checked && txt_alternativa_1.trim() == ""){
            alert("Ops!! Você escolheu a alternativa 1 como correta, mas ela esta em branco.");
            return;
        }
        if (document.getElementById('chk_alternativa_2').checked && txt_alternativa_2.trim() == ""){
            alert("Ops!! Você escolheu a alternativa 2 como correta, mas ela esta em branco.");
            return;
        }
        if (document.getElementById('chk_alternativa_3').checked && txt_alternativa_3.trim() == ""){
            alert("Ops!! Você escolheu a alternativa 3 como correta, mas ela esta em branco.");
            return;
        }
        if (document.getElementById('chk_alternativa_4').checked && txt_alternativa_4.trim() == ""){
            alert("Ops!! Você escolheu a alternativa 4 como correta, mas ela esta em branco.");
            return;
        }
        if (document.getElementById('chk_alternativa_5').checked && txt_alternativa_5.trim() == ""){
            alert("Ops!! Você escolheu a alternativa 5 como correta, mas ela esta em branco.");
            return;
        }
    }      

    
    var radios2 = document.getElementsByName("ftt_per_nivel");
    for (var i = 0; i < radios2.length; i++) {
        if (radios2[i].checked) {
//            console.log("Escolheu: " + radios2[i].value);
            ftt_per_nivel = radios2[i].value;
        }
    }
     
     //ajax.send(parametros);
    $.ajax({
         url: sUrlAlvo,
         dataType: 'html',
         method: 'POST',
         data: {
            ftt_per_descricao:ftt_per_descricao,
            ftt_per_tipo:ftt_per_tipo,
            ftt_per_nivel:ftt_per_nivel,
            ftt_per_id:ftt_per_id,
            ftt_per_id_especialidade:ftt_per_id_especialidade,
            txt_alternativa_1:txt_alternativa_1,
            txt_alternativa_2:txt_alternativa_2,
            txt_alternativa_3:txt_alternativa_3,
            txt_alternativa_4:txt_alternativa_4,
            txt_alternativa_5:txt_alternativa_5,
            ftt_alt_correta:ftt_alt_correta,
            chk_alternativa_1:chk_alternativa_1,
            chk_alternativa_2:chk_alternativa_2,
            chk_alternativa_3:chk_alternativa_3,
            chk_alternativa_4:chk_alternativa_4,
            chk_alternativa_5:chk_alternativa_5              
         }
     }).done(function(data){
            var	sRetorno   = data;

            console.log(sRetorno);
            if (sRetorno.trim() == "true"){ 
                    var resp = confirm("Muito bom! O registro foi salvo com sucesso. \nDeseja continuar incluindo?");
                    if (resp==true){
                        //location.reload();
                        window.location.href = sUrlRaiz + "controle/questoes/cadastro/modal.php";
                    }
                    else {
                        window.close();
                        opener.location.reload();                        
                    };
            }
            else {
                alert("Ops!!! Ocorreu um problema ao salvar o registro!!");
            }
     }); 

}

function deleta_questao(ftt_per_id){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/questoes/cadastro/deleta_pergunta.php";

   var resp = confirm("Confirma a exclusão do registro?");
   if (resp==false){
        return;
   }
        
   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            console.log("sRetorno: " + sRetorno);
            
            if (sRetorno.trim() == 'true'){
                alert("O registro foi excluído com sucesso!!");
                window.location.href = sUrlRaiz + "controle/questoes/cadastro/index.php";
                return;
            }
            
        }
        
     }


     var parametros;
     parametros  = "ftt_per_id="+ftt_per_id;

     ajax.send(parametros);

}
