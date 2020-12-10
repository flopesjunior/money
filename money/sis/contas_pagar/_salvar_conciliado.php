<?php

require_once "../../money.ini.php";

$aDados = array();

foreach ($_POST as $key => $value) {
    eval("\$$key = \"".  trim($value."\";"));    
}

$aPeriodo = explode("-", $data_vencimento);


if ($tipo_baixa == 3){
        $mny_pag_vencimento_original    = $data_vencimento;
        $mny_pag_valor_original         = 0;
        $mny_pag_vencimento_pago        = "";
        $mny_pag_valor_pago             = 0;     
}
else {
    if (is_null($mny_exc_id)){
        $mny_pag_vencimento_original    = $data_vencimento;
        $mny_pag_valor_original         = $valor;
        $mny_pag_vencimento_pago        = $data_vencimento;
        $mny_pag_valor_pago             = $valor;
    }
    else {
        $mny_pag_vencimento_original    = $data_vencimento;
        $mny_pag_valor_original         = $valor;
        $mny_pag_vencimento_pago        = fFormataData($mny_exc_data);
        $mny_pag_valor_pago             = $mny_exc_valor;    
    }
}

$aDados = array(
        "mny_pag_id_contas"             => $mny_con_id,
        "mny_pag_id_extrato"            => $mny_exc_id,
        "mny_pag_vencimento_original"   => $data_vencimento,
        "mny_pag_vencimento_pago"       => $mny_pag_vencimento_pago,
        "mny_pag_valor_original"        => $valor,
        "mny_pag_valor_pago"            => $mny_pag_valor_pago,
        "mny_pag_parcela"               => $parcela,
        "mny_pag_tipo_baixa"            => $tipo_baixa,
        "mny_pag_mes"                   => $aPeriodo[1],
        "mny_pag_ano"                   => $aPeriodo[0]
        );

$bd = new BancoDados();

$bd->fSisInsereRegistroBanco("money_pagamentos", $aDados);

if ($mny_con_id_peridiocidade == 6) { //Apenas uma vez... baixa a conta
    $bd->fSisAtualizaRegistroBanco("money_contas", array("mny_con_encerrada" => 1), array("mny_con_id" => $mny_con_id));
}

if ($parcela){
    
    $sSql = "SELECT 
                mny_con_parcelas_detalhe
            FROM money_contas
            WHERE 
                mny_con_id = $mny_con_id     
            ";  

    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);   
    $mny_con_parcelas_detalhe    =   $SqlResult_1->fields["mny_con_parcelas_detalhe"]; 

    $aParc = json_decode(str_replace("|","\"",$mny_con_parcelas_detalhe));

    $fValorTotal    = 0;
    $iQtdParcAberta = 0;
    foreach ($aParc as $value) {

        if ($value->parcela == $parcela){
            $value->data    = $mny_pag_vencimento_pago;
            $value->valor   = $mny_pag_valor_pago;
            $value->pago    = 1;
        }

        if ($value->pago == 0){
            $iQtdParcAberta++;
        }
    }
    
    if ($iQtdParcAberta == 0){
        $bd->fSisAtualizaRegistroBanco("money_contas", array("mny_con_encerrada" => 1), array("mny_con_id" => $mny_con_id));
    }
    

    $mny_con_parcelas_detalhe = json_encode($aParc);
    $mny_con_parcelas_detalhe = str_replace("\"","|",$mny_con_parcelas_detalhe);

    $bd->fSisAtualizaRegistroBanco("money_contas", array("mny_con_parcelas_detalhe" => $mny_con_parcelas_detalhe), array("mny_con_id" => $mny_con_id));

    //

    //echo "mny_con_parcelas_detalhe: ".$mny_con_parcelas_detalhe;
//[{|parcela|:1,|data|:|2020-10-29|,|valor|:|80,31|,|pago|:1},{|parcela|:2,|data|:|2020-11-27|,|valor|:|80,31|,|pago|:1},{|parcela|:3,|data|:|2020-12-29|,|valor|:|80,31|,|pago|:0}]
}

echo "true"; 

/*
var mny_exc_id               = aExratoSelected[0];
var mny_exc_data             = aExratoSelected[1];
var mny_exc_historico        = aExratoSelected[2];
var mny_exc_tipo_mov         = aExratoSelected[3];
var mny_exc_valor            = aExratoSelected[4];              
//
var data_vencimento_f        = aDadosSelected[2];
var tipo_movimentacao        = aDadosSelected[3];
var origem                   = aDadosSelected[4];
var valor                    = aDadosSelected[15];
var periodicidade            = aDadosSelected[6];
var observacao               = aDadosSelected[8];
var mny_con_id_origem        = aDadosSelected[10];
var mny_con_id               = aDadosSelected[11];
var parcela                  = aDadosSelected[12];
var data_vencimento          = aDadosSelected[13];
var mny_con_id_peridiocidade = aDadosSelected[14];
var pago                     = aDadosSelected[16];
var parcela_f                = aDadosSelected[7];
var mes_atual                = '<?=$MesAtual?>';
var ano_atual                = '<?=$AnoAtual?>';
*/

?>