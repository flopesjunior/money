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
function somenteNumeros(num) {
        var er = /[^0-9.]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
          campo.value = "";
        }
}

function BloqueiaTeste(ftt_tst_id){
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/testes/cadastro/bloqueia_teste.php";

    if (confirm("Deseja bloquear o teste em  execução?")==false){
        return;        
    }

    ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

//        if(ajax.readyState != 4 ) {
//            document.getElementById('show_status').innerHTML = "<img src="+sUrlRaiz+"/imagens/cadastros/salvando.gif border=0> &nbsp; SALVANDO REGISTRO...";
//        }

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            
            console.log(sRetorno);
            
            if (sRetorno.trim()=="true"){
                alert("O TESTE FOI BLOQUEADO COM SUCESSO!");
                window.location.href = sUrlRaiz + "controle/testes/cadastro/index.php";
            }
            else {
                alert("Ocorreu algum problema ao bloquear o teste.")
            }
            
        }
        
     }

     var parametros;
     parametros  = "ftt_tst_id="+ftt_tst_id;
     
     
     ajax.send(parametros);    
}

function SalvarCorrecao(ftt_tsp_id){
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var ftt_tst_id = document.getElementById('ftt_tst_id').value;

var sUrlAlvo = sUrlRaiz + "controle/testes/cadastro/cadastra_correcao.php";

    var ftt_tsp_observacao = $('#ftt_tsp_observacao').summernote('code');

    var radios1 = document.getElementsByName("optionsRadiosInline");
    for (var i = 0; i < radios1.length; i++) {
        if (radios1[i].checked) {
            //console.log("Escolheu: " + radios1[i].value);
            var ftt_tsp_correto = radios1[i].value;
        }
    }  
    
 
     //ajax.send(parametros);
    $.ajax({
         url: sUrlAlvo,
         dataType: 'html',
         method: 'POST',
         data: {
            ftt_tsp_id:ftt_tsp_id,
            ftt_tsp_correto:ftt_tsp_correto,
            ftt_tst_id:ftt_tst_id,
            ftt_tsp_observacao:ftt_tsp_observacao  
         }
    }).done(function(data){
            var	sRetorno   = data;
            
            console.log(sRetorno);
            
            if (sRetorno.trim()=="true"){
                window.location.href = sUrlRaiz + "controle/testes/cadastro/modal1.php?ftt_tst_id="+ftt_tst_id;
            }
    });     
    
   /*
    ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

//        if(ajax.readyState != 4 ) {
//            document.getElementById('show_status').innerHTML = "<img src="+sUrlRaiz+"/imagens/cadastros/salvando.gif border=0> &nbsp; SALVANDO REGISTRO...";
//        }

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            
            console.log(sRetorno);
            
            if (sRetorno.trim()=="true"){
                window.location.href = sUrlRaiz + "controle/testes/cadastro/modal1.php?ftt_tst_id="+ftt_tst_id;
            }
            
        }
        
     }

     var parametros;
     parametros  = "ftt_tsp_id="+ftt_tsp_id;
     parametros  += "&ftt_tsp_correto="+ftt_tsp_correto;
     parametros  += "&ftt_tst_id="+ftt_tst_id;
     parametros  += "&ftt_tsp_observacao="+ftt_tsp_observacao;
     
     
     
     ajax.send(parametros);   
     */
}

function ResetTeste(){
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var ftt_tst_id = document.getElementById('ftt_tst_id').value;

var sUrlAlvo = sUrlRaiz + "controle/testes/cadastro/reset_teste.php";

   if (!confirm("Os dados do teste serão perdidos, deseja continuar?")){
       return;
   }

   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

//        if(ajax.readyState != 4 ) {
//            document.getElementById('show_status').innerHTML = "<img src="+sUrlRaiz+"/imagens/cadastros/salvando.gif border=0> &nbsp; SALVANDO REGISTRO...";
//        }

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            
            console.log(sRetorno);
            
            if (sRetorno.trim()=="true"){
                alert("O teste foi liberado novamente.");
                window.location.href = sUrlRaiz + "controle/testes/cadastro/modal1.php?ftt_tst_id="+ftt_tst_id;
            }
            
        }
        
     }

     var parametros;
     parametros  = "ftt_tst_id="+ftt_tst_id;
     
     
     ajax.send(parametros);    
}

