function CarregaPagina(){
var sUrlRaiz = document.getElementById('sUrlRaiz').value;
var atalho   = document.getElementById('atalho').value;
var sUrlAlvo = "";

    switch (atalho) {
        case "0":
            sUrlAlvo = sUrlRaiz;
            break;
        case "1":
            sUrlAlvo = sUrlRaiz + "/adm/recipadm_00/index.php";
            break;
        case "2":
            sUrlAlvo = sUrlRaiz + "/adm/recipadm_01/index.php";
            break;
        case "3":
            sUrlAlvo = sUrlRaiz + "/adm/recipadm_02/index.php";
            break;
        case "4":
            sUrlAlvo = sUrlRaiz + "/adm/recipadm_03/index.php";
            break;
        case "5":
            sUrlAlvo = sUrlRaiz + "/adm/recipadm_06/index.php";
            break;
        case "6":
            sUrlAlvo = sUrlRaiz + "/adm/recipadm_08/index.php";
            break;

    }

    window.location = sUrlAlvo;

    return;
}

//As 2 funções abaixo Lê e Grava Cookies
function setCookie(cookie_name, cookie_value, expire_in_days){
var cookie_expire = "";

  if (expire_in_days != null)
  {
        var expire = new Date();
        expire.setTime(expire.getTime() + 1000*60*60*24*parseInt(expire_in_days));
        cookie_expire = "; expires=" + expire.toGMTString();
  }

 document.cookie = escape(cookie_name) + "=" + escape(cookie_value) + cookie_expire;
}

function getCookie(cookie_name){
    if (!document.cookie.match(eval("/" + escape(cookie_name) + "=/"))){
        return false;
    }

    return unescape(document.cookie.replace(eval("/^.*?" + escape(cookie_name) + "=([^\\s;]*).*$/"), "$1"));
}


// Faz funcionar as flechinhas UP e Down, incrementado ou decrementando os valores nos objetos TEXT
function text_updown(obj, acao){

var strval = document.getElementById(obj).value;
var intval = parseInt(strval);

    if (document.getElementById("form_travado").value == 1) return false;

    //alert(document.getElementById("form_travado").value);

    if (acao == "up") newval = intval + 1;
    else if (acao == "down") newval = intval - 1;

    if (newval < 0) newval = 0;

    document.getElementById(obj).value = newval;

    return true;
}

// LTrim(string) : Returns a copy of a string without leading spaces.
function ltrim(str)
{
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(0)) != -1) {
      var j=0, i = s.length;
      while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
         j++;
      s = s.substring(j, i);
   }
   return s;
}

//RTrim(string) : Returns a copy of a string without trailing spaces.
function rtrim(str)
{
   var whitespace = new String(" \t\n\r");
   var s = new String(str);
   if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
      var i = s.length - 1;       // Get length of string
      while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
         i--;
      s = s.substring(0, i+1);
   }
   return s;
}

// Trim(string) : Returns a copy of a string without leading or trailing spaces
function trim(str) {
   return rtrim(ltrim(str));
}

function fAbreJanela(mypage,myname,w,h,scroll,resizable,pos,titlebar) {
	if (mypage == '') return false;
		//
	var win=null;
		//

	if (pos=="hidden") {
		LeftPosition=5000;
		TopPosition=5000;
	}
	else if (pos=="random") {
		LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;
		TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;
	}
	else if (pos=="center") {
		LeftPosition=(screen.width)?(screen.width-w)/2:100;
		TopPosition=(screen.height)?(screen.height-h)/2:100;
	}
	else {
		LeftPosition=40;
		TopPosition=20;
	}

		//

	settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=yes,menubar=no,toolbar=no,titlebar=no,resizable='+resizable;

		//

	win=window.open(mypage,myname,settings);

	win.focus();
    
}

function fBordaImagem(which,color){
	if (document.all || document.getElementById) which.style.borderColor=color
}

function fFechaJanela(valor,formobjetosvalores) {
	if (opener && valor != "" && formobjetosvalores == "") {
		opener.location.replace(valor);
		opener.focus();
	}
	if (opener && valor != "" && formobjetosvalores != "") {
		formobjetosvalores_1 = formobjetosvalores.split(';');
		for (i=0; i<formobjetosvalores_1.length; i++) {
			formobjetosvalores_2 = formobjetosvalores_1[i].split('=');

			if (eval("opener.document."+formobjetosvalores_2[0]+".type") == "text") {
				eval("opener.document."+formobjetosvalores_2[0]+".value='"+formobjetosvalores_2[1]+"'");
			}
			if (eval("opener.document."+formobjetosvalores_2[0]+".type") == "textarea") {
				eval("opener.document."+formobjetosvalores_2[0]+".value+='"+formobjetosvalores_2[1]+"'");
			}
			if (eval("opener.document."+formobjetosvalores_2[0]+".type") == "hidden") {
				eval("opener.document."+formobjetosvalores_2[0]+".value='"+formobjetosvalores_2[1]+"'");
			}
			if (eval("opener.document."+formobjetosvalores_2[0]+".type") == "select-one") {
				eval("opener.document."+formobjetosvalores_2[0]+".value='"+formobjetosvalores_2[1]+"'");
			}
		}
	}
	opener.focus();
	this.close();
}

function fJS_InsTextBox(selecao, obj) {
	 data = "";
	 for (i=1; i <= selecao; i++)
      data = data + "<input type=file class=oText name="+obj+i+"><br>";

	 if (document.layers) {
      document.layers.cust.document.write(data);
      document.layers.cust.document.close();
   }
   else {
      if (document.all) {
         cust.innerHTML = data;
      }
   }
}

