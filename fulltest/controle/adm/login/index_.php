<?


$salt = '79da91fb8233132cffd9195969cea383';

echo "senha: ".sha1($salt . sha1('6veb12si'));
exit;

$PagLivre = 1;
require_once('../../../indicadores.ini.php');
include_once('../../../ext/objetos.php');


### Extrai os dados contidos no cookie de �ltimo login
//$aUlt_Login = fExtraiUlt_Login($_COOKIE);
//
//if(!$aUlt_Login["rec_usu_login"]) $aUlt_Login["rec_usu_login"] = isset($_GET["rec_usu_login"]) ? $_GET["rec_usu_login"] : "";
//
//### entrando na p�gina de login em m�todo GET, cria as vari�veis iniciais de acordo com o cookie para aparecer no formul�rio
//if (!isset($sLogin)) $sLogin = $aUlt_Login["rec_usu_login"];
//
//$sNomeSistema = $_SESSION["aIdioma"][1][$_SESSION["Idioma_Atual"]];
//
//$_SESSION['aDadosUsuarioRECIP'] = array();

?>


<html>
  <head>
    <title><?=$sNomeSistema?></title>
    <script src="js.js"></script>

  </head>

  <body >
  <form name="login" method="post" action="<?=$PHP_SELF?>">
    <input type="hidden" id="sUrlRaiz"          value="<?=$sUrlRaiz?>">
    <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td>
                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign=center nowrap  class='txt_preto_001'>
                                Usuario:
                        </td>
                    </tr>
                    <tr>
                        <td valign=center>
                                <?=fText(array(id => "sLogin", name => "sLogin", value => $sLogin, size => "35", maxlength => "100", formato => "normal"))?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td height="10px"></td></tr>
        <tr>
            <td>
                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign=center  class='txt_preto_001'>
                                Senha:
                        </td>
                    </tr>
                    <tr>
                        <td  valign=center>
                                <input class=oText type=password id='sSenha' name='sSenha' size='35' maxlength='8'>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td height="10px"></td></tr>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="3" align="right">
                                <input type=button value="Entrar" onclick="recipadm_06_001();">
                        </td>
                    </tr>
                    <tr><td height="10px"></td></tr>
                    <tr>
                        <td colspan="3" align="center" class='txt_preto_001'>
                               <div id='aviso_login'></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
  </table>
  </form>
  </body>
</html>