function registrar_teste(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/testes/cadastro/cadastra_teste.php";
//alert("sdsdsds");
var ftt_tst_id;
var ftt_tst_id_candidato;
var ftt_tst_id_prova;
var ftt_can_email;
var ftt_can_nome;
var em_invalido;
var ftt_tst_id_area;

    // Atribui valores as vari�veis
    ftt_tst_id             = document.getElementById('ftt_tst_id').value;
    ftt_tst_id_candidato   = document.getElementById('ftt_tst_id_candidato').value;
    ftt_tst_id_prova       = document.getElementById('ftt_tst_id_prova').value;
    ftt_can_email          = document.getElementById('ftt_can_email').value;
    ftt_can_nome           = document.getElementById('ftt_can_nome').value;
    em_invalido            = document.getElementById('em_invalido').value;
    ftt_tst_id_area        = document.getElementById('ftt_tst_id_area').value;
    
    if (em_invalido == "1"){
        alert ("Email está inválido!");
        return;        
    }
    
    if (ftt_tst_id_prova=="0"){
        alert ("É necessario selecionar um prova!");
        return;
    }    
    
    if (ftt_can_email.trim()=="" || ftt_can_nome.trim()==""){
        alert ("O EMAIL e NOME do candidato precisa ser digitado!");
        return;
    }
    
    if (ftt_tst_id_prova=="0"){
        alert ("É necessario selecionar um prova!");
        return;
    }   
    
    if (ftt_tst_id_area==""){
        alert ("É necessario selecionar a área interessada!");
        return;        
    }
    
   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

//        if(ajax.readyState != 4 ) {
//            document.getElementById('show_status').innerHTML = "<img src="+sUrlRaiz+"/imagens/cadastros/salvando.gif border=0> &nbsp; SALVANDO REGISTRO...";
//        }

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            var aRetorno = [];
            aRetorno = sRetorno.split("|");

            console.log("Retorno: " + aRetorno[0].trim());
//            console.log("Retorno: " + aRetorno[0]);
//            console.log("ID: " + aRetorno[1]);
            
            if (aRetorno[0].trim() == "true"){ 
                    var resp = confirm("Muito bom! O registro foi salvo com sucesso. \nDeseja continuar incluindo?");
                    if (resp==true){
                        //location.reload();
                        window.location.href = sUrlRaiz + "controle/testes/cadastro/modal1.php";;
                    }
                    else {
                        window.close();
                        opener.location.reload();                        
                    };                
            }
            else if (aRetorno[0].trim() == "existe"){ 
                alert("O registro não pode ser salvo. \nJá existe uma prova em aberto para esse candidato!!");
            }
            else {
                alert("Ops!!! Ocorreu um problema ao salvar o registro!!");
            }
            
        }
        
     }

     var parametros;
     parametros  = "ftt_tst_id="+ftt_tst_id;
     parametros  += "&ftt_tst_id_candidato="+ftt_tst_id_candidato;
     parametros  += "&ftt_tst_id_prova="+ftt_tst_id_prova;
     parametros  += "&ftt_can_email="+ftt_can_email;
     parametros  += "&ftt_can_nome="+ftt_can_nome;
     parametros  += "&ftt_tst_id_area="+ftt_tst_id_area;
     
     
     console.log("parametros: " + ftt_tst_id_prova);
     ajax.send(parametros);

}