function getElementIndex(obj) {
	var theform = obj.form;
	for (var i=0; i<theform.elements.length; i++) {
		if (obj.name == theform.elements[i].name) {
			return i;
			}
		}
	return -1;
	}

function fTabNext(obj) {
	if (navigator.platform.toUpperCase().indexOf("SUNOS") != -1) {
		obj.blur(); return;
		}
	var theform = obj.form;
	var i = getElementIndex(obj);
	var j=i+1;
	if (j >= theform.elements.length) { j=0; }
	if (i == -1) { return; }
	while (j != i) {
		if ((theform.elements[j].type!="hidden") &&
				(theform.elements[j].type!="button") &&
				(theform.elements[i].type!="textarea") &&
			  (theform.elements[j].name != theform.elements[i].name) &&
				(!theform.elements[j].disabled) ||
				(theform.elements[j].name == "oFocus")) {
			theform.elements[j].focus();
			break;
		}
		j++;
		if (j >= theform.elements.length) { j=0; }
	}
}

function fJS_RemoveEspacos(campo) {
  var tmp = "";
  var campo_length = campo.value.length;
  var campo_length_menos_1 = campo.value.length - 1;
  for (index = 0; index < campo_length; index++) {
    if (campo.value.charAt(index) != ' ') {
      tmp += campo.value.charAt(index);
    }
    else {
      if (tmp.length > 0) {
        if (campo.value.charAt(index+1) != ' ' && index != campo_length_menos_1) {
          tmp += campo.value.charAt(index);
        }
      }
    }
  }
  campo.value = tmp;
}

function fJS_TextoMaiusculo() {
   event.keyCode = String.fromCharCode(event.keyCode).toUpperCase().charCodeAt(0);
}

function fJS_TextoMinusculo() {
   event.keyCode = String.fromCharCode(event.keyCode).toLowerCase().charCodeAt(0);
}

function fJS_IgnoraAcentos(campo) {
	campo.value = campo.value.
									 replace(/á/gi,"a").
									 replace(/à/gi,"a").
									 replace(/ä/gi,"a").
									 replace(/ã/gi,"a").
									 replace(/â/gi,"a").
									 replace(/é/gi,"e").
									 replace(/è/gi,"e").
									 replace(/ë/gi,"e").
									 replace(/ê/gi,"e").
									 replace(/í/gi,"i").
									 replace(/ì/gi,"i").
									 replace(/ï/gi,"i").
									 replace(/î/gi,"i").
									 replace(/ó/gi,"o").
									 replace(/ò/gi,"o").
									 replace(/ö/gi,"o").
									 replace(/õ/gi,"o").
									 replace(/ô/gi,"o").
									 replace(/ú/gi,"o").
									 replace(/ù/gi,"u").
									 replace(/ü/gi,"u").
									 replace(/û/gi,"û").toLowerCase();
}


function fJS_FormataFone(sCampo){
	var p;
	p 	= sCampo.value;

	d1=p.indexOf('(');
	d2=p.indexOf(')');
	if(p.length==2){
		pp=p;
		if(d1==-1){ pp="("+pp;	}
		if(d2==-1){ pp=pp+")";  }
		sCampo.value="";
		sCampo.value=pp;
	}

	if (p.length>9){
		d3=p.indexOf("-");
		if ( d3!=-1 ) {
			n1=p.substring(0,d3);
			n2=p.substring(d3+1,p.length);
			pp=n1+n2;
			p="";
			p=pp;
		}
		n1=p.substring(0,(p.length - 3));
		n2=p.substring((p.length - 3),p.length);
		pp=n1+"-"+n2;
		sCampo.value="";
		sCampo.value=pp;
	}
 }

function fJS_FormataCEP(sCampo,iTamMax,iPosTraco,tTeclaPres){
  if (event.keyCode < 48 || event.keyCode > 57) event.returnValue=false;

	var iTecla, sValorTxt, iTam;

 	iTecla = tTeclaPres.keyCode;
 	sValorTxt = sCampo.value;
 	sValorTxt = sValorTxt.toString().replace( "-", "" );
 	iTam = sValorTxt.length ;

 	if (iTam < iTamMax && iTecla != 8) {
  	iTam = sValorTxt.length + 1 ;
 	}

 	if (iTecla == 8 ) {
  	iTam = iTam - 1 ;
 	}

 	if ( iTecla == 8 || iTecla == 88 || iTecla >= 48 && iTecla <= 57 || iTecla >= 96 && iTecla <= 105 ){
  	if ( iTam <= 3 ){
    	sCampo.value = sValorTxt ;
  	}
  	if (iTam > iPosTraco && iTam <= iTamMax) {
    	sValorTxt = sValorTxt.substr(0, iTam - iPosTraco) + '-' + sValorTxt.substr(iTam - iPosTraco, iTam);
  	}
  	sCampo.value = sValorTxt;
 	}
}

