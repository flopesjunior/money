<?

### Funções de geração de objetos HTML
function fButton($aParametros) {
	if ($aParametros["disabled"] != 1) unset($aParametros["disabled"]);
		//
	$sRetorno = "<input type=button class=oButton";
	foreach ($aParametros as $sName => $sValue)
		$sRetorno .= " $sName='".$sValue."' ";

	$sRetorno .= ">";
		//
	return $sRetorno;
}

function fCheckbox($aParametros) {
	if ($aParametros["disabled"] != 1) unset($aParametros["disabled"]);
		//
	$sRetorno = "<input class=oCheckbox type=checkbox";
	foreach ($aParametros as $sName => $sValue)
		if ($sName != "checked")
			$sRetorno .= " $sName='".$sValue."' ";

	if ($aParametros["value"] == $aParametros["checked"]) $sRetorno .= " checked>";
	else $sRetorno .= ">";
		//
	return $sRetorno;
}

function fRadio($aParametros) {
	if ($aParametros["disabled"] != 1) unset($aParametros["disabled"]);
		//
	$sRetorno = "<input type=radio";
	foreach ($aParametros as $sName => $sValue)
		if ($sName != "checked")
			$sRetorno .= " $sName='".$sValue."' ";

	if ($aParametros["value"] == $aParametros["checked"]) $sRetorno .= " checked>";
	else $sRetorno .= ">";
		//
	return $sRetorno;
}

function fFile($aParametros) {
	if ($aParametros["disabled"] != 1) unset($aParametros["disabled"]);
		//
   $sRetorno =  "<input class=oText type=file ";
	foreach ($aParametros as $sName => $sValue)
		$sRetorno .= " $sName='".$sValue."' ";

	$sRetorno .= ">";
			//
	return $sRetorno;
}

function fText($aParametros) {
	global $sCampoChave;

	$sRetorno =  "<input ";

	$sRetorno .= $aParametros["password"] ? " type=password" : "type=text";

	### Remove o excesso de espaços no campo. Quando necessária, essa variável deve ser colocada no evento onBlur
   $sRemoveEspacos = "fJS_RemoveEspacos(this); return false;";
			//
	if ($aParametros["name"] == $sCampoChave) {
		$aParametros["onfocusin"]	.= "fJS_BloqueiaGravacao();";
		$aParametros["onchange"] 	.= "setTimeout(fJS_BloqueiaGravacao, 1);";

		$OnBlur .= $aParametros["onblur"] .= "fJS_LiberaGravacao();";
	}
	else $OnBlur = $aParametros["onblur"];
		//
	$OnKeyPress = $aParametros["onkeypress"];
	if (isset($aParametros["formato"]) && $aParametros["formato"] != "remove_espacos") unset($aParametros["onkeypress"]);
   //if (!$aParametros["formato"]) $sRetorno .= " OnKeyPress=\"return fJS_TextoMaiusculo();\" ";

	### Passa o foco para o próximo campo quando o tamanho do valor digitado atinge o maxlength
//	$aParametros["onkeyup"] .= "if (this.value.length == this.maxLength) fTabNext(this);";

	foreach ($aParametros as $sNome => $sValor) {
      if ($sNome == "formato") {
			switch ($sValor) {
	         case "cep":   	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataCEP(this,8,3,event);\" "; break;
			 case "cpf":   	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataCPF_CGC(this.form,this.name,11,8,5,0,2,event);\" onBlur=\"".$OnBlur."fJS_ValidaCPF(this.form,this.name,this.value);\""; break;
			 case "cnpj":  	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataCPF_CGC(this.form,this.name,15,12,9,6,2,event);\" onBlur=\"".$OnBlur."fJS_ValidaCNPJ(this.form,this.name,this.value);\""; break;
	         case "data":  	$sRetorno .= " onFocus=\"javascript:".$OnFocus."vDateType='3'\" onKeyPress=\"".$OnKeyPress."fJS_FormataData(this,this.value,event,false,'3')\" onBlur=\"".$OnBlur."fJS_FormataData(this,this.value,event,true,'3')\" "; break;
	         case "fone":  	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataFone(this);\""; break;
	         case "login":	$sRetorno .= " onKeyPress=\"".$OnKeyPress."return fJS_TextoMinusculo();\" "; break;
			 case "moeda":	$sRetorno .= " onKeyPress=\"".$OnKeyPress."if (event.keyCode < 48 || event.keyCode > 57) event.returnValue=false; return(fJS_FormataMoeda(this, '.' , ',' , ".$aParametros["nc"]."));\" "; break;
			 case "hora":	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataHora(this,4,2,event);\" onBlur=\"".$OnBlur."fJS_ValidaHora(this)\" "; break;
	         case "somente_maiuscula": $sRetorno .= " onKeyPress=\"".$OnKeyPress."return fJS_TextoMaiusculo();\" "; break;
//	         case "somente_numeros":   $sRetorno .= " onKeyPress=\"".$OnKeyPress."if (event.keyCode < 48 || event.keyCode > 57) event.returnValue=false;\" "; break;
	         case "somente_numeros":   $sRetorno .= " onKeyPress=\"return fJS_SomenteNumeros(event);\" "; break;
	         case "desab_espaco":      $sRetorno .= " onKeyPress=\"".$OnKeyPress."if (event.keyCode == 32) event.returnValue=false;\" "; break;
	         case "remove_espacos":    $sRetorno .= " onKeyPress=\"return fJS_TextoMaiusculo();\" onBlur=\"".$OnBlur.$sRemoveEspacos."\" "; break;

			}
		}
		elseif ($sNome == "readonly") {
			if ($sValor == 1) $sRetorno .= " readonly ";
		}
		elseif ($sNome == "disabled") {
			if ($sValor == 1) $sRetorno .= " disabled ";
		}
		elseif ($sNome == "classe") {
            if ($aParametros["classe"]) $sRetorno .= " class=".$aParametros["classe"];
            else $sRetorno .= " class=oText";
		}
		else $sRetorno .= " $sNome='".$sValor."'";
	}

    if (trim($aParametros["classe"])=="") $sRetorno .= " class=oText ";

	$sRetorno .= ">";

		//
	return $sRetorno;
}