function validacaoEmail(field) {
var ftt_can_email    = document.getElementById('ftt_can_email').value;
    
    if (ftt_can_email.trim()==""){
       document.getElementById('em_invalido').value = "";
       document.getElementById('candidato_existe').innerHTML = ""; 
       return;
    }
   
    usuario = field.value.substring(0, field.value.indexOf("@"));
    dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);

    if ((usuario.length >=1) &&
        (dominio.length >=3) && 
        (usuario.search("@")==-1) && 
        (dominio.search("@")==-1) &&
        (usuario.search(" ")==-1) && 
        (dominio.search(" ")==-1) &&
        (dominio.search(".")!=-1) &&      
        (dominio.indexOf(".") >=1)&& 
        (dominio.lastIndexOf(".") < dominio.length - 1)) {
    //document.getElementById("msgemail").innerHTML="E-mail válido";
         retorno = true;
    }
    else{
    //document.getElementById("msgemail").innerHTML="<font color='red'>E-mail inválido </font>";
        retorno = false;
    }
    
    if (retorno==true){
        busca_candidato();
        document.getElementById('em_invalido').value = "";
    }
    else {
        document.getElementById('candidato_existe').innerHTML = "EMAIL INVÁLIDO"; 
        document.getElementById('em_invalido').value = "1";
        
    }
    
    return;
    
}

function busca_candidato(){ 
var sUrlRaiz         = document.getElementById('sUrlRaiz').value;
var sUrlAlvo         = sUrlRaiz + "controle/testes/cadastro/busca_candidato.php";
var ftt_can_email    = document.getElementById('ftt_can_email').value;
   

    
   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            var aRetorno = [];
            aRetorno = sRetorno.split("|");
            
            if (aRetorno[0].trim() == "true"){
                document.getElementById('ftt_can_nome').value = aRetorno[1].trim(); 
                document.getElementById('ftt_tst_id_candidato').value   = aRetorno[2].trim(); 
                document.getElementById('candidato_existe').innerHTML = "O candidato já está cadastrado";
            }
            else {
                document.getElementById('candidato_existe').innerHTML = "Novo candidato!!";
                document.getElementById('ftt_tst_id_candidato').value = "";
            }
            
        }
        
     }


     var parametros;
     parametros  = "ftt_can_email="+ftt_can_email;

     ajax.send(parametros);

}

function busca_questao_correcao(ftt_tsp_id){ 
var sUrlRaiz         = document.getElementById('sUrlRaiz').value;
var sUrlAlvo         = sUrlRaiz + "controle/testes/cadastro/busca_correcao.php";
    
   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            //console.log(sRetorno);
            document.getElementById('mostra_questao').innerHTML = sRetorno;
            
//            $(document).ready(function() {
//                $('#ftt_tsp_observacao').summernote({
//                    height: 150
//                });
//            });
            
        }
        
     }


     var parametros;
     parametros  = "ftt_tsp_id="+ftt_tsp_id;

     ajax.send(parametros);

}

function busca_prova(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/testes/cadastro/busca_prova.php";

    // Atribui valores as vari�veis
   var ftt_tst_id_prova    = document.getElementById('ftt_tst_id_prova').value;
    
    
   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            document.getElementById('mostra_dados_prova').innerHTML = sRetorno;
            
        }
        
     }


     var parametros;
     parametros  = "ftt_prv_id="+ftt_tst_id_prova;

     ajax.send(parametros);

}

function busca_area(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/testes/cadastro/busca_area.php";

    // Atribui valores as vari�veis
   var ftt_tst_id_area    = document.getElementById('ftt_tst_id_area').value;
    
    
   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            document.getElementById('mostra_dados_area').innerHTML = sRetorno;
            
        }
        
     }


     var parametros;
     parametros  = "ftt_are_id="+ftt_tst_id_area;

     ajax.send(parametros);

}

function deleta_conteudo(ftt_prc_id){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/provas/cadastro/deleta_conteudo.php";
var ftt_prv_id;

   ftt_prv_id = document.getElementById('ftt_prv_id').value;
    
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
                window.location.href = sUrlRaiz + "controle/provas/cadastro/modal.php?ftt_prv_id="+ftt_prv_id;
                return;
            }
            
        }
        
     }


     var parametros;
     parametros  = "ftt_prc_id="+ftt_prc_id;

     ajax.send(parametros);

}

function deleta_prova(ftt_prv_id){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/provas/cadastro/deleta_prova.php";

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
                window.location.href = sUrlRaiz + "controle/provas/cadastro/index.php";
                return;
            }
            
        }
        
     }


     var parametros;
     parametros  = "ftt_prv_id="+ftt_prv_id;

     ajax.send(parametros);

}