function fJS_FormataMoeda(str, sepM, sepU, nc) {
	p=str.value;

while ( (p.indexOf('0')==0) || (p.indexOf(',')==0) ) {
	str.value="";
	str.value=p.substring(1,str.length);
	p=str.value;
}
if (p.length <= nc){
	zero="";
	for (i=1; i < (nc - p.length) ; i++  ) {
		zero=zero+"0";
	}
	str.value="";
	str.value="0"+sepU+zero+p;
}
if (p.length >= nc){
		p1=p.indexOf(sepM);
		while (p1!=-1){
			s1=p.substring(0,p1);
			s2=p.substring(p1+1,p.length);
			str.value="";
			str.value=s1+s2;
			p=str.value;
			p1=p.indexOf(sepM);
		}
		p1=p.indexOf(sepU);
		if ( p1!=-1 ) {
			s1=p.substring(0,p1)+p.substring(p1+1,p.length);
			p=s1;
			s1="";
		}
		s1=p.substring(0,p.length-(nc-1));
		s2=p.substring(p.length-(nc-1),p.length);
		s13="";
		while (s1.length>3){
			s12=sepM+s1.substring(s1.length - 3,s1.length);
			s13=s13+s12;
			s14=s1.substring(0,s1.length-3);
			s1=s14;
		}
		s14="";
		s14=s1+s13;
		str.value="";
		str.value=s14+sepU+s2;
}
}


function fJS_FormataCPF_CGC(pForm,pCampo,pTamMax,pPos1,pPos2,pPosBarra,pPosTraco,pTeclaPres){
 var wTecla, wVr, wTam;
		//
 wTecla = pTeclaPres.keyCode;
 wVr = pForm[pCampo].value;
 wVr = wVr.toString().replace( "-", "" );
 wVr = wVr.toString().replace( ".", "" );
 wVr = wVr.toString().replace( ".", "" );
 wVr = wVr.toString().replace( "/", "" );
 wTam = wVr.length ;
	//
 if (wTam < pTamMax && wTecla != 8) {
    wTam = wVr.length + 1 ;
 }
 if (wTecla == 8 ) {
    wTam = wTam - 1 ;
 }
 if ( wTecla == 8 || wTecla == 88 || wTecla >= 48 && wTecla <= 57 || wTecla >= 96 && wTecla <= 105 ){
  if ( wTam <= 2 ){
    pForm[pCampo].value = wVr ;
  }
  if (wTam > pPosTraco && wTam <= pTamMax) {
        wVr = wVr.substr(0, wTam - pPosTraco) + '-' + wVr.substr(wTam - pPosTraco, wTam);
				if (pPosBarra) wVr = wVr.substr(0, wTam - pPosBarra) + '/' + wVr.substr(wTam - pPosBarra, wTam);
	}
  if ( wTam == pTamMax){
        wVr = wVr.substr( 0, wTam - pPos1 ) + '.' + wVr.substr(wTam - pPos1, 3) + '.' + wVr.substr(wTam - pPos2, wTam);
  }
  pForm[pCampo].value = wVr;
 }
}

function fJS_ValidaCPF(pForm, pCampo, string) {
	var StrData = string;
	var CPFPat  = /^(\d{3}).(\d{3}).(\d{3})-(\d{2})/;
	var CPFPat2 = /^(\d{11})/;
	var matchCPFArray    = StrData.match(CPFPat);
	var matchCPFArray2   = StrData.match(CPFPat2);
		//
	if (!StrData) return true;
	else {
		if (matchCPFArray == null && matchCPFArray2 == null) {
		    alert('CPF Inválido!\n');
				pForm[pCampo].focus();
				return false;
		}
		else if(matchCPFArray != null) {
			StrData = matchCPFArray[1] + matchCPFArray[2] + matchCPFArray[3] + matchCPFArray[4];
			if (!check_cpf(StrData)) {
		    	alert('CPF Inválido!\n');
					pForm[pCampo].focus();
			    return false;
	   		}
		   	else return true;
		}
		else if(matchCPFArray2 != null) {
			StrData = matchCPFArray2[1];
			if (!check_cpf(StrData)) {
		    	alert('CPF Inválido!\n');
					pForm[pCampo].focus();
			    return false;
	   		}
		   	else return true;
		}
	}
}

function check_cpf (StrCPF) {
	x = 0;
	soma = 0;
	dig1 = 0;
	ig2 = 0;
	texto = "";
	trCPF1="";
	len = StrCPF.length;
	x = len -1;
	for (var i=0; i <= len - 3; i++) {
		y = StrCPF.substring(i,i+1);
		soma = soma + ( y * x);
		x = x - 1;
		texto = texto + y;
	}
	dig1 = 11 - (soma % 11);
	if (dig1 == 10) dig1=0 ;
	if (dig1 == 11) dig1=0 ;
	StrCPF1 = StrCPF.substring(0,len - 2) + dig1 ;
	x = 11; soma=0;
	for (var i=0; i <= len - 2; i++) {
		soma = soma + (StrCPF1.substring(i,i+1) * x);
		x = x - 1;
	}
	dig2= 11 - (soma % 11);
	if (dig2 == 10) dig2=0;
	if (dig2 == 11) dig2=0;
	if ((dig1 + "" + dig2) == StrCPF.substring(len,len-2)) return true;
	return false;
}

function fJS_ValidaCNPJ(pForm, pCampo) {
	 if (pForm[pCampo].value.length == 0) return true;
	 if (pForm[pCampo].value.substr(0,1) != 0 && pForm[pCampo].value.length < 19) {
			pForm[pCampo].value = '0' + pForm[pCampo].value;
			pForm[pCampo].value = pForm[pCampo].value.replace('/', '');
			pForm[pCampo].value = pForm[pCampo].value.replace('.', '');
			pForm[pCampo].value = pForm[pCampo].value.replace('-', '');
			var tempCNPJ = '';
			tempCNPJ += pForm[pCampo].value.substr(0,3) + '.';
			tempCNPJ += pForm[pCampo].value.substr(3,3) + '.';
			tempCNPJ += pForm[pCampo].value.substr(6,3) + '/';
			tempCNPJ += pForm[pCampo].value.substr(9,4) + '-';
			tempCNPJ += pForm[pCampo].value.substr(13,2);
			pForm[pCampo].value = tempCNPJ;
	 }
	 if (pForm[pCampo].value.length == 19) {
	   if (VerifyCNPJ(pForm[pCampo].value) == 1) return true;
	   else {
	      alert("CNPJ inválido!");
	      pForm[pCampo].focus();
	      return false;
	   }
	 }
	 else {
	 	alert('O número do CNPJ deve ser informado incluindo-se os 15 dígitos.');
		pForm[pCampo].focus();
		return false;
	 }
}