function fText2($aParametros) {
	global $sCampoChave;

	$sRetorno =  "<input class=oText2 ";
	$sRetorno .= $aParametros["password"] ? " type=password" : "type=text";

	### Remove o excesso de espaços no campo. Quando necessária, essa variável deve ser colocada no evento onBlur
   $sRemoveEspacos = "fJS_RemoveEspacos(this); return false;";
			//
	if ($aParametros["name"] == $sCampoChave) {
		$aParametros["onfocusin"]	.= "fJS_BloqueiaGravacao();";
		$aParametros["onchange"] 	.= "setTimeout(fJS_BloqueiaGravacao, 1);";

		$OnBlur .= $aParametros["onblur"] .= "fJS_LiberaGravacao();";
	}
	else $OnBlur = $aParametros["onblur"];
		//
	$OnKeyPress = $aParametros["onkeypress"];
	if (isset($aParametros["formato"]) && $aParametros["formato"] != "remove_espacos") unset($aParametros["onkeypress"]);
   if (!$aParametros["formato"]) $sRetorno .= " OnKeyPress=\"return fJS_TextoMaiusculo();\" ";

	### Passa o foco para o próximo campo quando o tamanho do valor digitado atinge o maxlength
//	$aParametros["onkeyup"] .= "if (this.value.length == this.maxLength) fTabNext(this);";

	foreach ($aParametros as $sNome => $sValor) {
      if ($sNome == "formato") {
			switch ($sValor) {
	         case "cep":   	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataCEP(this,8,3,event);\" "; break;
				case "cpf":   	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataCPF_CGC(this.form,this.name,11,8,5,0,2,event);\" onBlur=\"".$OnBlur."fJS_ValidaCPF(this.form,this.name,this.value);\""; break;
				case "cnpj":  	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataCPF_CGC(this.form,this.name,15,12,9,6,2,event);\" onBlur=\"".$OnBlur."fJS_ValidaCNPJ(this.form,this.name,this.value);\""; break;
	         case "data":  	$sRetorno .= " onFocus=\"javascript:".$OnFocus."vDateType='3'\" onKeyPress=\"".$OnKeyPress."fJS_FormataData(this,this.value,event,false,'3')\" onBlur=\"".$OnBlur."fJS_FormataData(this,this.value,event,true,'3')\" "; break;
	         case "fone":  	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataFone(this);\""; break;
	         case "login":	$sRetorno .= " onKeyPress=\"".$OnKeyPress."return fJS_TextoMinusculo();\" "; break;
				case "moeda":	$sRetorno .= " onKeyPress=\"".$OnKeyPress."if (this.value.length >= this.maxLength) return false; if (event.keyCode < 48 || event.keyCode > 57) return false; return(fJS_FormataMoeda(this, '.' , ',' , ".$aParametros["nc"]."));\" onBlur=\"".$OnBlur."if (this.value != '' && this.value.substring(this.value.indexOf(',')).length - 1 != ".$aParametros["nc"].") {this.value = ''; alert('Valor inválido!\\nO campo deve conter ".$aParametros["nc"]." dígitos após a vírgula.\\nDigite novamente.');this.focus();}\" "; break;
				case "hora":	$sRetorno .= " onKeyPress=\"".$OnKeyPress."fJS_FormataHora(this,4,2,event);\" onBlur=\"".$OnBlur."fJS_ValidaHora(this)\" "; break;
	         case "somente_maiuscula": $sRetorno .= " onKeyPress=\"".$OnKeyPress."return fJS_TextoMaiusculo();\" "; break;
	         case "somente_numeros":   $sRetorno .= " onKeyPress=\"".$OnKeyPress."if (event.keyCode < 48 || event.keyCode > 57) event.returnValue=false;\" "; break;
	         case "desab_espaco":      $sRetorno .= " onKeyPress=\"".$OnKeyPress."if (event.keyCode == 32) event.returnValue=false;\" "; break;
	         case "remove_espacos":    $sRetorno .= " onKeyPress=\"return fJS_TextoMaiusculo();\" onBlur=\"".$OnBlur.$sRemoveEspacos."\" "; break;
			}
		}
		if ($sNome == "readonly") {
			if ($sValor == 1) $sRetorno .= " readonly ";
		}
		elseif ($sNome == "disabled") {
			if ($sValor == 1) $sRetorno .= " disabled ";
		}
		else $sRetorno .= " $sNome='".$sValor."'";


	}
	$sRetorno .= ">";
		//
	return $sRetorno;
}

