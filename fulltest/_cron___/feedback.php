<?
require_once('../atena.ini.php');
require_once("lib/atena.php");
require_once("../ext/email/smtp.class.php");
require_once("../ext/email/email.php");

//Esta rotina � responsavel por verificar eventos n�o baixados

$atena = new atena();
$atena->EnviaEmailFeedbackTeste();

?>