function isNumb(c) {
	if((cx=c.indexOf(","))!=-1) c = c.substring(0,cx)+"."+c.substring(cx+1);
	if((parseFloat(c) / c != 1)) {
		if(parseFloat(c) * c == 0) return(1);
		else return(0);
	}
	else return(1);
}

function LIMP(c) {
	while((cx=c.indexOf("-"))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	while((cx=c.indexOf("/"))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	while((cx=c.indexOf(","))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	while((cx=c.indexOf("."))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	while((cx=c.indexOf("("))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	while((cx=c.indexOf(")"))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	while((cx=c.indexOf(" "))!=-1) c = c.substring(0,cx)+c.substring(cx+1);
	return(c);
}

function VerifyCNPJ(CNPJ) {
	CNPJ = LIMP(CNPJ);
	if(isNumb(CNPJ) != 1) return(0);
	else {
		if(CNPJ == 0) return(0);
		else {
			g=CNPJ.length-2;
			if(RealTestaCNPJ(CNPJ,g) == 1) {
				g=CNPJ.length-1;
				if(RealTestaCNPJ(CNPJ,g) == 1) return(1);
				else return(0);
			}
			else return(0);
		}
	}
}

function RealTestaCNPJ(CNPJ,g) 	{
	var VerCNPJ=0;
	var ind=2;
	var tam;
	for(f=g;f>0;f--) {
		VerCNPJ+=parseInt(CNPJ.charAt(f-1))*ind;
		if(ind>8) ind=2;
		else ind++;
	}
	VerCNPJ%=11;
	if(VerCNPJ==0 || VerCNPJ==1) VerCNPJ=0;
	else VerCNPJ=11-VerCNPJ;
	if(VerCNPJ!=parseInt(CNPJ.charAt(g))) return(0);
	else return(1);
}

var isNav4 = false, isNav5 = false, isIE4 = false
var strSeperator = "/";

var vDateType = 3;
var vYearType = 4;
var vYearLength = 2;
var err = 0;

if(navigator.appName == "Netscape") {
  if (navigator.appVersion < "5") {
    isNav4 = true;
    isNav5 = false;
  }
  else
    if (navigator.appVersion > "4") {
      isNav4 = false;
      isNav5 = true;
    }
}

else {
  isIE4 = true;
}


function fJS_FormataData(vDateName, vDateValue, e, dateCheck, dateType) {
  vDateType = dateType;

	if (vDateValue == "~") {
    alert("AppVersion = "+navigator.appVersion+" \nNav. 4 Version = "+isNav4+" \nNav. 5 Version = "+isNav5+" \nIE Version = "+isIE4+" \nYear Type = "+vYearType+" \nDate Type = "+vDateType+" \nSeparator = "+strSeperator);
    vDateName.value = "";
    vDateName.focus();
    return true;
  }

  var whichCode = (window.Event) ? e.which : e.keyCode;
  if (vDateValue.length > 8 && isNav4) {
    if ((vDateValue.indexOf("-") >= 1) || (vDateValue.indexOf("/") >= 1))
      return true;
  }

  var alphaCheck = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/-";
  if (alphaCheck.indexOf(vDateValue) >= 1) {
    if (isNav4) {
      vDateName.value = "";
      vDateName.focus();
      vDateName.select();
      return false;
    }
    else {
      vDateName.value = vDateName.value.substr(0, (vDateValue.length-1));
      return false;
   }
  }

  if (whichCode == 8)
    return false;
  else {

    var strCheck = '13,47,48,49,50,51,52,53,54,55,56,57,58,59,95,96,97,98,99,100,101,102,103,104,105';
    if (strCheck.indexOf(whichCode) != -1) {
      if (isNav4) {
        if (((vDateValue.length < 6 && dateCheck) || (vDateValue.length == 7 && dateCheck)) && (vDateValue.length >=1)) {
          alert("Data Iválida!");
          vDateName.value = "";
          vDateName.focus();
          vDateName.select();
          return false;
        }
        if (vDateValue.length == 6 && dateCheck) {
          var mDay = vDateName.value.substr(2,2);
          var mMonth = vDateName.value.substr(0,2);
          var mYear = vDateName.value.substr(4,4)

          if (mYear.length == 2 && vYearType == 4) {
            var mToday = new Date();

            var checkYear = mToday.getFullYear() + 30;
            var mCheckYear = '20' + mYear;
            if (mCheckYear >= checkYear)
              mYear = '19' + mYear;
            else
              mYear = '20' + mYear;
          }

          var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
          if (!dateValid(vDateValueCheck)) {
            alert("Data Inválida!");
            vDateName.value = "";
            vDateName.focus();
            vDateName.select();
            return false;
          }
          return true;
        }

        else {
          if (vDateValue.length >= 8  && dateCheck) {
            if (vDateType == 1) { // mmddyyyy
              var mDay = vDateName.value.substr(2,2);
              var mMonth = vDateName.value.substr(0,2);
              var mYear = vDateName.value.substr(4,4)
              vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
            }
            if (vDateType == 2) { // yyyymmdd
              var mYear = vDateName.value.substr(0,4)
              var mMonth = vDateName.value.substr(4,2);
              var mDay = vDateName.value.substr(6,2);
              vDateName.value = mYear+strSeperator+mMonth+strSeperator+mDay;
            }
            if (vDateType == 3) { // ddmmyyyy
              var mMonth = vDateName.value.substr(2,2);
              var mDay = vDateName.value.substr(0,2);
              var mYear = vDateName.value.substr(4,4)
              vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
            }

            var vDateTypeTemp = vDateType;
            vDateType = 1;
            var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
            if (!dateValid(vDateValueCheck)) {
              alert("Data Inválida!");
              vDateType = vDateTypeTemp;
              vDateName.value = "";
              vDateName.focus();
              vDateName.select();
              return false;
            }

            vDateType = vDateTypeTemp;
            return true;
          }
          else {
            if (((vDateValue.length < 8 && dateCheck) || (vDateValue.length == 9 && dateCheck)) && (vDateValue.length >=1)) {
              alert("Data Inválida!");
              vDateName.value = "";
              vDateName.focus();
              vDateName.select();
              return false;
            }
          }
        }
      }
    else {
      if (((vDateValue.length < 8 && dateCheck) || (vDateValue.length == 9 && dateCheck)) && (vDateValue.length >=1)) {
        alert("Data Inválida!");
        vDateName.value = "";
        vDateName.focus();
        return true;
      }

      if (vDateValue.length >= 8 && dateCheck) {
        if (vDateType == 1) { // mm/dd/yyyy
          var mMonth = vDateName.value.substr(0,2);
          var mDay = vDateName.value.substr(3,2);
          var mYear = vDateName.value.substr(6,4)
        }
        if (vDateType == 2) { // yyyy/mm/dd
          var mYear = vDateName.value.substr(0,4)
          var mMonth = vDateName.value.substr(5,2);
          var mDay = vDateName.value.substr(8,2);
        }
        if (vDateType == 3) { // dd/mm/yyyy
          var mDay = vDateName.value.substr(0,2);
          var mMonth = vDateName.value.substr(3,2);
          var mYear = vDateName.value.substr(6,4)
        }
        if (vYearLength == 4) {
          if (mYear.length < 4) {
            alert("Data Inválida!");
            vDateName.value = "";
            vDateName.focus();
            return true;
          }
        }

        var vDateTypeTemp = vDateType;

        vDateType = 1;

        var vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;

        if (mYear.length == 2 && vYearType == 4 && dateCheck) {
          var mToday = new Date();

          var checkYear = mToday.getFullYear() + 30;
          var mCheckYear = '20' + mYear;
          if (mCheckYear >= checkYear)
            mYear = '19' + mYear;
          else
            mYear = '20' + mYear;
          vDateValueCheck = mMonth+strSeperator+mDay+strSeperator+mYear;
          if (vDateTypeTemp == 1) // mm/dd/yyyy
            vDateName.value = mMonth+strSeperator+mDay+strSeperator+mYear;
          if (vDateTypeTemp == 3) // dd/mm/yyyy
            vDateName.value = mDay+strSeperator+mMonth+strSeperator+mYear;
        }

        if (!dateValid(vDateValueCheck)) {
          alert("Data Inválida!");
          vDateType = vDateTypeTemp;
          vDateName.value = "";
          vDateName.focus();
          return true;
        }

        vDateType = vDateTypeTemp;
        return true;
      }
      else {
        if (vDateType == 1) {
          if (vDateValue.length == 2) {
            vDateName.value = vDateValue+strSeperator;
          }
          if (vDateValue.length == 5) {
            vDateName.value = vDateValue+strSeperator;
           }
        }
        if (vDateType == 2) {
          if (vDateValue.length == 4) {
            vDateName.value = vDateValue+strSeperator;
          }
          if (vDateValue.length == 7) {
            vDateName.value = vDateValue+strSeperator;
          }
        }
        if (vDateType == 3) {
          if (vDateValue.length == 2) {
            vDateName.value = vDateValue+strSeperator;
          }
          if (vDateValue.length == 5) {
            vDateName.value = vDateValue+strSeperator;
          }
        }
        return true;
      }
    }

    if (vDateValue.length == 10&& dateCheck) {
      if (!dateValid(vDateName)) {
        alert("Data Inválida!");
        vDateName.focus();
        vDateName.select();
      }
    }
    return false;
    }
    else {
      if (isNav4) {
        vDateName.value = "";
        vDateName.focus();
        vDateName.select();
        return false;
      }
      else {
        vDateName.value = vDateName.value.substr(0, (vDateValue.length-1));
        return false;
      }
    }
  }
}


function dateValid(objName) {
  var strDate;
  var strDateArray;
  var strDay;
  var strMonth;
  var strYear;
  var intday;
  var intMonth;
  var intYear;
  var booFound = false;
  var datefield = objName;
  var strSeparatorArray = new Array("-"," ","/",".");
  var intElementNr;

  var strMonthArray = new Array(12);

  strMonthArray[0] = "Jan";
  strMonthArray[1] = "Feb";
  strMonthArray[2] = "Mar";
  strMonthArray[3] = "Apr";
  strMonthArray[4] = "May";
  strMonthArray[5] = "Jun";
  strMonthArray[6] = "Jul";
  strMonthArray[7] = "Aug";
  strMonthArray[8] = "Sep";
  strMonthArray[9] = "Oct";
  strMonthArray[10] = "Nov";
  strMonthArray[11] = "Dec";

  strDate = objName;
  if (strDate.length < 1) {
    return true;
  }

  for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
    if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
      strDateArray = strDate.split(strSeparatorArray[intElementNr]);
      if (strDateArray.length != 3) {
        err = 1;
        return false;
      }
      else {
        strDay = strDateArray[0];
        strMonth = strDateArray[1];
        strYear = strDateArray[2];
      }
      booFound = true;
    }
  }

  if (booFound == false) {
    if (strDate.length>5) {
      strDay = strDate.substr(0, 2);
      strMonth = strDate.substr(2, 2);
      strYear = strDate.substr(4);
   }
  }

  if (strYear.length == 2) {
    strYear = '20' + strYear;
  }

  strTemp = strDay;
  strDay = strMonth;
  strMonth = strTemp;
  intday = parseInt(strDay, 10);
  if (isNaN(intday)) {
    err = 2;
    return false;
  }

  intMonth = parseInt(strMonth, 10);

  if (isNaN(intMonth)) {
    for (i = 0;i<12;i++) {
      if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
        intMonth = i+1;
        strMonth = strMonthArray[i];
        i = 12;
      }
    }
    if (isNaN(intMonth)) {
      err = 3;
      return false;
    }
  }

  intYear = parseInt(strYear, 10);
  if (isNaN(intYear)) {
    err = 4;
    return false;
  }

  if (intMonth>12 || intMonth<1) {
    err = 5;
    return false;
  }

  if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
    err = 6;
    return false;
  }

  if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
    err = 7;
    return false;
  }

  if (intMonth == 2) {
    if (intday < 1) {
      err = 8;
      return false;
    }
    if (LeapYear(intYear) == true) {
      if (intday > 29) {
        err = 9;
        return false;
      }
    }
  else {
    if (intday > 28) {
    err = 10;
    return false;
  }
}
}
return true;
}

function LeapYear(intYear) {
  if (intYear % 100 == 0) {
    if (intYear % 400 == 0) { return true; }
  }
  else {
    if ((intYear % 4) == 0) { return true; }
  }
  return false;
}

function fJS_ChecaCampo(ini,formulario) {
	var campovazio = true;
	numcampos = formulario.length - 1;
	for (i = ini; i < numcampos; i++) {
		var tempobj = formulario.elements[i];
		if (tempobj.value != '') {
			campovazio = false;
			break;
        }
 	}
	if (campovazio == true)
		alert('É necessário preencher os campos para consulta!');
	else
		formulario.submit();
}

function fJS_ValidaHora(sCampo) {
	sValorTxt = sCampo.value;
	if ((sValorTxt.substr(0,2) > 23) || (sValorTxt.substr(3,2) > 59)) {
		alert("Hora inválida! Digite novamente!");
		sCampo.focus();
		sCampo.value = "";
	}
}

function fJS_FormataHora(sCampo,iTamMax,iPosTraco,tTeclaPres){
	if (event.keyCode < 48 || event.keyCode > 57) event.returnValue=false;

	var iTecla, sValorTxt, iTam;

 	iTecla = tTeclaPres.keyCode;
 	sValorTxt = sCampo.value;
 	sValorTxt = sValorTxt.toString().replace( ":", "" );
 	iTam = sValorTxt.length ;

 	if (iTam < iTamMax && iTecla != 8) {
  	iTam = sValorTxt.length + 1 ;
 	}

 	if (iTecla == 8 ) {
  	iTam = iTam - 1 ;
 	}

 	if ( iTecla == 8 || iTecla == 88 || iTecla >= 48 && iTecla <= 57 || iTecla >= 96 && iTecla <= 105 ){
  	if ( iTam <= 2 ){
    	sCampo.value = sValorTxt ;
  	}
  	if (iTam > iPosTraco && iTam <= iTamMax) {
    	sValorTxt = sValorTxt.substr(0, iTam - iPosTraco) + ':' + sValorTxt.substr(iTam - iPosTraco, iTam);
  	}
  	sCampo.value = sValorTxt;

		if(sCampo.value.length==sCampo.maxLength){
    	for(var i=0;i<sCampo.form.length;i++){
      	if(sCampo.form[i]==sCampo){sCampo.form[i+1].focus();break}
      }
    }
	}
}

function fJS_CheckaTodos(formulario) {
  for (i=0; i<formulario.length; i++) {
      if (formulario.elements[i].type=="checkbox")
        if (formulario.oSA.checked)
            formulario.elements[i].checked = true
        else
            formulario.elements[i].checked = false
  }
}

function fJS_IdentificaNavegador() {
	var navegador;
		//
	if (document.layers)
		navegador = "nc";
	else {
		if (document.all)
			navegador = "ie";
		else {
			if (document.getElementById)
				navegador = "n6";
			else
				navegador = "não identificado!";
		}
	}
		//
	return navegador;
}

function fJS_Foco(sCampo) {
	var j = 0;
	var i = 0;
	var sForm = document.forms[0];

	if ((sForm != "undefined") && (sForm.elements.length > 0)) {
		if (sCampo != "") {
			sCampo.focus();
		}
		else {
			while (j != 1) {
				if (i == sForm.elements.length) break;
				if ((sForm.elements[i].type != "hidden") && (!sForm.elements[i].disabled) && (sForm.elements[i].name != "codigo")) {
					sForm.elements[i].focus();
					j = 1;
				}
				i++;
			}
		}
	}
}

function fJS_Erro() {
	alert("Erro ao executar um comando javascript\nContate os desenvolvedores: web.tecnico@ecp.com.br");
  return true;
}

function fJS_ConverteValorMoeda(num, iTipo) {
	if (iTipo==1) {
		if(isNaN(num))
			num = "0";

		sign 	= (num == (num = Math.abs(num)));
		num 	= Math.floor(num*100+0.50000000001);
		cents = num%100;
		num 	= Math.floor(num/100).toString();
		if(cents<10)
			cents = "0" + cents;

		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
			num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));

		return (((sign)?'':'-') + num + ',' + cents);
	}
	else {
		for (i=0; i<=num.length; i++) {
			num = num.replace('.', '');
		}
		num = num.replace(',','.');
		num = parseFloat(num);
		num ? num : num = 0;

		return num;
	}
}

