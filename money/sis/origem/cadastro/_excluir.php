<?php

require_once "../../../money.ini.php";

$mny_ori_id = $_POST["mny_ori_id"];

$bd = new BancoDados();

if ($mny_ori_id){
    $bd->fSisRemoveRegistroBanco("money_origem_transacao", array("mny_ori_id" => $mny_ori_id));
}

echo "true"; 

?>