function fTextArea($aParametros) {
	global $sUrlImagens;
	global $sUrlRaiz;
	global $sFuncao;
	global $TextEscCadastro;
		//
	if ($aParametros["disabled"] != 1) unset($aParametros["disabled"]);
		//
	$sRetorno =  "<textarea class=oText ";
	foreach ($aParametros as $sName => $sValue) {
      if ($sName == "formato")
         if ($sValue == "somente_maiuscula") $sRetorno .= " onKeyPress=\"return fJS_TextoMaiusculo();\" ";

		if ($sName == "readonly")
			if ($sValue == 1) $sRetorno .= " readonly";

		if ($sName != "value" && $sName != "disabled")
			$sRetorno .= " $sName='".$sValue."' ";
	}
	$sRetorno .= ">".$aParametros["value"]."</textarea>";

	if ($aParametros["corretor"])
		$sRetorno .= "<p align=right>".
						 "<a href=# onClick=\"fAbreJanela('".$sUrlRaiz."/pkg/gecorretor.php?sForm=".$sFuncao."&sCampo=".$aParametros["name"]."','gecorretor','241','218','no','yes','center');\" title=\"Verificar Ortografia\">".
						 "<img src=".$sUrlImagens."/ortografia.gif border=0 alt='Verificar Ortografia' border=0 align='absmiddle'>".
               	 "<font face=verdana size=2 color=".$TextEscCadastro.">Verificar Ortografia</font>".
						 "</a></p>";
		//
	return $sRetorno;
}

