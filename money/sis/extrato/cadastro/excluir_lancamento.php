<?php

require_once "../../../money.ini.php";

$mny_exc_id = $_POST["mny_exc_id"];

if ($mny_exc_id == ""){
    echo "false1";
    exit;
}

$bd = new BancoDados();
$bd->fSisRemoveRegistroBanco("money_extrato_cc", array("mny_exc_id" => $mny_exc_id));

echo "true";

?>