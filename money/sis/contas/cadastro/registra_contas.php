<?php

require_once "../../../money.ini.php";

$aDados = array();
foreach ($_POST as $key => $value) {
    
    if ($key == "mny_con_id"){
        eval("\$$key = \"".  trim($value."\";"));    
    }
    
    if ($key == "mny_con_data_base" || $key == "mny_con_pausada_data"){
       $value = fFormataData($value); 
    }
    
    if ($key != "mny_con_id"){
        $aDados[$key] = $value;
    }    
    
}

$bd = new BancoDados();

if ($mny_con_id){
    $bd->fSisAtualizaRegistroBanco("money_contas", $aDados, array("mny_con_id" => $mny_con_id));
    
}
else {
    $bd->fSisInsereRegistroBanco("money_contas", $aDados);
}

echo "true"; 

?>