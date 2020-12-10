<?
require_once('../../../indicadores.ini.php');

$apu_zon_id     = $_POST["apu_zon_id"];
$apu_ses_id     = $_POST["apu_ses_id"];

$txt_candidato_1     = $_POST["txt_candidato_1"];
$txt_candidato_2     = $_POST["txt_candidato_2"];
$txt_candidato_3     = $_POST["txt_candidato_3"];
$txt_candidato_4     = $_POST["txt_candidato_4"];
$txt_candidato_5     = $_POST["txt_candidato_5"];


if (trim($txt_candidato_1)=="") $txt_candidato_1 = "0";
if (trim($txt_candidato_2)=="") $txt_candidato_2 = "0";
if (trim($txt_candidato_3)=="") $txt_candidato_3 = "0";
if (trim($txt_candidato_4)=="") $txt_candidato_4 = "0";
if (trim($txt_candidato_5)=="") $txt_candidato_5 = "0";

$sSql = "DELETE FROM apu_apuracao WHERE apu_apu_id_zon = $apu_zon_id AND apu_apu_id_ses = $apu_ses_id";
$dbsis_mysql->Execute($sSql) or die("ERRx001:DELETA");    


$sSql = "INSERT INTO apu_apuracao (apu_apu_id_zon, apu_apu_id_ses, apu_apu_id_can, apu_apu_qde_votos, apu_apu_data) values 
	($apu_zon_id, $apu_ses_id, 1, $txt_candidato_1, NOW()),
	($apu_zon_id, $apu_ses_id, 2, $txt_candidato_2, NOW()),
	($apu_zon_id, $apu_ses_id, 3, $txt_candidato_3, NOW()),
	($apu_zon_id, $apu_ses_id, 4, $txt_candidato_4, NOW()),
	($apu_zon_id, $apu_ses_id, 5, $txt_candidato_5, NOW())
";

$dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE");    

echo "true";

?>