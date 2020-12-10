<?php

require_once('../atena.ini.php');
    
    if ($_SESSION['aDadosCandidatoTeste']["teste_execucao"] == true){
        echo "<script>window.location.href = '".$sUrlRaiz."atena/f3.php'</script>";
    }

    $ftt_can_id = $_SESSION['aDadosCandidatoTeste']["ftt_can_id"];

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

        $sSql .= " FROM ftt_candidato WHERE ftt_candidato.ftt_can_id = $ftt_can_id";

        //echo "SQL: $sSql";
        $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarrrregaConfiguracoes <br>".$sSql);

        if ($SqlResult_2->NumRows() == 1) {

            foreach ($aCampos as $sCampo){
                 eval("\$$sCampo = \"".  trim($SqlResult_2->fields[$sCampo]."\";"));
            }

        }

    }
    //utf8_encode($sSql)
//$aDatasColetadas = array();
//$aDatasColetadas = fRetornaPeriodos(4);
//$iaDatasColetadas_Tam = count($aDatasColetadas);


?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$sNomeSistema?></title>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>atena/js.js" type="text/javascript" ></script>    
    
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <?inclui_fav();?>
</head>

 
         
         
<body style="background-color: #ffffff; padding-left: 10px; padding-top: 10px; padding-right: 10px">

    <input type="hidden" id="sUrlRaiz" value="<?=$sUrlRaiz?>"> 
    <input type="hidden" id="ftt_can_id" value="<?=$ftt_can_id?>">    
    
    <?cabecalho();?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td height="50"></td></tr>    
        <tr>
            <td align="center">
                 <table width="50%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <div class="col-lg-12">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        Dados do Candidato 
                                    </div>
                                    <div class="panel-body">
                                       <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_prv_nome" placeholder="Nome" id="ftt_can_nome" value="<?=$ftt_can_nome?>"></input>    
                                                </td>
                                            </tr>
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" disabled name="ftt_can_email" placeholder="Email" id="ftt_can_email" value="<?=$ftt_can_email?>"></input>    
                                                </td>
                                            </tr>
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left>
                                                                <input class="form-control" name="ftt_can_celular" placeholder="Celular" id="ftt_can_celular" value="<?=$ftt_can_celular?>"></input>    
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left>
                                                                <input class="form-control" name="ftt_can_telefone" placeholder="Telefone Fixo" id="ftt_can_telefone" value="<?=$ftt_can_telefone?>"></input>    
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr>    
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_endereco" placeholder="Endereço" id="ftt_can_endereco" value="<?=$ftt_can_endereco?>"></input>    
                                                </td>
                                            </tr>                                            
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left width=90%>
                                                                <input class="form-control" name="ftt_can_cidade" placeholder="Cidade" id="ftt_can_cidade" value="<?=$ftt_can_cidade?>"></input>    
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left width=10%>
                                                                <input class="form-control" name="ftt_can_uf" placeholder="UF" id="ftt_can_uf" value="<?=$ftt_can_uf?>"></input>    
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr> 
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left width=70%>
                                                                <select class="form-control" id="ftt_can_escolaridade" value="<?=$ftt_can_escolaridade?>">
                                                                    
                                                                    <?
                                                                        if ($ftt_can_escolaridade){
                                                                            switch ($ftt_can_escolaridade) {
                                                                                case 1:
                                                                                    $FlagEscolaridade1 = "Selected";
                                                                                    break;
                                                                                case 2:
                                                                                    $FlagEscolaridade2 = "Selected";
                                                                                    break;
                                                                                case 3:
                                                                                    $FlagEscolaridade3 = "Selected";
                                                                                    break;
                                                                                default:
                                                                                    $FlagEscolaridade0 = "Selected";
                                                                                    break;
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <option value='0' <?=$FlagEscolaridade0?>>Escolaridade</option>
                                                                    <option value='1' <?=$FlagEscolaridade1?>>2º Grau</option>
                                                                    <option value='2' <?=$FlagEscolaridade2?>>Técnico</option>
                                                                    <option value='3' <?=$FlagEscolaridade3?>>Superior</option>
                                                                </select>           
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left width=10% nowrap>
                                                                <?
                                                                    if ($ftt_can_escolaridade_situacao == 1){
                                                                      $FlagSituação = "checked";  
                                                                    }
                                                                    else {
                                                                      $FlagSituação = ""; 
                                                                    }
                                                                ?>
                                                                <input type="checkbox" id="ftt_can_escolaridade_situacao" <?=$FlagSituação?>>Completo   
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left width=20%>
                                                                <input class="form-control" name="ftt_can_escolaridade_ano_conclusao" placeholder="Ano Conclusão" id="ftt_can_escolaridade_ano_conclusao" value="<?=$ftt_can_escolaridade_ano_conclusao?>"></input>    
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr>                                               
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_instuicao_ensino" placeholder="Nome da Instituição de Ensino" id="ftt_can_instuicao_ensino" value="<?=$ftt_can_instuicao_ensino?>"></input>    
                                                </td>
                                            </tr>                                                          
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_curso" placeholder="Curso" id="ftt_can_curso" value="<?=$ftt_can_curso?>"></input>    
                                                </td>
                                            </tr>                                                          
                                       </table> 
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <button type="button" onClick="registrar_candidato()" class="btn btn-danger">Avançar</button>
                        </td>    
                    </tr>    
                  </table> 
            </td>
        </tr>
      </table>  
    </center>    
    
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>


    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    

</body>

</html>