function fSelect($aParametros) {
   global $oSelect;
   global $HTTP_SERVER_VARS;
   global $sUrlImagens;
      //
   $SelectReduzido = substr($oSelect,9,strlen($oSelect)-9);
   if ($aParametros['size']) {
         if (strpos($HTTP_SERVER_VARS["HTTP_USER_AGENT"],"Netscape")) {
              $SelectReduzido = substr(trim($SelectReduzido),1,-1)." width:".$aParametros['size']."px; overflow:hidden;}";
              $sStyle = "style=\"$SelectReduzido\"";
         }
         else {
            $iDiv=1;
            $sStyle = "class=oSelect";
         }
   }
   else $sStyle = "class=oSelect";
   if ($aParametros['posicao']) $sPosicao = " position=".$aParametros['posicao']."; ";
   if ($iDiv) $sRetorno .= "<div style=\"".$sPosicao."overflow:hidden; border:0px solid; width=".$aParametros['size']."px;\">";
	$sRetorno .= "<select $sStyle id=".$aParametros['name']." name=".$aParametros['name']." onChange=".$aParametros['onchange']."; onBlur=fJS_Lookup_onblur();".$aParametros['onblur']."; onKeyPress=\"fJS_Lookup_onkeypress()\"; ";
	if ($aParametros['disabled']) $sRetorno .= " disabled";
	$sRetorno .= ">";
	$sRetorno .= "<option class=oSelectSelecione value=''>".str_repeat("&nbsp;", 10)."</option>";
	if (isset($aParametros['sql'])) {
		while(!$aParametros['sql']->EOF) {

			if ($aParametros['selected'] == $aParametros['sql']->fields['value']) {
				 $sSelected = "selected";
			}
			else {
				$sSelected = "";
			}

			$iStatus2 = $aParametros['sql']->fields['status2'];

			if (!$iStatus2) $iStatus2 = 1;

			if ($aParametros['sql']->fields['status'] != 1 || $iStatus2 != 1) {
//				$sEstilo = "class=oSelectDesabilitado";
				$sEstilo = "";

			}
			else	{
				$sEstilo = "";
			}

			$sRetorno .= "<OPTION $sEstilo VALUE='".$aParametros['sql']->fields['value']."' ".$sSel." ".$sSelected.">" .$aParametros['sql']->fields['name']."</OPTION>";

			$aParametros['sql']->MoveNext();
		}
	}
	else {
		foreach ($aParametros['opcoes'] as $sText => $sValue) {
			if ($aParametros['selected'] == $sValue) $sSelected = "selected";
			else unset($sSelected);
			$sRetorno .= "<option value='$sValue' $sSelected>$sText</option>";
		}
	}
	$sRetorno .= "</select>";
   if ($iDiv) $sRetorno .= "</div>";
      //
	return $sRetorno;
}

function fSelect2($aParametros) {
   global $oSelect;
   global $HTTP_SERVER_VARS;
   global $sUrlImagens;
      //
   $SelectReduzido = substr($oSelect,9,strlen($oSelect)-9);
   if ($aParametros['size']) {
         if (strpos($HTTP_SERVER_VARS["HTTP_USER_AGENT"],"Netscape")) {
              $SelectReduzido = substr(trim($SelectReduzido),1,-1)." width:".$aParametros['size']."px; overflow:hidden;}";
              $sStyle = "style=\"$SelectReduzido\"";
         }
         else {
            $iDiv=1;
            $sStyle = "class=oSelect2";
         }
   }
   else $sStyle = "class=oSelect2";
   if ($aParametros['posicao']) $sPosicao = " position=".$aParametros['posicao']."; ";
   if ($iDiv) $sRetorno .= "<div style=\"".$sPosicao."overflow:hidden; border:0px solid; width=".$aParametros['size']."px;\">";
	$sRetorno .= "<select $sStyle id=".$aParametros['name']." name=".$aParametros['name']." onChange=".$aParametros['onchange']."; onBlur=fJS_Lookup_onblur();".$aParametros['onblur']."; onKeyPress=\"fJS_Lookup_onkeypress()\"; ";
	if ($aParametros['disabled']) $sRetorno .= " disabled";
	$sRetorno .= ">";
	$sRetorno .= "<option class=oSelectSelecione value=''>".str_repeat("&nbsp;", 10)."</option>";
	if (isset($aParametros['sql'])) {
		while(!$aParametros['sql']->EOF) {

			if ($aParametros['selected'] == $aParametros['sql']->fields['value']) {
				 $sSelected = "selected";
			}
			else {
				$sSelected = "";
			}

			$iStatus2 = $aParametros['sql']->fields['status2'];

			if (!$iStatus2) $iStatus2 = 1;

			if ($aParametros['sql']->fields['status'] != 1 || $iStatus2 != 1) {
//				$sEstilo = "class=oSelectDesabilitado";
				$sEstilo = "";

			}
			else	{
				$sEstilo = "";
			}

			$sRetorno .= "<OPTION $sEstilo VALUE='".$aParametros['sql']->fields['value']."' ".$sSel." ".$sSelected.">" .$aParametros['sql']->fields['name']."</OPTION>";

			$aParametros['sql']->MoveNext();
		}
	}
	else {
		foreach ($aParametros['opcoes'] as $sText => $sValue) {
			if ($aParametros['selected'] == $sValue) $sSelected = "selected";
			else unset($sSelected);
			$sRetorno .= "<option value='$sValue' $sSelected>$sText</option>";
		}
	}
	$sRetorno .= "</select>";
   if ($iDiv) $sRetorno .= "</div>";
      //
	return $sRetorno;
}


