<?
// MONTA A LISTA DE REQUISI��ES AO PAINEL ------------------------------------------------------------------------------------------------------------------------
ob_start();
$PagLivre = 1;
require_once('../../atena.ini.php');

$_SESSION['aDadosCandidatoTeste'] = array();
header("Location: $sUrlRaiz/atena/login1/index.php");

?>
