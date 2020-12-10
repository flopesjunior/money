<?php

require_once "../../money.ini.php";

$sSql = "SELECT * FROM money_extrato_cc";  

$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  

echo $SqlResult_1->NumRows();

?>