function fLista($aParametros) {
	$aParametros['onchange'] ? $onchange = "onChange=".$aParametros['onchange'] : $onchange = "";
	$aParametros['ondblclick'] ? $ondblclick = "onDblClick=".$aParametros['ondblclick'] : $ondblclick = "";
	$aParametros['multiplo'] ? $multiplo = "multiple" : $multiplo = "";
	$aParametros['disabled'] ? $disabled = "disabled" : $disabled = "";
		//
//   $sRetorno .= "<select $sStyle NAME=".$aParametros['name']." onChange=".$aParametros['onchange']."; onKeyPress=\"fJS_Lookup_onkeypress()\"; onBlur=".$aParametros['onblur'].";\"fJS_Lookup_onblur()\"; ";
	$sRetorno = "<select class=oSelect name=".$aParametros['name']." size=".$aParametros['size']." ".$ondblclick." ".$onchange." onKeyPress=\"fJS_Lookup_onkeypress()\"; onBlur=\"fJS_Lookup_onblur()\"; ".$multiplo." ".$disabled.">";
	if ($aParametros['sql']) {
		while(!$aParametros['sql']->EOF) {
			$sRetorno .= "<option value='".$aParametros['sql']->fields['value']."' ".$sSel.">" .$aParametros['sql']->fields['name']."</option>";
			$aParametros['sql']->MoveNext();
		}
	}
	if ($aParametros['opcoes']) {
		foreach ($aParametros['opcoes'] as $sValue => $sText) {
			if ($aParametros['selected'] == $sValue) $sSelected = "selected";
			else unset($sSelected);
			$sRetorno .= "<option value='$sValue' $sSelected>$sText</option>";
		}
	}

	$sRetorno .= "</select>";
		//
	return $sRetorno;
}

