<?
// MONTA A LISTA DE REQUISI��ES AO PAINEL ------------------------------------------------------------------------------------------------------------------------
ob_start();
$PagLivre = 1;
require_once('../../../indicadores.ini.php');

$_SESSION['aDadosUsuarioRECIP'] = array();
header("Location: $sUrlRaiz/controle/adm/login/index.php");

?>
