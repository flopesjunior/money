<?
require_once('../../../indicadores.ini.php');

$ftt_prv_id = $_GET["ftt_prv_id"];
    
$sChave = "A".$_SESSION['aDadosUsuarioRECIP']['ftt_usu_id'];

            $sSql = "delete from ftt_view_ranking where vtt_vwt_chave = '$sChave'";
            $dbsis_mysql->Execute($sSql);
    

            $sSql = "
                select 	
                ftt_tst_id, 
                ftt_tst_id_candidato, 
                ftt_tst_tempo_excedido,
                ftt_tst_bloqueado,
                ftt_tst_status, 
                date_format(ftt_tst_data_cadastro, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_cadastro,   
                date_format(ftt_tst_data_inicio, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_inicio, 
                date_format(ftt_tst_data_fim, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_fim, 
                TIMEDIFF(ftt_tst_data_fiM,ftt_tst_data_inicio) as tempo_teste,
                TIME_TO_SEC(timediff(ftt_tst_data_fim, ftt_tst_data_inicio)) as tempo_total_seg,
                ftt_tst_id_prova,
                ftt_can_nome, 
                ftt_can_email,
                ftt_prv_nome,
                timediff(ftt_tst_data_fim, ftt_tst_data_inicio) as tempo_total
                from ftt_teste                                        
                inner join ftt_candidato on ftt_can_id = ftt_tst_id_candidato
                inner join ftt_prova on ftt_prv_id = ftt_tst_id_prova
                where ftt_tst_id_prova = $ftt_prv_id and ftt_tst_status = 4 and ftt_tst_bloqueado = 0
                order by ftt_tst_status asc, ftt_can_nome 
                ";  
//                                        echo $sSql."<BR>";

            
            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR> $sSql");    
            
            if ($SqlResult_1->NumRows() > 0) {
                
                    
 
                
                while (!$SqlResult_1->EOF) {            
                $ftt_tst_id                  = $SqlResult_1->fields["ftt_tst_id"];                              
                $ftt_tst_id_candidato        = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
                $tempo_teste                 = $SqlResult_1->fields["tempo_teste"];
                $tempo_total_seg             = $SqlResult_1->fields["tempo_total_seg"]; 
                $ftt_prv_nome                = $SqlResult_1->fields["ftt_prv_nome"]; 
                
                
                    $aRetorno = fRetornaCorrecao($ftt_tst_id);

                    
                    if (!$aRetorno["iTotalPerguntas"])         $aRetorno["iTotalPerguntas"]        = 0;
                    if (!$aRetorno["iTotalPontos"])            $aRetorno["iTotalPontos"]           = 0;
                    if (!$aRetorno["iTotalPontos"])            $aRetorno["iTotalPontos"]           = 0;
                    if (!$aRetorno["iTotalErrado"])            $aRetorno["iTotalErrado"]           = 0;
                    if (!$aRetorno["iTotalAnuladoCandidato"])  $aRetorno["iTotalAnuladoCandidato"] = 0; 
                    if (!$aRetorno["iTotalAnuladoTempo"])      $aRetorno["iTotalAnuladoTempo"]     = 0;
                    
                    $sSql = "                    
                            insert into ftt_view_ranking (
                            vtt_vwr_iTotalPerguntas, 
                            vtt_vwr_iTotalPontos, 
                            vtt_vwt_iTotalCorreto, 
                            vtt_vwt_iTotalErrado, 
                            vtt_vwt_iTotalAnuladoCandidato, 
                            vtt_vwt_iTotalAnuladoTempo, 
                            vtt_vwt_tempo_teste, 
                            vtt_vwt_tempo_total_seg, 
                            vtt_vwt_id_candidato, 
                            vtt_vwt_chave,
                            vtt_vwt_prova
                            ) values (
                            ".$aRetorno["iTotalPerguntas"].", 
                            ".$aRetorno["iTotalPontos"].",
                            ".$aRetorno["iTotalPontos"].", 
                            ".$aRetorno["iTotalErrado"].", 
                            ".$aRetorno["iTotalAnuladoCandidato"].", 
                            ".$aRetorno["iTotalAnuladoTempo"].", 
                            '".$tempo_teste."', 
                            ".$tempo_total_seg.", 
                            ".$ftt_tst_id_candidato.", 
                            '".$sChave."',
                            '".$ftt_prv_nome."'    
                            ) ";                   
                    
                    $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaConfiguracoes <BR> $sSql"); 
                    
                    $SqlResult_1->MoveNext();
                }
                
            }    
        
                 
    
?>

<html>
  <head>
    <title>CADASTRO DAS PROVAS - <?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/provas/cadastro/js.js" type="text/javascript" ></script>
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  

    <!-- Custom CSS -->
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    
  </head>
  <body style="padding-left: 10; padding-top: 10; padding-right: 10; background-color: #F0F8FF">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
             <tr><td height="30px"></td></tr>
             <tr>
                <td align="center">
                    <table width="50%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center">
                                 <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <i class="fa fa-trophy fa-5x"></i>
                                                </div>
                                                <div class="col-xs-8 text-center">
                                                    <div class="huge">RANKING</div>
                                                    <div><?=$ftt_prv_nome?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td colspan="100" align="right">
                                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td align="center"><i style="color:#CFCFCF" class="fa fa-star fa-1x"></i></td>
                                                                    <td>&nbsp;</td>
                                                                    <td align="center"><h5>Entrevistado(a)</h5></td>
                                                                    <td>&nbsp;</td>
                                                                    <td align="center"><i style="color:#FFD700" class="fa fa-star fa-1x"></i></td>
                                                                    <td>&nbsp;</td>
                                                                    <td align="center"><h5>Contratado(a)</h5></td>
                                                                </tr>    
                                                            </table>
                                                        </td>
                                                    </tr>    
                                                 
                                                
                                                   <?
                                                    $sSql = "
                                                          select 
                                                          ftt_can_id,
                                                          ftt_can_nome,
                                                          ftt_can_proc_status,
                                                          vtt_vwr_iTotalPerguntas, 
                                                          vtt_vwr_iTotalPontos, 
                                                          vtt_vwt_iTotalCorreto, 
                                                          vtt_vwt_iTotalErrado, 
                                                          vtt_vwt_iTotalAnuladoCandidato, 
                                                          vtt_vwt_iTotalAnuladoTempo, 
                                                          vtt_vwt_tempo_teste, 
                                                          vtt_vwt_tempo_total_seg, 
                                                          vtt_vwt_id_candidato, 
                                                          vtt_vwt_chave,
                                                          vtt_vwt_prova
                                                          from ftt_view_ranking 
                                                          inner join ftt_candidato on ftt_can_id = vtt_vwt_id_candidato 
                                                          where vtt_vwt_chave = '$sChave' 
                                                          order by vtt_vwr_iTotalPontos desc, vtt_vwt_tempo_total_seg asc, vtt_vwt_iTotalAnuladoCandidato asc, vtt_vwt_iTotalAnuladoTempo asc
                                                        ";  
                                              //                                                                                          echo $sSql."<BR>";

                                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                                    if ($SqlResult_1->NumRows() > 0) {
                                                         $count = 1;
                                                         
                                                        echo "<tr height=40 bgcolor=#3278b4>
                                                                <td align=center></td>
                                                                <td>&nbsp;&nbsp;</td>    
                                                                <td width=10% align=center></td>
                                                                <td>&nbsp;&nbsp;</td>    
                                                                <td width=70% valign=bottom><font color=white><b>Candidato</b></font></td>
                                                                <td>&nbsp;&nbsp;</td>    
                                                                <td width=10% align=center valign=bottom><font color=white><b>Pontos</b></font></td>
                                                                <td>&nbsp;&nbsp;</td>    
                                                                <td width=10% align=center valign=bottom><font color=white><b>Tempo</b></font></td>
                                                                <td>&nbsp;&nbsp;</td>    
                                                                <td width=10% align=center valign=bottom><font color=white><b>Anulada Candidato</b></font></td>
                                                                <td>&nbsp;&nbsp;</td>    
                                                                <td width=10% align=center valign=bottom><font color=white><b>Anulada Tempo</b></font></td>
                                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                              </tr>
                                                              <tr><td colspan=30 bgcolor=#104E8B height=2px></td></tr>
                                                              <tr><td colspan=10 height=10></td></tr>
                                                                ";

                                                         while (!$SqlResult_1->EOF) {
                                                            $ftt_can_id                     = $SqlResult_1->fields["ftt_can_id"];                  
                                                            $ftt_can_nome                   = $SqlResult_1->fields["ftt_can_nome"];                              
                                                            $ftt_can_proc_status            = $SqlResult_1->fields["ftt_can_proc_status"];                              
                                                            $vtt_vwr_iTotalPontos           = $SqlResult_1->fields["vtt_vwr_iTotalPontos"]; 
                                                            $vtt_vwt_tempo_teste            = $SqlResult_1->fields["vtt_vwt_tempo_teste"];
                                                            $vtt_vwt_prova                  = $SqlResult_1->fields["vtt_vwt_prova"];
                                                            $vtt_vwt_iTotalAnuladoCandidato = $SqlResult_1->fields["vtt_vwt_iTotalAnuladoCandidato"];
                                                            $vtt_vwt_iTotalAnuladoTempo     = $SqlResult_1->fields["vtt_vwt_iTotalAnuladoTempo"];
                                                            
                                                            switch ($ftt_can_proc_status) {
                                                                case "1":
                                                                    $img_ftt_can_proc_status = "<i style=\"color:#CFCFCF\" class=\"fa fa-star fa-2x\"></i>"; 
                                                                    break;
                                                                case "2":
                                                                    $img_ftt_can_proc_status = "<i style=\"color:#FFD700\" class=\"fa fa-star fa-2x\"></i>"; 
                                                                    break;
                                                                default:
                                                                    $img_ftt_can_proc_status = ""; 
                                                                    break;
                                                            }

                                                            $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/candidatos/cadastro/modal.php?ftt_can_id=$ftt_can_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                                            
                                                            echo "<tr style='border-bottom: thin solid #cccccc' height=40>
                                                                    <td>".$img_ftt_can_proc_status."</td>    
                                                                    <td>&nbsp;&nbsp;</td>    
                                                                    <td width=10% align=center>".$count."º</td>
                                                                    <td>&nbsp;&nbsp;</td>    
                                                                    <td width=70%><a $linkEdit><font color=#111111>$ftt_can_nome</font></a></td>
                                                                    <td>&nbsp;&nbsp;</td>    
                                                                    <td width=10% align=center>$vtt_vwr_iTotalPontos</td>
                                                                    <td>&nbsp;&nbsp;</td>    
                                                                    <td width=10% align=center>$vtt_vwt_tempo_teste</td>
                                                                    <td>&nbsp;&nbsp;</td>    
                                                                    <td width=10% align=center>$vtt_vwt_iTotalAnuladoCandidato</td>
                                                                    <td>&nbsp;&nbsp;</td>    
                                                                    <td width=10% align=center>$vtt_vwt_iTotalAnuladoTempo</td>
                                                                    <td>&nbsp;&nbsp;&nbsp;</td>
                                                                  </tr>
                                                                  <tr><td colspan=10 height=10></td></tr>
                                                                    ";
                                                            
                                                            $count++;
                                                            
                                                            $SqlResult_1->MoveNext();
                                                            
                                                         }
                                                    }                                                   
                                                   
                                                   ?> 
                                             </table>   
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table> 
                </td>    
             </tr> 
             <tr><td align="right" height="10px"></td></tr>
             <tr><td height="30px"></td></tr>
      </table>
      
  </body>
  
    <?fAbreMaximizado();?> 
</html>