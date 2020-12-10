var timerID;
var timerID_aviso_login;
var timerID_Flag=true;
var iCount = 30;
//var RECIP_IDIOMA = getCookie("RECIP_IDIOMA");

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

function scroll_on(){
    timerSCROLL = setInterval("document.getElementById('saida').scrollTop = 1000000;", 500);
}

function scroll_off(){
    window.clearInterval(timerSCROLL);
}

function hide_menu(){
var sUrlRaiz = document.getElementById('sUrlRaiz').value;

new Effect.SlideUp('menu_block1');

document.getElementById('botao_01').innerHTML = "<a href=\"#\" class=\"close_block\" onClick=\"show_menu()\"><img src=\"" + sUrlRaiz + "/imagens/cadastros/box_lateral_01_1_3_down.gif\" border=0></a>";

return false;

}

function limpa_aviso_login(){
    window.clearInterval(timerID_aviso_login);
    document.getElementById("aviso_login").innerHTML = "";
}



//######### LOGIN ##############################################################################################################################
//########################################################################################################################################################


function recipadm_06_001(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "login/login.php";

var sLogin = document.getElementById('username').value;
var sSenha = document.getElementById('pass').value;

   //return;
    $.ajax({
         url: sUrlAlvo,
         dataType: 'html',
         method: 'POST',
         data: {
            sLogin:sLogin,
            sSenha:sSenha
         }
     }).done(function(data){
            var	sRetorno   = data;
            
            console.log(sRetorno);

            //alert (sRetorno);
        //
            if (sRetorno.trim()=="TRUE"){
                    window.location.href = sUrlRaiz + "index.php";
            }
            else if (sRetorno.trim()=="FALSE"){
                 alert("LOGIN E/OU SENHA INVALIDOS");
                return;
            }
            else {
                alert("OPA!!! Ocorreu um problema.");
                return;
            }
            //document.getElementById('carrega_pergunta').innerHTML = sRetor
     });    
   

}


