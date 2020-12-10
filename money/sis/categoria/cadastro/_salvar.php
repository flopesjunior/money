<?php

require_once "../../../money.ini.php";

$aDados = array();
foreach ($_POST as $key => $value) {
    
    if ($key == "mny_cat_id"){
        eval("\$$key = \"".  trim($value."\";"));    
    }
    else {
        $aDados[$key] = $value;
    }    
    
}

$bd = new BancoDados();

if ($mny_cat_id){
    $bd->fSisAtualizaRegistroBanco("money_categoria", $aDados, array("mny_cat_id" => $mny_cat_id));
    
}
else {
    $bd->fSisInsereRegistroBanco("money_categoria", $aDados);
}

echo "true"; 

?>