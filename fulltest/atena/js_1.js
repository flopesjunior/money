var timerID;
var timerID_show_status;
var timerID_status_cartao;
var myVar;


function startBloqueio(){
    
    myVar = setInterval(chkBloqueio, 12000);
    
}

function chkBloqueio(){
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "atena/chk_bloqueio.php";
var ftt_tst_id = document.getElementById("ftt_tst_id").value;
//alert(ftt_tsp_id);


   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            console.log(sRetorno);
            if (sRetorno.trim()=="true"){
                window.location.href = sUrlRaiz + "atena/f6.php";
            }
            //document.getElementById('carrega_pergunta').innerHTML = sRetorno;
            
        }
        
   }


   var parametros;
   parametros   = "ftt_tst_id="+ftt_tst_id;
   ajax.send(parametros);

}


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


function ___startCountdown(){
  // Se o tempo não for zerado
  if((tempo - 1) >= 0){
      
      // Pega a parte inteira das horas
      var hor = parseInt((tempo/60)/60);
      // Pega a parte inteira dos minutos
      var min = parseInt(tempo/60);
      // Calcula os segundos restantes
      var seg = tempo%60;

      // Formata o número menor que dez, ex: 08, 07, ...
      if(hor < 10){
          hor = "0"+hor;
          hor = hor.substr(0, 2);
      }
      // Formata o número menor que dez, ex: 08, 07, ...
      if(min < 10){
          min = "0"+min;
          min = min.substr(0, 2);
      }

      if(seg <=9){
          seg = "0"+seg;
      }

      // Cria a variável para formatar no estilo hora/cronômetro
      horaImprimivel = hor + ':' + min + ':' + seg;

      //JQuery pra setar o valor
      document.getElementById('timer').innerHTML = horaImprimivel;

      // Define que a função será executada novamente em 1000ms = 1 segundo
      setTimeout('startCountdown()',1000);

      // diminui o tempo
      tempo--;
  // Quando o contador chegar a zero faz esta ação
  } else {

      alert("acabou");
  }
}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

function alternativas(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/questoes/cadastro/alternativas.php";

   
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
              
    }
    
}    
/*
function alternativas(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/questoes/cadastro/alternativas.php";

   
    var radios1 = document.getElementsByName("ftt_per_tipo");
    for (var i = 0; i < radios1.length; i++) {
        if (radios1[i].checked) {
            //console.log("Escolheu: " + radios1[i].value);
            ftt_per_tipo = radios1[i].value;
        }
    }
    if (ftt_per_tipo == 1){
        document.getElementById('alternativas').innerHTML = "";
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

//            if (sRetorno.trim() == "true"){ 
                    
                   document.getElementById('alternativas').innerHTML = sRetorno;
                    //window.close();
                    //opener.location.reload();
                    
//            }        
        }
        
     }
     
     var parametros;
     parametros  = "";
     

     ajax.send(parametros);
     
     

}
*/
function seleciona_alternativa(alt){
    var sUrlRaiz = document.getElementById('sUrlRaiz').value;
    var ftt_per_tipo = document.getElementById('ftt_per_tipo').value;
    var bSelected;
       
        eval("bSelected   = document.getElementById('Selected_"+alt+"').value;");

        if (bSelected === "") {
            eval("document.getElementById('Selected_"+alt+"').value = '1';");
            eval("document.getElementById('alt_"+alt+"').innerHTML = \"<button type='button' class='btn btn-success btn-circle btn-lg'  onclick=seleciona_alternativa("+alt+")>"+alt+"</button>\";");
        }
        else {
            eval("document.getElementById('Selected_"+alt+"').value = '';");
            eval("document.getElementById('alt_"+alt+"').innerHTML = \"<button type='button' class='btn btn-default btn-circle btn-lg ' onclick=seleciona_alternativa("+alt+")>"+alt+"</button>\";");
        }
        
        if (ftt_per_tipo == "2"){
            var aSelected = document.getElementsByName("Selected");
            for (var i = 0; i < aSelected.length; i++) {
                if (aSelected[i].value == "1" && (alt - 1) != i) {
                    var alternativa = i + 1;
                    eval("document.getElementById('Selected_"+alternativa+"').value = '';");
                    eval("document.getElementById('alt_"+alternativa+"').innerHTML = \"<button type='button' class='btn btn-default btn-circle btn-lg'  onclick=seleciona_alternativa("+alternativa+")>"+alternativa+"</button>\";");
                }
            }        
        }    
        
        
}

