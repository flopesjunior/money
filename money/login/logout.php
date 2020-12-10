<?PHP
// MONTA A LISTA DE REQUISI��ES AO PAINEL ------------------------------------------------------------------------------------------------------------------------
ob_start();
$PagLivre = 1;
require_once "../money.ini.php";

$_SESSION['aDadosUsuarioRECIP'] = array();
header("Location: ".$sUrlRaiz."login/index.php");

?>