function fListaDupla($aParametros) {
	global $TextClaPaginaCadastro;
		//
	if ($aParametros['sql_2']) {
		while (!$aParametros['sql_2']->EOF) {
			$oHidden ? $oHidden .= ";".$aParametros['sql_2']->fields['value'] : $oHidden = $aParametros['sql_2']->fields['value'];
			$aParametros['sql_2']->MoveNext();
		}
		$aParametros['sql_2']->MoveFirst();
	}
		//
	$sRetorno = "
			<script>
			function fJS_".$aParametros['name']."(oForm,oOrigem,oDestino) {
					// transporta o valor da origem para o destino
				iLenoOrigem = oOrigem.options.length;
				iLenoDestino = oDestino.options.length;
				for(iI=(iLenoOrigem-1); iI>=0; iI--) {
					if ((oOrigem.options[iI] != null) && (oOrigem.options[iI].selected == true) && (oOrigem.options[iI].text != '') && (oOrigem.options[iI].value != '')) {
						oDestino.options[iLenoDestino] = new Option(oOrigem.options[iI].text,oOrigem.options[iI].value);
						oOrigem.options[iI] = null;
					}
				}
					// arruma o valor do hidden de acordo com os valores do oDestino
				oHidden = eval('oForm.".$aParametros['name']."');
				oHidden.value = '';
				oLista = eval('oForm.".$aParametros['name']."lista_2');
				iLenoLista = oLista.options.length;
				for(iI=(iLenoLista-1); iI>=0; iI--) {
					if ((oLista.options[iI] != null) && (oLista.options[iI].text != '') && (oLista.options[iI].value != '')) {
						if (oHidden.value == '') oHidden.value = oLista.options[iI].value;
						else oHidden.value += ';'+oLista.options[iI].value;
					}
				}
			}
			</script>
			<table cellpadding=0 cellspacing=0 border=0>
			<input type=hidden name='".$aParametros['name']."' value=".$oHidden.">
	";
	if ($aParametros['quebra_linha']) {
		$sRetorno .= "
				<tr>
					<td nowrap>
						<font face=verdana size=1 color=$TextClaPaginaCadastro>
						&nbsp;
						".$aParametros['desc_1']."
						</font>
					</td>
				</tr>
				<tr>
					<td nowrap>
						&nbsp;
						".fLista(array(name => $aParametros['name']."lista_1", size => $aParametros['size'], sql => $aParametros['sql_1'], ondblclick => "fJS_".$aParametros['name']."(this.form,this,this.form.".$aParametros['name']."lista_2);", multiplo => $aParametros['multiplo']))."
					</td>
				</tr>
				<tr>
					<td nowrap align=center>
						&nbsp;
						".fButton(array(name => $aParametros['name']."b1", type => "button", value => "Adiciona", onclick => "fJS_".$aParametros['name']."(this.form,this.form.".$aParametros['name']."lista_1,this.form.".$aParametros['name']."lista_2);"))."
						&nbsp;
						&nbsp;
						".fButton(array(name => $aParametros['name']."b2", type => "button", value => "Remove", onclick => "fJS_".$aParametros['name']."(this.form,this.form.".$aParametros['name']."lista_2,this.form.".$aParametros['name']."lista_1);"))."
						&nbsp;
					</td>
				</tr>
				<tr>
					<td nowrap>
						<font face=verdana size=1 color=$TextClaPaginaCadastro>
						&nbsp;
						".$aParametros['desc_2']."
						</font>
					</td>
				</tr>
				<tr>
					<td nowrap>
						&nbsp;
						".fLista(array(name => $aParametros['name']."lista_2", size => $aParametros['size'], sql => $aParametros['sql_2'], ondblclick => "fJS_".$aParametros['name']."(this.form,this,this.form.".$aParametros['name']."lista_1);", multiplo => $aParametros['multiplo']))."
					</td>
				</tr>
			</table>
		";
	}
	else {
		$sRetorno .= "
				<tr>
					<td align=center nowrap>
						<font face=verdana size=1 color=$TextClaPaginaCadastro>
						&nbsp;
						".$aParametros['desc_1']."
						</font>
					</td>
					<td nowrap>
						<font face=verdana size=1 color=$TextClaPaginaCadastro>
						&nbsp;
						</font>
					</td>
					<td align=center nowrap>
						<font face=verdana size=1 color=$TextClaPaginaCadastro>
						&nbsp;
						".$aParametros['desc_2']."
						</font>
					</td>
				</tr>
				<tr>
					<td nowrap>
						&nbsp;
						".fLista(array(name => $aParametros['name']."lista_1", size => $aParametros['size'], sql => $aParametros['sql_1'], ondblclick => "fJS_".$aParametros['name']."(this.form,this,this.form.".$aParametros['name']."lista_2);", multiplo => $aParametros['multiplo']))."
					</td>
					<td nowrap>
						&nbsp;
						".fButton(array(name => $aParametros['name']."b1", type => "button", value => " >> ", onclick => "fJS_".$aParametros['name']."(this.form,this.form.".$aParametros['name']."lista_1,this.form.".$aParametros['name']."lista_2);"))."
						&nbsp;
						<br>
						&nbsp;
						".fButton(array(name => $aParametros['name']."b2", type => "button", value => " << ", onclick => "fJS_".$aParametros['name']."(this.form,this.form.".$aParametros['name']."lista_2,this.form.".$aParametros['name']."lista_1);"))."
						&nbsp;
					</td>
					<td nowrap>
						".fLista(array(name => $aParametros['name']."lista_2", size => $aParametros['size'], sql => $aParametros['sql_2'], ondblclick => "fJS_".$aParametros['name']."(this.form,this,this.form.".$aParametros['name']."lista_1);", multiplo => $aParametros['multiplo']))."
					</td>
				</tr>
			</table>
		";
	}
	return $sRetorno;
}


function fUpDown($obj) {
global $sUrlRaiz;

      echo "
      <table width='1%' border='0' cellspacing='0' cellpadding='2'>
        <tr>
            <td style='border: 1px solid #DEDEDE'><a href='#' onClick='text_updown(\"$obj\", \"up\")'><img src='$sUrlRaiz/imagens/cadastros/figura004-up.gif' border=0></a></td>
        </tr>
        <tr>
            <td style=\"border: 1px solid #DEDEDE\"><a href='#' onClick='text_updown(\"$obj\", \"down\")'><img src='$sUrlRaiz/imagens/cadastros/figura004-down.gif' border=0></a></td>
        </tr>
      </table>
    ";


}


?>