function __________seleciona_alternativa(alt){
  switch(alt) {
    case 1:
        if (document.getElementById('alt1')) document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        if (document.getElementById('alt2')) document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        if (document.getElementById('alt3')) document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        if (document.getElementById('alt4')) document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        if (document.getElementById('alt5')) document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        
        if (document.getElementById('optionsAlternativas1')) document.getElementById('optionsAlternativas1').value = alt;
        if (document.getElementById('optionsAlternativas1')) document.getElementById('optionsAlternativas1').value = "";
        if (document.getElementById('optionsAlternativas1')) document.getElementById('optionsAlternativas1').value = "";
        if (document.getElementById('optionsAlternativas1')) document.getElementById('optionsAlternativas1').value = "";
        if (document.getElementById('optionsAlternativas1')) document.getElementById('optionsAlternativas1').value = "";
        break;
        
    case 2:
        if (document.getElementById('alt1')) document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        if (document.getElementById('alt2')) document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        if (document.getElementById('alt3')) document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        if (document.getElementById('alt4')) document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        if (document.getElementById('alt5')) document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        document.getElementById('optionsAlternativas2').value = alt;
        break;
    case 3:
        if (document.getElementById('alt1')) document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        if (document.getElementById('alt2')) document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        if (document.getElementById('alt3')) document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        if (document.getElementById('alt4')) document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        if (document.getElementById('alt5')) document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        document.getElementById('optionsAlternativas3').value = alt;
        break;
    case 4:
        if (document.getElementById('alt1')) document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        if (document.getElementById('alt2')) document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        if (document.getElementById('alt3')) document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        if (document.getElementById('alt4')) document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        if (document.getElementById('alt5')) document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        document.getElementById('optionsAlternativas4').value = alt;
        break;
    case 5:
        if (document.getElementById('alt1')) document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        if (document.getElementById('alt2')) document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        if (document.getElementById('alt3')) document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        if (document.getElementById('alt4')) document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        if (document.getElementById('alt5')) document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        document.getElementById('optionsAlternativas5').value = alt;
        break;
    }
    
    
    
    //console.log("Escolheu: " + document.getElementById('ftt_alt_correta').value);

} 

function seleciona_alternativa_multiplas(alt){
    
  switch(alt) {
    case 1:
        
        document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        break;
    case 2:
        document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        break;
    case 3:
        document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        break;
    case 4:
        document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        break;
    case 5:
        document.getElementById('alt1').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(1)>1</button>";
        document.getElementById('alt2').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(2)>2</button>";
        document.getElementById('alt3').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(3)>3</button>";
        document.getElementById('alt4').innerHTML = "<button type='button' class='btn btn-default btn-circle' onclick=seleciona_alternativa(4)>4</button>";
        document.getElementById('alt5').innerHTML = "<button type='button' class='btn btn-success btn-circle' onclick=seleciona_alternativa(5)>5</button>";
        break;
    }
    
    document.getElementById('ftt_alt_correta').value = alt;
    
    console.log("Escolheu: " + document.getElementById('ftt_alt_correta').value);

} 


function registrar_candidato(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "atena/registra_candidato.php";

var ftt_can_id   = document.getElementById('ftt_can_id').value;
var ftt_can_nome = document.getElementById('ftt_can_nome').value;
var ftt_can_email = document.getElementById('ftt_can_email').value;
var ftt_can_celular = document.getElementById('ftt_can_celular').value;
var ftt_can_endereco = document.getElementById('ftt_can_endereco').value;
var ftt_can_cidade = document.getElementById('ftt_can_cidade').value;
var ftt_can_uf = document.getElementById('ftt_can_uf').value;
var ftt_can_telefone = document.getElementById('ftt_can_telefone').value;
var ftt_can_instuicao_ensino = document.getElementById('ftt_can_instuicao_ensino').value;
var ftt_can_curso = document.getElementById('ftt_can_curso').value;
var ftt_can_escolaridade = document.getElementById('ftt_can_escolaridade').value;
var ftt_can_escolaridade_ano_conclusao= document.getElementById('ftt_can_escolaridade_ano_conclusao').value;
var ftt_can_escolaridade_situacao;

    if (document.getElementById('ftt_can_escolaridade_situacao').checked){
        ftt_can_escolaridade_situacao = "1";
    }
    else {
        ftt_can_escolaridade_situacao = "0";
    }

    if (ftt_can_nome.trim()==""){
        alert ("O nome deve ser digitada!");
        return;
    }
    
    if (ftt_can_celular.trim()==""){
        alert ("O celular deve ser digitada!");
        return;
    }

    if (ftt_can_endereco.trim()==""){
        alert ("O enredeço deve ser digitada!");
        return;
    }
    
    if (ftt_can_cidade.trim()==""){
        alert ("A cidade deve ser digitada!");
        return;
    }
    
    if (ftt_can_uf.trim()==""){
        alert ("O UF deve ser digitada!");
        return;
    }    

    if (ftt_can_instuicao_ensino.trim()==""){
        alert ("A intituição deve ser digitada!");
        return;
    }
    
    if (ftt_can_escolaridade.trim()==""){
        alert ("A escolaridade deve ser selecionada!");
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
            if (sRetorno.trim() == "true"){ 
                window.location.href = sUrlRaiz + "atena/f1.php";
            }
            else {
                alert("Ops!!! Ocorreu um problema ao salvar o registro!!");
            }
            
        }
        
     }

     var parametros;
     parametros  = "ftt_can_id="+ftt_can_id;
     parametros  += "&ftt_can_nome="+ftt_can_nome;
     parametros  += "&ftt_can_email="+ftt_can_email;
     parametros  += "&ftt_can_celular="+ftt_can_celular;
     parametros  += "&ftt_can_endereco="+ftt_can_endereco;
     parametros  += "&ftt_can_cidade="+ftt_can_cidade;
     parametros  += "&ftt_can_uf="+ftt_can_uf;
     parametros  += "&ftt_can_telefone="+ftt_can_telefone;
     parametros  += "&ftt_can_instuicao_ensino="+ftt_can_instuicao_ensino;
     parametros  += "&ftt_can_curso="+ftt_can_curso;
     parametros  += "&ftt_can_escolaridade="+ftt_can_escolaridade;
     parametros  += "&ftt_can_escolaridade_ano_conclusao="+ftt_can_escolaridade_ano_conclusao;
     parametros  += "&ftt_can_escolaridade_situacao="+ftt_can_escolaridade_situacao;
     
     
     ajax.send(parametros);

}



