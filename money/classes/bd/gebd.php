<?php

class BancoDados {

    ### Exemplo: fSisInsereRegistroBanco("tabela", array("campo" => "valor", "campo" => "valor", ...));
    function fSisInsereRegistroBanco($sTabela, $aDados, $sCampoID="") {
       global $dbsis_mysql;

       foreach ($aDados as $sCampo => $sValor) {
          $sCampos ? $sCampos .= ",$sCampo" : $sCampos .= "$sCampo";
          if(empty($sValor) && $sValor != "0") $sValor = "null";
          if ($sValor != "null") $sValor = "'$sValor'";
          $sValores ? $sValores .= ",$sValor" : $sValores .= "$sValor";
       }

       $sSql = "INSERT INTO ".$sTabela." (".$sCampos.") VALUES (".$sValores.")";
       //echo $sSql."<br>";
       $dbsis_mysql->Execute($sSql) or die($sSql."<br>".$dbsis_mysql->ErrorMsg());

        return true;

    }

    function fSisInsereTAREFABanco($sTabela, $aDados, $sCampoID="") {
       global $dbsis_mysql;

       $sSql_iID = "SELECT MAX(".$sCampoID.") AS ".$sCampoID." FROM ".$sTabela;
       $SqlResult_1 = $dbsis_mysql->Execute($sSql_iID) or die($sSql_iID."<br>".$dbsis_mysql->ErrorMsg());
       $iID = $SqlResult_1->fields[$sCampoID];	   
	   
       foreach ($aDados as $sCampo => $sValor) {
          $sCampos ? $sCampos .= ",$sCampo" : $sCampos .= "$sCampo";
          if(empty($sValor) && $sValor != "0") $sValor = "null";
          if ($sValor != "null") $sValor = "'$sValor'";
          $sValores ? $sValores .= ",$sValor" : $sValores .= "$sValor";
       }

       $sSql = "INSERT INTO ".$sTabela." (".$sCampos.") VALUES (".$sValores.")";
       $dbsis_mysql->Execute($sSql) or die($sSql."<br>".$dbsis_mysql->ErrorMsg());

        ### Retorno do ID inserido
        if (trim($sCampoID)!=""){
            $sSql_iID = "SELECT MAX(".$sCampoID.") AS ".$sCampoID." FROM ".$sTabela;
            $SqlResult_1 = $dbsis_mysql->Execute($sSql_iID) or die($sSql_iID."<br>".$dbsis_mysql->ErrorMsg());
            $iID = $SqlResult_1->fields[$sCampoID];
        }
        else {
            $iID = "0";
        }

        return $iID;

    }	

    function fVerificaDiferenca($sTabela, $aDados, $aChave) {
       global $dbsis_mysql;

       foreach ($aDados as $sCampo => $sValor) {
          $sCampos ? $sCampos .= ",$sCampo" : $sCampos .= "$sCampo";
       }

       foreach ($aChave as $sCampoChave => $sValorChave){
          $sWhere ? $sWhere .= " AND $sCampoChave = '$sValorChave'" : $sWhere = "$sCampoChave = '$sValorChave'";
       }
       
       $sSql_iID = "SELECT $sCampos FROM ".$sTabela." WHERE ".$sWhere ;
       $SqlResult_1 = $dbsis_mysql->Execute($sSql_iID) or die($sSql_iID."<br>".$dbsis_mysql->ErrorMsg());
       
       foreach ($aDados as $sCampo => $sValor) {
          if ($sValor != $SqlResult_1->fields[$sCampo]){
              $sSql = "INSERT INTO ".$sTabela."_log SELECT $sCampos FROM ".$sTabela." WHERE ".$sWhere;
              $dbsis_mysql->Execute($sSql);
              break;
          }
       }
       
       return true;

    }	
    
    
    ### Exemplo: fSisRemoveRegistroBanco("tabela", array("campo_condicao_1" => "valor_condicao_1", "campo_condicao_2" => "valor_condicao_2", ...));
    function fSisRemoveRegistroBanco($sTabela, $aChave) {
        global $dbsis_mysql;

        foreach ($aChave as $sCampoChave => $sValorChave){
            $sWhere ? $sWhere .= " AND $sCampoChave = '$sValorChave'" : $sWhere = "$sCampoChave = '$sValorChave'";
        }
            //

        $sSql = "DELETE FROM ".$sTabela;
        
        if ($sWhere) $sSql .= " WHERE ".$sWhere;
        
        $dbsis_mysql->Execute($sSql) or die($sSql."<br>".$dbsis_mysql->ErrorMsg());

    }

    ### Exemplo: fSisAtualizaRegistroBanco("geusuar", array("campo_1" => "valor_1", "campo_2" => "valor_2", ...), array("campo_condicao_1" => "valor_condicao_1", "campo_condicao_2" => "valor_condicao_2", ...));
    function fSisAtualizaRegistroBanco($sTabela, $aDados, $aChave="") {
        global $dbsis_mysql;

        ### $aDados
       foreach ($aDados as $sCampo => $sValor) {
          if (empty($sValor) && $sValor != "0") $sValor = "null";
            if ($sValor != "null") $sValor = "'$sValor'";
          $sValores ? $sValores .= ",$sCampo = $sValor" : $sValores .= "$sCampo = $sValor";
       }

        ### $aChave
        if ($aChave) {
            foreach ($aChave as $sCampoChave => $sValorChave)
                $sWhere ? $sWhere .= " AND $sCampoChave = '$sValorChave'" : $sWhere = "$sCampoChave = '$sValorChave'";
        }

        $sSql = "UPDATE ".$sTabela." SET ".$sValores;

        if ($sWhere) $sSql .= " WHERE ".$sWhere;

        $dbsis_mysql->Execute($sSql) or die($sSql."<br>".$dbsis_mysql->ErrorMsg());

        //$id_chave = fSisRetornaValorBanco($sTabela, $sPrefixo."ID", $aChave);
                //
        $retorno = 1;

        //$retorno = $sSql;

        return $retorno;
    }

    function Gera_Evento_Interno($sEvento, $sImei="", $sConta=""){

//        $sImei  = trim($_SESSION["DADOS_CONEXAO"][$client->id]["IMEI"]);
//        $sConta = trim($_SESSION["DADOS_CONEXAO"][$client->id]["CONTA"]);

        //echo "CONTA: ".$_SESSION["DADOS_CONEXAO"][$client->id]["CONTA"]."\n";

        $sImei  ? $sImei  = $sImei  : $sImei  = "000000";
        $sConta ? $sConta = $sConta : $sConta = "0000";

        $dData = date("d/m/Y");
        $tHora = date("H:i:s");

        $Data = fFormataData3($dData)." ".$tHora;

        $aDados  = array(
                         'Mensagem'     => 'GPRS MESSAGE',
                         'Pacote'       => 'INT',
                         'Conta'        => $sConta,
                         'Imei'         => $sImei,
                         'Qualificador' => $sEvento,
                         'Argumento'    => '000',
                         'Particao'     => '00',
                         'Data'         =>  $Data
                         );

        $this->fSisInsereRegistroBanco("log_php", $aDados);

    }

}
?>
