<?php

require_once "../../../money.ini.php";

$mny_per_id = $_POST["mny_per_id"];

$bd = new BancoDados();

if ($mny_per_id){
    $bd->fSisRemoveRegistroBanco("money_periodicidade", array("mny_per_id" => $mny_per_id));
}

echo "true"; 

?>