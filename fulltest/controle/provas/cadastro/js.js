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




function registrar_prova(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/provas/cadastro/cadastra_prova.php";
//alert("sdsdsds");
var ftt_prv_id;
var ftt_prv_descricao;
var ftt_prv_tempo;
var ftt_prv_nome;

    // Atribui valores as vari�veis
    ftt_prv_id         = document.getElementById('ftt_prv_id').value;
    //ftt_prv_descricao  = document.getElementById('ftt_prv_descricao').value;
    ftt_prv_nome       = document.getElementById('ftt_prv_nome').value;
    ftt_prv_tempo      = document.getElementById('ftt_prv_tempo').value;
    ftt_prv_descricao  = $('#ftt_prv_descricao').summernote('code');
    
    if (ftt_prv_descricao.trim()==""){
        alert ("É necessario digitar uma descrição para a prova!");
        return;
    }
    
    if (ftt_prv_tempo==""){
        alert ("É necessario digitar um tempo para a prova!");
        return;
    }
    
    $.ajax({
         url: sUrlAlvo,
         dataType: 'html',
         method: 'POST',
         data: {
            ftt_prv_descricao:ftt_prv_descricao,
            ftt_prv_id:ftt_prv_id,
            ftt_prv_tempo:ftt_prv_tempo,
            ftt_prv_nome:ftt_prv_nome
         }
     }).done(function(data){
            var	sRetorno   = data
            var aRetorno = [];
            aRetorno = sRetorno.split("|");

            console.log("Retorno: " + aRetorno[0]);
            console.log("ID: " + aRetorno[1]);
            
            if (aRetorno[0].trim() == "true"){ 
                window.location.href = sUrlRaiz + "controle/provas/cadastro/modal.php?ftt_prv_id="+aRetorno[1].trim();
            }
            else {
                alert("Ops!!! Ocorreu um problema ao salvar o registro!!");
            }
     });         

}

function editar_conteudo(ftt_prc_id, ftt_prc_id_especialidade, ftt_prc_nivel, ftt_prc_quantidade){ 
   
    document.getElementById('ftt_prc_id').value                 = ftt_prc_id;
    document.getElementById('ftt_prc_id_especialidade').value   = ftt_prc_id_especialidade;
    document.getElementById('ftt_prc_nivel').value              = ftt_prc_nivel;
    document.getElementById('ftt_prc_quantidade').value         = ftt_prc_quantidade;   
    
    busca_qde_questoes();
   
}

function limpar(){ 
   
    document.getElementById('ftt_prc_id').value                 = "";
    document.getElementById('ftt_prc_id_especialidade').value   = "";
    document.getElementById('ftt_prc_nivel').value              = "";
    document.getElementById('ftt_prc_quantidade').value         = "";   
    document.getElementById('mostra_quantidade').innerHTML      = "";
    
   
}
function registrar_conteudo(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/provas/cadastro/cadastra_conteudo.php";
var ftt_prv_id;
var ftt_prc_id;
var ftt_prc_id_especialidade;
var ftt_prc_nivel;
var ftt_prc_quantidade;
var qtd_questoes;

    // Atribui valores as vari�veis
    ftt_prv_id                  = document.getElementById('ftt_prv_id').value;
    ftt_prc_id                  = document.getElementById('ftt_prc_id').value;
    ftt_prc_id_especialidade    = document.getElementById('ftt_prc_id_especialidade').value;
    ftt_prc_nivel               = document.getElementById('ftt_prc_nivel').value;
    ftt_prc_quantidade          = document.getElementById('ftt_prc_quantidade').value;
    qtd_questoes                = document.getElementById('qtd_questoes').value;
    
//    alert(ftt_prc_id_especialidade);
    
    console.log("qtd_questoes: " + qtd_questoes + " ftt_prc_quantidade: " + ftt_prc_quantidade);
    if (parseInt(qtd_questoes.trim()) < parseInt(ftt_prc_quantidade.trim())){
        alert ("A quantidade de questões escolhida é MAIOR que a quantidade cadastrada para a ESPECIALIDADE e NÍVEL selecionados. ");
        return;        
    }
    
    if (ftt_prv_id==""){
        alert ("Ops! Ocorreu um erro! Parece que não existe uma prova selecionada.");
        return;
    }    
    if (ftt_prc_id_especialidade=="0"){
        alert ("É necessario selecionar a especialidade!");
        return;
    }
    if (ftt_prc_nivel=="0"){
        alert ("É necessario selecionar o nivel de dificuldade!");
        return;
    }    
    if (ftt_prc_quantidade=="" || ftt_prc_quantidade=="0"){
        alert ("É necessario digitar a quantidade de questões!");
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
            console.log("sRetorno: " + sRetorno);
            if (sRetorno.trim() == "existe"){
                alert("O conteúdo não foi salvo!! \nA especialidade e o nível escolhidos já existem para essa prova!!");
                return;
            } 
            else if (sRetorno.trim() == "true"){ 
                window.location.href = sUrlRaiz + "controle/provas/cadastro/modal.php?ftt_prv_id="+ftt_prv_id;
            }
            else {
                alert("Ops!!! Ocorreu um problema ao salvar o registro!!");
            }
            
        }
        
     }


     var parametros;
     parametros  = "ftt_prc_id="+ftt_prc_id;
     parametros  += "&ftt_prv_id="+ftt_prv_id;
     parametros  += "&ftt_prc_id_especialidade="+ftt_prc_id_especialidade;
     parametros  += "&ftt_prc_nivel="+ftt_prc_nivel;
     parametros  += "&ftt_prc_quantidade="+ftt_prc_quantidade;

     console.log("parametros: " + parametros);
     
     ajax.send(parametros);

}

function busca_qde_questoes(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/provas/cadastro/busca_qde_questoes.php";
var ftt_prc_id_especialidade;
var ftt_prc_nivel;

    document.getElementById('mostra_quantidade').innerHTML = "";
    
    // Atribui valores as vari�veis
    ftt_prc_id_especialidade    = document.getElementById('ftt_prc_id_especialidade').value;
    ftt_prc_nivel               = document.getElementById('ftt_prc_nivel').value;
    
    if (ftt_prc_id_especialidade.trim() == "0" || ftt_prc_nivel.trim() == "0"){
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
            console.log("sRetorno: " + sRetorno);
            
            document.getElementById('qtd_questoes').value = sRetorno;  
            
            if (sRetorno > 0){
              document.getElementById('mostra_quantidade').innerHTML = "Existem "+sRetorno+" questões cadastradas com os parâmetros acima"; 
            } else {
               document.getElementById('mostra_quantidade').innerHTML = "Não existem questões cadastradas com os parâmetros acima"; 
            }            
        }
        
     }


     var parametros;
     parametros  = "ftt_prc_id="+ftt_prc_id;
     parametros  += "&ftt_prv_id="+ftt_prv_id;
     parametros  += "&ftt_prc_id_especialidade="+ftt_prc_id_especialidade;
     parametros  += "&ftt_prc_nivel="+ftt_prc_nivel;
     parametros  += "&ftt_prc_quantidade="+ftt_prc_quantidade;

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