function fJS_LimiteTextarea(oCampo, iMax, iCont) {
	if (oCampo.value.length > iMax) {
		alert('Esse campo não pode conter mais que '+iMax+' caracteres!');
		oCampo.value = oCampo.value.substr(0, iMax);
		oCampo.focus();
	}
	if (iCont == 1) {
		oForm 			= oCampo.form;
		oCampoCont	= eval('oForm.cont_'+oCampo.name+'');
			//
		oCampoCont.value = iMax - oCampo.value.length;
	}
}

function fJS_Modulo(iNumero) {
	if (iNumero >= 0)
		return iNumero;
	else
		return -iNumero;
}

function fJS_SomenteNumeros(e){
var keynum;

    if(window.event) { // IE
      keynum = e.keyCode;
    }
    else if(e.which) { // Netscape/Firefox/Opera
      keynum = e.which;
    }

    //alert(keynum);
    
    if ((keynum < 48 || keynum > 57) && keynum != 8){
        return false
    }
    else {
        return true
    }
        

}

function fJS_RetornaMunicipios(oForm) {
	oForm.action = '';
	oForm.target = '';
	oForm.icogemunic.value = 1;
	oForm.submit();
}

function fJS_BloqueiaGravacao() {
	Gravou = true;
	HideLayer('gravar');
	ShowLayer('gravar_d');
}

