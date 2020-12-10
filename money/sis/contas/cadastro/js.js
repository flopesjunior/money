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

function registrar_candidato(){ 
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var sUrlAlvo = sUrlRaiz + "controle/contas/cadastro/registra_contas.php";

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
var ftt_can_escolaridade_ano_conclusao = document.getElementById('ftt_can_escolaridade_ano_conclusao').value;
var ftt_can_proc_status = document.getElementById('ftt_can_proc_status').value;
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
    
    if (ftt_can_email.trim()==""){
        alert ("O email deve ser digitada!");
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
            if (sRetorno.trim() == "existe"){
                alert("O candidato não foi salvo!! \nMotivo: Este email já esta cadastrado na base de dados!!");
                return;
            } 
            else if (sRetorno.trim() == "true"){ 
                alert("Registro foi salvo com sucesso!!");
                return;
            }
            else {
                alert("Ops!!! Ocorreu um problema ao salvar o registro!!");
                return;
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
     parametros  += "&ftt_can_proc_status="+ftt_can_proc_status;
     
     ajax.send(parametros);

}

