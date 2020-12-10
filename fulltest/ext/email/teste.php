<?
require_once("smtp.class.php");

 //****************************************************************************************************************************************************************************************************************##......
//MANDA EMAIL PRO ADMINISTRADOR **********************************************************************************************************************************************************************************##......
$sMail_To       = "teste@teste.net.br;treste.xxx@fulltime.net.br";
$sMail_From     = "remetente@email.com.br";
$sMail_Assunto  = "ASSUNTO";

$aMail_To = explode(";", $sMail_To);

foreach ($aMail_To as $valor) {

    $host  = "server SMTP"; /*host do servidor SMTP */
    $smtp1 = new Smtp($host);
    $smtp1->user  = "user@dominio.com.br"; /*usuario do servidor SMTP */
    $smtp1->pass  = "senha"; /* senha dousuario do servidor SMTP*/
    $smtp1->debug = true; /* ativar a autenticaчуo SMTP*/

    $To = trim($valor);

    if (!empty($To)){
        $enviou = $smtp1->Send($To, $sMail_From, $sMail_Assunto, $sMensagem);
        if ($enviou) echo "enviou";
        else echo "mail FAIL to: $To";
    }
}
?>