function fJS_LiberaGravacao() {
	Gravou = false;
	HideLayer('gravar_d');
	ShowLayer('gravar');
}

var NS4 = (document.layers) ? true : false;
var IE4 = (document.all) ? true : false;
var NS4MAC = NS4 && (navigator.appVersion.indexOf("Macintosh") > -1);
var size = 8;
var active = false;
var style = 1;

function update() {
  if ((!NS4 && !IE4) || NS4MAC) return;
  var form = document.organizer;
  var field = form.prefix;
  var list = form.list;
  field.value = list.options[list.selectedIndex].text;
}

function select(list, i) {
  if (list.selectedIndex != i) list.selectedIndex = i;
}

function fJS_CheckKey(pForm, pCampo, pSelect) {
  if (!active) return;
  var form = pForm;
  var field = pForm[pCampo];
  var list = pForm[pSelect];
  var str = field.value.toLowerCase();
  if (str == "") {
    select(list, 0);
    return;
  }
  for (var i = 0; i < list.options.length; ++i) {
    if (list.options[i].text.toLowerCase().indexOf(str) == 0) {
      select(list, i);
      return;
    }
  }
  if (style == 1) {
    for (i = list.options.length - 1; i >= 0; --i) {
      if (str > list.options[i].text.toLowerCase()) {
        select(list, i);
        return;
      }
    }
    select(list, 0);
  }
}

