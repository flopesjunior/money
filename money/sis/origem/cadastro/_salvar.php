<?php

require_once "../../../money.ini.php";

$aDados = array();
foreach ($_POST as $key => $value) {
    
    if ($key == "mny_ori_id"){
        eval("\$$key = \"".  trim($value."\";"));    
    }
    else {
        $aDados[$key] = $value;
    }
}

$bd = new BancoDados();

if ($mny_ori_id){
    $bd->fSisAtualizaRegistroBanco("money_origem_transacao", $aDados, array("mny_ori_id" => $mny_ori_id));
    
}
else {
    $bd->fSisInsereRegistroBanco("money_origem_transacao", $aDados);
}

echo "true"; 

?>