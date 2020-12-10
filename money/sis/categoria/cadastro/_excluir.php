<?php

require_once "../../../money.ini.php";

$mny_cat_id = $_POST["mny_cat_id"];

$bd = new BancoDados();

if ($mny_cat_id){
    $bd->fSisRemoveRegistroBanco("money_categoria", array("mny_cat_id" => $mny_cat_id));
}

echo "true"; 

?>