var toFind = "";
var timeoutID = "";

timeoutInterval = 5000;

var timeoutCtr = 0;
var timeoutCtrLimit = 3;

var oControl = "";


function fJS_Lookup_onkeypress(){
   window.clearInterval(timeoutID)
   oControl = window.event.srcElement;
   var keycode = window.event.keyCode;
	 if(keycode == 27) {
	 		oControl.selectedIndex = '';
			fJS_Lookup_onblur();
	 }
	 if(keycode >= 32 ){
       var c = String.fromCharCode(keycode);
       c = c.toUpperCase();
       toFind += c ;
       find();
       timeoutID = window.setInterval("idle()", timeoutInterval);
		}
	}

function fJS_Lookup_onblur(){
	 window.clearInterval(timeoutID);
   resetToFind();
}

function idle(){
   timeoutCtr += 1
   if(timeoutCtr > timeoutCtrLimit){
      resetToFind();
      timeoutCtr = 0;
      window.clearInterval(timeoutID);
   }
}

function resetToFind(){
   toFind = "";
}

function find(){
    var allOptions = document.all.item(oControl.name);
    for (i=0; i < allOptions.length; i++){
       nextOptionText = allOptions(i).text.toUpperCase();
       if(!isNaN(nextOptionText) && !isNaN(toFind) ){
              nextOptionText *= 1;
              toFind *= 1;
       }
        if(toFind == nextOptionText){
            oControl.selectedIndex = i;
            window.event.returnValue = false;
            break;
        }
        if(i < allOptions.length-1){
           lookAheadOptionText = allOptions(i+1).text.toUpperCase() ;
					 if(toFind < lookAheadOptionText){
              oControl.selectedIndex = i+1;
              window.event.cancelBubble = true;
              window.event.returnValue = false;
              break;
           }
        }
        else{
           if(toFind > nextOptionText){
               oControl.selectedIndex = allOptions.length-1

               window.event.cancelBubble = true;
               window.event.returnValue = false;
               break;
           }
       }
    }
}

