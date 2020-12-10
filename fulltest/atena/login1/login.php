<?
ob_start();
$PagLivre      = 1;
require_once('../../atena.ini.php');

    header("Content-Type: text/html;  charset=ISO-8859-1");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    $sLogin   = isset($_POST["sLogin"]) ? $_POST["sLogin"]  : "";
//    $sSenha   = isset($_POST["sSenha"]) ? $_POST["sSenha"] : "";

    $sLogin   = addslashes($sLogin);

    $_SESSION['aDadosCandidatoTeste'] = array();

    $Retorno  = "FALSE";

    //Busca todos os campos da tabela "configuracao"
    $sSql = "SHOW COLUMNS FROM ftt_candidato ";
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

        $sSql .= " FROM ftt_candidato WHERE ftt_candidato.ftt_can_email = '$sLogin' AND ftt_candidato.ftt_can_status = 1";

        
        //echo $sSql;
        
        $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaConfiguracoes");

        if ($SqlResult_2->NumRows() == 1) {

            foreach ($aCampos as $sCampo){
                 eval("\$$sCampo = \"".trim($SqlResult_2->fields[$sCampo])."\";");
            }

            $sSql = "SELECT ftt_tst_id FROM ftt_teste WHERE ftt_tst_id_candidato = $ftt_can_id AND ftt_tst_status = 1";
            $SqlResult_3 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaConfiguracoes");
            
            if ($SqlResult_3->NumRows() <> 0) {
                foreach ($aCampos as $sCampo){
                    $_SESSION['aDadosCandidatoTeste'][$sCampo] = trim($SqlResult_2->fields[$sCampo]);
                    $Retorno = "TRUE";
                }                
            }
            else {
                $Retorno = "FALSE";
            }
        }

    }

    echo trim($Retorno);
