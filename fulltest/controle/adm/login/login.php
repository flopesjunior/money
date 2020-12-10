<?
ob_start();
$PagLivre      = 1;
require_once('../../../indicadores.ini.php');

    header("Content-Type: text/html;  charset=ISO-8859-1");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $sLogin   = isset($_POST["sLogin"]) ? $_POST["sLogin"]  : "";
    $sSenha   = isset($_POST["sSenha"]) ? $_POST["sSenha"] : "";

    $sLogin   = addslashes($sLogin);
    $sSenha   = addslashes($sSenha);

    $_SESSION['aDadosUsuarioRECIP'] = array();

    $Retorno  = "FALSE";

    //Busca todos os campos da tabela "configuracao"
    $sSql = "SHOW COLUMNS FROM geusuario ";
    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

    if ($SqlResult_1->NumRows() > 0) {

        $sSql = "SELECT ";

        $aCampos = array();

        //Guarda todos os campos e seus valores "default".
        while (!$SqlResult_1->EOF) {
            $Field   = $SqlResult_1->fields["Field"];

            $sCamposConcat .= "$Field, ";

            array_push($aCampos, $Field);

            $SqlResult_1->MoveNext();
        }

        $sSql .= substr($sCamposConcat, 0, -2);

        $sSql .= " FROM geusuario WHERE geusuario.ftt_usu_login = '$sLogin' AND geusuario.ftt_usu_status = 1";

        
        //echo $sSql;
        
        $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaConfiguracoes");

        if ($SqlResult_2->NumRows() == 1) {

            foreach ($aCampos as $sCampo){
                 eval("\$$sCampo = \"".trim($SqlResult_2->fields[$sCampo])."\";");
            }

            $sSenhaDigitada = md5($sSenha);
            
           //$sSenhaDigitada = sha1($salt . sha1($sSenha));
                    
            if ($sSenhaDigitada == $ftt_usu_senha) {

                foreach ($aCampos as $sCampo){
                    $_SESSION['aDadosUsuarioRECIP'][$sCampo] = trim($SqlResult_2->fields[$sCampo]);
                }

//		SetCookie("ULT_LOGIN_RECIP",$ind_usu_desc."|".$ind_usu_login, time()+31536000,"/");


                $Retorno = "TRUE";

            }
            else {
                $Retorno = "FALSE";
            }
        }

    }

    echo trim($Retorno);