function registra_questao(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "atena/registra_questao.php";

var ftt_per_id                  = document.getElementById("ftt_per_id").value;
var ftt_per_tipo                = document.getElementById("ftt_per_tipo").value;
var ftt_tsp_id                  = document.getElementById("_ftt_tsp_id").value;
var ftt_tsp_id_teste            = document.getElementById("ftt_tsp_id_teste").value;

var ftt_alt_id                  = "";
var ftt_tsp_resp_dissertativa   = "";
//alert(ftt_tsp_id);


   if (ftt_per_tipo == "1"){
         ftt_tsp_resp_dissertativa = $('#ftt_tsp_resp_dissertativa').summernote('code');
   }
   else {

            var aSelected = document.getElementsByName("Selected");
            for (var i = 0; i < aSelected.length; i++) {
                if (aSelected[i].value == "1") {
                    var alternativa = i + 1;
                    eval("iValor   = document.getElementById('optionsAlternativas_"+alternativa+"').value;");
                    if (ftt_alt_id.trim()==="") ftt_alt_id = iValor;
                    else ftt_alt_id += ";" + iValor;
                }
            }               
       /*
        var radios1 = document.getElementsByName("optionsAlternativas");
        for (var i = 0; i < radios1.length; i++) {
            if (radios1[i].checked) {
                if (ftt_alt_id.trim()==="") ftt_alt_id = radios1[i].value;
                else ftt_alt_id += ";" + radios1[i].value;
            }
        }

        if (!ftt_alt_id){
            alert ("Nenhuma opção foi selecionada");
            return;
        }
        */
   }
    
 //ajax.send(parametros);
    $.ajax({
         url: sUrlAlvo,
         dataType: 'html',
         method: 'POST',
         data: {
            ftt_alt_id:ftt_alt_id,
            ftt_per_id:ftt_per_id,
            ftt_tsp_id:ftt_tsp_id,
            ftt_per_tipo:ftt_per_tipo,
            ftt_tsp_resp_dissertativa:ftt_tsp_resp_dissertativa,
            ftt_tsp_id_teste:ftt_tsp_id_teste            
         }
     }).done(function(data){
            var	sRetorno   = data;
            
            console.log(sRetorno);

//            alert ("XXX");
        //
            if (sRetorno.trim()=="true"){
                    window.location.href = sUrlRaiz + "atena/f3.php";
            }
            else {
                alert("OPA!!! Ocorreu um problema no registro da resposta. Informe ao administrador.")
                return;
            }
            //document.getElementById('carrega_pergunta').innerHTML = sRetor
     });    
   

}

function anula_questao(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "atena/registra_questao_anulada.php";
var ftt_per_id = document.getElementById("ftt_per_id").value;
var ftt_tsp_id = document.getElementById("_ftt_tsp_id").value;
//alert(ftt_tsp_id);

   ajax=ajaxInit();

   ajax.open("POST", sUrlAlvo, true);

   ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
   ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
   ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
   ajax.setRequestHeader("Pragma", "no-cache");

   ajax.onreadystatechange = function() {

        if(ajax.readyState == 4 ) {

            var	sRetorno   = ajax.responseText;
            console.log(sRetorno);
            if (sRetorno.trim()=="true"){
                window.location.href = sUrlRaiz + "atena/f3.php";
            }
            //document.getElementById('carrega_pergunta').innerHTML = sRetorno;
            
        }
        
   }


   var parametros;
   parametros   = "ftt_per_id="+ftt_per_id;
   parametros  += "&ftt_tsp_id="+ftt_tsp_id;
    console.log(parametros);
   ajax.send(parametros);

}


