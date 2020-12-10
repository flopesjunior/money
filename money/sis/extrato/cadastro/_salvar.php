<?php

require_once "../../../money.ini.php";


foreach ($_POST as $key => $value) {
    
    eval("\$$key = \"".  trim($value."\";"));    
    
}

$bd = new BancoDados();

$iRetorno = 0;
if ($mny_cat_id){
    $iRetorno = $bd->fSisAtualizaRegistroBanco("money_extrato_cc", array("mny_exc_id_categoria" => $mny_cat_id), array("mny_exc_id" => $mny_exc_id));
}
else {
    $sSql = "UPDATE money_extrato_cc SET mny_exc_id_categoria = NULL WHERE mny_exc_id = $mny_exc_id";
    $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaCampos <br>".$sSql);
    $iRetorno = 1;
}

echo $iRetorno; 

?>