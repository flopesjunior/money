<?php

require_once('../atena.ini.php');

if ($_SESSION['aDadosCandidatoTeste']["teste_execucao"] == true){
    echo "<script>window.location.href = '".$sUrlRaiz."atena/f3.php'</script>";
}

$ftt_can_id = $_SESSION['aDadosCandidatoTeste']["ftt_can_id"];

$aDadosTeste = array();
$aDadosTeste = sCarrgaSessaoTesteEmExecucao($ftt_can_id);      
    
$sSql = "SELECT 	
            TIME_TO_SEC(TIMEDIFF(now(), ftt_tst_data_inicio)) AS seg_execucao,
            ftt_tst_id, 
            ftt_tst_id_candidato, 
            ftt_tst_status, 
            ftt_tst_data_cadastro, 
            ftt_tst_data_inicio, 
            ftt_tst_data_fim, 
            ftt_tst_id_prova,
            ftt_tst_carrecao,
            ftt_prv_id, 
            ftt_prv_descricao, 
            ftt_prv_tempo,
            ftt_prv_tempo * 60 as ftt_prv_tempo_segundos,
            ftt_prv_nivel, 
            ftt_prv_data_cadastro, 
            ftt_prv_data_ultalt, 
            ftt_prv_nome
            FROM ftt_teste 
            INNER JOIN ftt_prova ON ftt_prv_id = ftt_tst_id_prova
            WHERE ftt_tst_id_candidato = $ftt_can_id AND ftt_tst_status = 1";
             
$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

if ($SqlResult_1->NumRows() <> 0) {
$seg_execucao               = $SqlResult_1->fields["seg_execucao"];      
$ftt_tst_id                 = $SqlResult_1->fields["ftt_tst_id"];                           
$ftt_tst_id_candidato       = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
$ftt_tst_status             = $SqlResult_1->fields["ftt_tst_status"];  
$ftt_tst_data_cadastro      = $SqlResult_1->fields["ftt_tst_data_cadastro"]; 
$ftt_tst_data_inicio        = $SqlResult_1->fields["ftt_tst_data_inicio"]; 
$ftt_tst_data_fim           = $SqlResult_1->fields["ftt_tst_data_fim"]; 
$ftt_tst_id_prova           = $SqlResult_1->fields["ftt_tst_id_prova"]; 
$ftt_tst_carrecao           = $SqlResult_1->fields["ftt_tst_carrecao"]; 

$ftt_prv_id                 = $SqlResult_1->fields["ftt_prv_id"]; 
$ftt_prv_descricao          = $SqlResult_1->fields["ftt_prv_descricao"]; 
$ftt_prv_tempo              = $SqlResult_1->fields["ftt_prv_tempo"]; 
$ftt_prv_tempo_segundos     = $SqlResult_1->fields["ftt_prv_tempo_segundos"]; 
$ftt_prv_nivel              = $SqlResult_1->fields["ftt_prv_nivel"]; 
$ftt_prv_data_cadastro      = $SqlResult_1->fields["ftt_prv_data_cadastro"]; 
$ftt_prv_data_ultalt        = $SqlResult_1->fields["ftt_prv_data_ultalt"]; 
$ftt_prv_nome               = $SqlResult_1->fields["ftt_prv_nome"]; 

    $sSql = "SELECT SUM(ftt_prc_quantidade)	as qtd
            FROM ftt_prova_conteudo 
            WHERE ftt_prc_id_prova = $ftt_prv_id";

    $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

    $Total_Questoes = $SqlResult_2->fields["qtd"]; 
    
    $sSql = "SELECT SUM(ftt_tip_peso * ftt_prc_quantidade) AS tot_pontos
            FROM ftt_prova_conteudo 
            INNER JOIN ftt_pergunta_tipo_peso ON ftt_tip_codigo = ftt_prc_nivel
            WHERE ftt_prc_id_prova = $ftt_prv_id";

    $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

    $Total_Pontos = $SqlResult_2->fields["tot_pontos"]; 

}
else {
    echo "Não existe teste em aberto para o candidato";
    exit;
}

