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

function f_OnKeyUp(e){
    var keynum;
    
/*
        if(window.event) { // IE
          keynum = e.keyCode;
        }
        else if(e.which) { // Netscape/Firefox/Opera
          keynum = e.which;
        }

        //alert(keynum);

        switch (keynum){

                
            case 13: //ENTER
                if (trim(document.getElementById('sLogin').value) != ""){
                    recipadm_06_001();
                }
                else {
                    timerID_aviso_login = window.setInterval("limpa_aviso_login();", 3000);
                    document.getElementById('aviso_login').innerHTML = "O campo <b>Usu�rio</b> deve ser preenchido."
                }
                break;

        }

 */

return;
}

//######### LOGIN ##############################################################################################################################
//########################################################################################################################################################

function recipadm_06_001(){ //AUTENTICA��O
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "/controle/adm/login/login.php";

    var sLogin = document.getElementById('sLogin').value;
    var sSenha = document.getElementById('sSenha').value;

    ajax=ajaxInit();

    ajax.open("POST", sUrlAlvo, true);

    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
    ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
    ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
    ajax.setRequestHeader("Pragma", "no-cache");

    ajax.onreadystatechange = function() {

        if(ajax.readyState == 1) {
            document.getElementById('aviso_login').innerHTML = "autenticando...";
        }
        if(ajax.readyState == 4 ) {
            var retorno = ajax.responseText;
            var acao;

            console.log("retorno: "+retorno.trim()+"XX");

            if (retorno.trim() == "TRUE") {
                    window.location = sUrlRaiz + "/pages/index.php";
                    return;
            }
            else if (retorno.trim() == "FALSE"){
                    acao = "LOGIN E/OU SENHA INVALIDOS";
                    alert(acao);
//                    document.getElementById('aviso_login').innerHTML  = acao;
            }
            else {
                    acao = "OCORREU UM PROBLEMA NA AUTENTICACAO";
                    alert(acao);
            }
            
        }
    }

    //Par�metros
    parametros    = "sLogin="+sLogin;
    parametros   += "&sSenha="+sSenha;

    ajax.send(parametros);
}






