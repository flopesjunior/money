<?php

require_once "../../money.ini.php";

$aDados = array();

$bd = new BancoDados();

foreach ($_POST as $key => $value) {
    eval("\$$key = \"".  trim($value."\";"));    
}

$aPeriodo = explode("-", $data_vencimento);

$sSql = "DELETE 
        FROM money_pagamentos 
        WHERE  
            mny_pag_id = $mny_pag_id_modal"; 
                
$dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

if ($mny_con_id_peridiocidade == 6) { //Apenas uma vez... baixa a conta
    $bd->fSisAtualizaRegistroBanco("money_contas", array("mny_con_encerrada" => 0), array("mny_con_id" => $mny_con_id));
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

    $fValorTotal = 0;
    foreach ($aParc as $value) {

        if ($value->parcela == $parcela){
            $value->pago    = 0;
        }

    }
    
    //$bd->fSisAtualizaRegistroBanco("money_contas", array(), array("mny_con_id" => $mny_con_id));

    $mny_con_parcelas_detalhe = json_encode($aParc);
    $mny_con_parcelas_detalhe = str_replace("\"","|",$mny_con_parcelas_detalhe);

    $bd->fSisAtualizaRegistroBanco("money_contas", array("mny_con_parcelas_detalhe" => $mny_con_parcelas_detalhe, "mny_con_encerrada" => 0), array("mny_con_id" => $mny_con_id));

    //

    //echo "mny_con_parcelas_detalhe: ".$mny_con_parcelas_detalhe;

}
else {
    $bd->fSisAtualizaRegistroBanco("money_contas", array("mny_con_encerrada" => 0), array("mny_con_id" => $mny_con_id));
}


//$bd->fSisRemoveRegistroBanco("money_pagamentos", array("mny_pag_id_contas" => $mny_con_id, "mny_pag_mes" => $aPeriodo[1], "mny_pag_ano" => $aPeriodo[0]));

echo "true"; 


?>