var netscape = (navigator.appName.indexOf("Netscape") >= 0 && parseFloat(navigator.appVersion) >= 4) ? true : false;
var explorer = (document.all) ? true : false;
var ns6 = (document.getElementById && !document.all) ? true : false;
function ShowLayer(layer) {
	if(ns6){
		document.getElementById([layer]).style.visibility = "visible";
		document.getElementById([layer]).style.position = 'nome';
		return ;
	}
	if (netscape) {
		document[layer].visibility = "show";
		document[layer].position = "";
		return ;
	}
	if (explorer) {
		document.all[layer].style.visibility = "visible";
		document.all[layer].style.position = "";
		return ;
	}
	}

function ShowLayer_2(layer) {
	if(ns6){
		document.getElementById([layer]).style.visibility = "visible";
		document.getElementById([layer]).style.position = 'nome';
		return ;
	}
	if (netscape) {
		document[layer].visibility = "show";
		document[layer].position = "";
		return ;
	}
	if (explorer) {
		document.all[layer].style.visibility = "visible";
		document.all[layer].style.position = "absolute";
		return ;
	}
}

function HideLayer(layer) {
	if(ns6){
		document.getElementById([layer]).style.visibility = "hidden";
		document.getElementById([layer]).style.position = "absolute";
		return ;
	}
	if (netscape) {
		document[layer].visibility = "hide";
		document[layer].position = "absolute";
		return ;
	}
	if (explorer) {
		document.all[layer].style.visibility = "hidden";
		document.all[layer].style.position = "absolute";
		return ;
	}
}

function fMostra(oForm, sNomeLayer, sNomeSubLayer){
			if (!sNomeLayer) return false;
			oForm = eval(oForm);
			Desabilita = oForm.sLayer.value;
      SubDesabilita = oForm.sSubLayer.value;
      oForm.sLayer.value = sNomeLayer;
      HideLayer(Desabilita);
      ShowLayer(sNomeLayer);
			if (SubDesabilita) HideLayer(SubDesabilita);
      if (sNomeSubLayer) {
          oForm.sSubLayer.value = sNomeSubLayer;
          HideLayer(SubDesabilita);
          ShowLayer(sNomeSubLayer);
      }
      return;
}

function setDataType(cValue)
  {
    var isDate = new Date(cValue);
    if (isDate == "NaN")
      {
        if (isNaN(cValue))
          {
            cValue = cValue.toUpperCase();
            return cValue;
          }
        else
          {
            var myNum;
            myNum = String.fromCharCode(48 + cValue.length) + cValue;
            return myNum;
          }
        }
  else
      {
        var myDate = new String();
        myDate = isDate.getFullYear() + " " ;
        myDate = myDate + isDate.getMonth() + " ";
        myDate = myDate + isDate.getDate(); + " ";
        myDate = myDate + isDate.getHours(); + " ";
        myDate = myDate + isDate.getMinutes(); + " ";
        myDate = myDate + isDate.getSeconds();
        return myDate ;
      }
  }
function sortTable(col, tableToSort)
  {
		var iCurCell = col + tableToSort.cols;
    var totalRows = tableToSort.rows.length;
    var bSort = 0;
    var colArray = new Array();
    var oldIndex = new Array();
    var indexArray = new Array();
    var bArray = new Array();
    var newRow;
    var newCell;
    var i;
    var c;
    var j;

    for (i=1; i < tableToSort.rows.length; i++)
      {
        colArray[i - 1] = setDataType(tableToSort.cells(iCurCell).innerText);
        iCurCell = iCurCell + tableToSort.cols;
      }
    for (i=0; i < colArray.length; i++)
      {
        bArray[i] = colArray[i];
      }
    colArray.sort();
    for (i=0; i < colArray.length; i++)
      {
        indexArray[i] = (i+1);
        for(j=0; j < bArray.length; j++)
          {
            if (colArray[i] == bArray[j])
              {
                for (c=0; c<i; c++)
                  {
                    if ( oldIndex[c] == (j+1) )
                    {
                      bSort = 1;
                    }
                      }
                      if (bSort == 0)
                        {
                          oldIndex[i] = (j+1);
                        }
                          bSort = 0;
                        }
          }
    }
  for (i=0; i<oldIndex.length; i++)
    {
      newRow = tableToSort.insertRow();
      for (c=0; c<tableToSort.cols; c++)
        {
          newCell = newRow.insertCell();
					newCell.noWrap = true;
          newCell.innerHTML = tableToSort.rows(oldIndex[i]).cells(c).innerHTML;
        }
      }
  for (i=1; i<totalRows; i++)
    {
      tableToSort.moveRow((tableToSort.rows.length -1),1);
    }
  for (i=1; i<totalRows; i++)
    {
      tableToSort.deleteRow();
    }
  }

function str_split ( f_string, f_split_length){
    // Convert a string to an array. If split_length is specified, break the string down into chunks each split_length characters long.
    //
    // version: 905.3122
    // discuss at: http://phpjs.org/functions/str_split
    // +     original by: Martijn Wieringa
    // +     improved by: Brett Zamir (http://brett-zamir.me)
    // +     bugfixed by: Onno Marsman
    // *         example 1: str_split('Hello Friend', 3);
    // *         returns 1: ['Hel', 'lo ', 'Fri', 'end']
    f_string += '';

    if (f_split_length == undefined) {
        f_split_length = 1;
    }
    if(f_split_length > 0){
        var result = [];
        while(f_string.length > f_split_length) {
            result[result.length] = f_string.substring(0, f_split_length);
            f_string = f_string.substring(f_split_length);
        }
        result[result.length] = f_string;
        return result;
    }
    return false;
}