$Tempo = m2h($ftt_prv_tempo);

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
        <tr><td height="10"></td></tr>    
        <tr>
            <td align="center">
                 <table width="50%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td nowrap valign="bottom">
                                        <h4>O teste a seguir é sobre</h4> 
                                    </td>
                                    <td>&nbsp;</td>
                                    <td nowrap valign="bottom">
                                        <h4><b><?=$ftt_prv_nome?></b></h4>
                                    </td>
                                </tr>
                            </table>                            
                        </td>
                    </tr>
                    <tr><td height='10' style='border-bottom: thin solid #CCCCCC'><td></tr>
                    <tr><td height='10'><td></tr>
                    <?if ($ftt_prv_descricao){?>
                    <tr>
                        <td>
                            <?=$ftt_prv_descricao?>
                        </td>
                    </tr>
                    <?}?>
                    <tr><td height='10' style='border-bottom: thin solid #CCCCCC'><td></tr>
                    <tr><td height='10'><td></tr>
                    <tr >
                        <td nowrap>
                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <i class="fa fa-info-circle"></i> Contém um total de <b><?=$Total_Questoes?>  questões </b> valendo <b><?=$Total_Pontos?> pontos</b>
                                    </td>
                                    <td>
                                        , com o tempo máximo de execução de <b><?=$Tempo?></b>
                                    </td>
                                </tr>
                            </table>    
                            
                        </td>
                    </tr>
                    <tr><td height='20'><td></tr>
                    <tr>
                        <td align='left'>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4>Por favor leia com atenção!</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                         <tr>
                                                            <td>
                                                                <i class="fa fa-arrow-circle-right"></i> &nbsp; Assista o vídeo tutorial, localizado abaixo desta página.
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                                <i class="fa fa-arrow-circle-right"></i> &nbsp; Não tente tentar copiar uma questão e procurar a resposta na internet.
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                                <i class="fa fa-arrow-circle-right"></i> &nbsp; Não faça um print screen.
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                                <i class="fa fa-arrow-circle-right"></i> &nbsp; Não peça para alguem fazer o teste por você.
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td>
                                                                <i class="fa fa-arrow-circle-right"></i> &nbsp; Equipamentos eletrônicos (celular, tablet, notebook, etc) devem estar desligados durante o teste.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <i class="fa fa-arrow-circle-right"></i> &nbsp; Caso as regras acima sejam violadas, o teste será <b>BLOQUEADO</b>.
                                                            </td>
                                                        </tr>                                                        
                                                    </table>    
                                                </div>
                                            </div>
                                            <!-- /.col-lg-4 -->
                                        </div>                            
                                    </td>
                                </tr>
                            </table>                                
                        </td>
                    </tr>
                    <tr><td height='20'><td></tr>
                    <tr>
                        <td align="right">
                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                       <button type="button" onClick="window.location.href = '<?=$sUrlRaiz?>atena/f2.php'" class="btn btn-success">Entendi as regras, desejo continuar.</button>
                                    </td>
                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <button type="button" onClick="window.location.href = '<?=$sUrlRaiz?>atena/login1/logout.php'" class="btn btn-danger">Desistir</button>
                                    </td>
                                </tr>
                            </table>                                
                            
                        </td>    
                    </tr>   
                     <tr><td height='100'><td></tr>
                    <tr>
                        <td align="center">
                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4>Vídeo Tutorial</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <video width="1280" height="960" controls="controls">
                                                    <source src="tutorial.mp4" type="video/mp4">
                                                    <object data="" width="320" height="240">
                                                        <embed width="320" height="240" src="tutorial.mp4">
                                                    </object>
                                                    </video> 
                                               </div>  
                                            </div> 
                                        </div>    
                                    </td>
                                </tr>
                            </table>                                
                            
                        </td>    
                    </tr>   
                     <tr><td height='50'><td></tr>
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