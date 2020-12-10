<?php

require_once "../../../money.ini.php";

$aDados = array();
foreach ($_POST as $key => $value) {
    
    if ($key == "mny_per_id"){
        eval("\$$key = \"".  trim($value."\";"));    
    }
    else {
        $aDados[$key] = $value;
    }    
    
}

$bd = new BancoDados();

if ($mny_per_id){
    $bd->fSisAtualizaRegistroBanco("money_periodicidade", $aDados, array("mny_per_id" => $mny_per_id));
    
}
else {
    $bd->fSisInsereRegistroBanco("money_periodicidade", $aDados);
}

echo "true"; 

?>