<?PHP
//ob_start();
@session_start();


$sNomeSistema = "ATENA";

//Carrega o arquivo .INI
$aCONFIG              = parse_ini_file("ini/config.ini");

### Vari�veis
$sNomeSistema         = $aCONFIG["sNomeSistema"];
$sDiretorioRaiz       = $aCONFIG["sDiretorioRaiz"];
$sUrlRaiz             = $aCONFIG["sUrlRaiz"];
$sDiretorioRedmine    = $aCONFIG["sDiretorioRedmine"];


if  (empty($_SESSION['aDadosCandidatoTeste']["ftt_can_id"]) && !$PagLivre){
    header("Location: ".$sUrlRaiz."/atena/login1/index.php");
}


$_SESSION['sUrlRaiz'] = $sUrlRaiz;

require_once ("ini/mysql.ini.php");

define('ADODB_ASSOC_CASE', 0);
include_once("classes/adodb/adodb.inc.php");

$Mysql_INI = new  Mysql_INI();

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------
$aParMysql = $Mysql_INI->parametros_mysql();

$sDBSis_Tipo    = $aParMysql["sDBSis_Tipo"];
$sDBSis_Sid     = $aParMysql["sDBSis_Sid"];
$sDBSis_Usuario = $aParMysql["sDBSis_Usuario"];
$sDBSis_Senha   = $aParMysql["sDBSis_Senha"];
$sDBSis_Host    = $aParMysql["sDBSis_Host"];

$dbsis_mysql = NewADOConnection($sDBSis_Tipo);
$StatusDB    = $dbsis_mysql->Connect("$sDBSis_Host", "$sDBSis_Usuario", "$sDBSis_Senha", "$sDBSis_Sid");


//------------------------------------------------------------------------------------------------------------------------------------------------------------------------
include_once("classes/bd/gebd.php");
//include_once("classes/phplot/phplot.php");
include_once("ext/funcoes.php");


?>
