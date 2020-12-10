<?php

require_once "../../../money.ini.php";

$mny_con_id = $_POST["mny_con_id"];

if ($mny_con_id == ""){
    echo "false1";
    exit;
}


$sSql = "
        SELECT 
            count(mny_pag_id_contas) as qtdmov
        FROM money_pagamentos
        WHERE 
            mny_pag_id_contas = $mny_con_id 
";  

$SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

$iQtdMov = $SqlResult_2->fields["qtdmov"]; 

if ($iQtdMov == 0){
    $Retorno = "true";
    $bd = new BancoDados();
    $bd->fSisRemoveRegistroBanco("money_contas", array("mny_con_id" => $mny_con_id));
}
else {
    $Retorno = "false";
}

echo $Retorno;

?>