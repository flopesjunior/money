<?php

require_once('../atena.ini.php');

    $ftt_can_id = $_SESSION['aDadosCandidatoTeste']["ftt_can_id"];
    $pag        = $_GET["pag"];    
    
    if (!$pag) {
        echo "<script>window.location.href = '".$sUrlRaiz."atena/f3.php?pag=1'</script>";
    }     
    
    if ($ftt_can_id == ""){
        echo "Não existe sessão em aberto";
        exit;
    }
    else {

            $aRetorno = array();
            $aRetorno = sCarrgaSessaoTesteEmExecucao($ftt_can_id);
            
            if ($aRetorno["seg_execucao"] > $aRetorno["ftt_prv_tempo_segundos"]){
                echo "Tempo expirado";
                exit;
            }
            else {
                $segundos_executado = $aRetorno["ftt_prv_tempo_segundos"] - $aRetorno["seg_execucao"];
            }
            
            if (count($aRetorno) == 0){
                echo "Problemas ao acessar o teste";
                exit;
            }            

            
//        }
    }
    
   
    
    $aPaginacao      = array();
    $aPaginacao      = $_SESSION['aPaginacaoTesteCandidato'];
    $iCountPaginacao = count($aPaginacao);
    
    $ftt_per_id      = $aPaginacao[$pag - 1];        
    
//    $sSql = "
//               select 
//               count(*) as qtd_questoes
//               from ftt_teste_perguntas 
//               where ftt_tsp_id_teste = ".$aRetorno["ftt_tst_id"];  
//                   
//   $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");        
   $qtd_questoes  = $iCountPaginacao;
   
   
   
    $sSql = "
               select 
               ftt_tsp_id,
               ftt_per_id, 
               ftt_per_descricao, 
               ftt_per_tipo, 
               ftt_per_nivel, 
               ftt_per_data_cadastro, 
               ftt_per_id_especialidade,
               ftt_esp_descricao,
               ftt_tsp_ordem,
               ftt_tsp_id_teste,
               ftt_tsp_inicio,
               ftt_tsp_fim
               from ftt_pergunta 
               INNER JOIN ftt_especialidade ON (ftt_esp_id = ftt_per_id_especialidade)
               INNER JOIN ftt_teste_perguntas ON (ftt_tsp_id_pergunta = ftt_per_id)
               where ftt_tsp_id_teste = ".$aRetorno["ftt_tst_id"]." AND ftt_tsp_respondida = 0
               ORDER BY ftt_tsp_ordem asc
               LIMIT 1
       ";  
//                                           echo $sSql."<BR>";

   $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    


   if ($SqlResult_1->NumRows() > 0) {
        $ftt_tsp_id                    = $SqlResult_1->fields["ftt_tsp_id"];         
        $ftt_per_id                    = $SqlResult_1->fields["ftt_per_id"];                              
        $ftt_per_descricao             = $SqlResult_1->fields["ftt_per_descricao"]; 
        $ftt_per_tipo                  = $SqlResult_1->fields["ftt_per_tipo"];
        $ftt_per_nivel                 = $SqlResult_1->fields["ftt_per_nivel"];
        $ftt_per_data_cadastro         = $SqlResult_1->fields["ftt_per_data_cadastro"];
        $ftt_per_id_especialidade      = $SqlResult_1->fields["ftt_per_id_especialidade"];
        $ftt_esp_descricao             = utf8_encode($SqlResult_1->fields["ftt_esp_descricao"]);   
        $ftt_tsp_ordem                 = $SqlResult_1->fields["ftt_tsp_ordem"];  
        $ftt_tsp_id_teste              = $SqlResult_1->fields["ftt_tsp_id_teste"];  
        $ftt_tsp_inicio                = $SqlResult_1->fields["ftt_tsp_inicio"];  
        $ftt_tsp_fim                   = $SqlResult_1->fields["ftt_tsp_fim"];  
        
        if (!$ftt_tsp_inicio){
            $sSql = "UPDATE ftt_teste_perguntas SET ftt_tsp_inicio = NOW()  WHERE ftt_tsp_id = $ftt_tsp_id";
            $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);            
        }
        
        
//        echo "<script>startCountdown();</script>";
        
   }      
   else {
       
       if ($aRetorno["ftt_tst_carrecao"] == "S"){
           $ftt_tst_status = 3;
       }
       else {
           $ftt_tst_status = 4;
       }
       
       $sSql = "UPDATE ftt_teste SET ftt_tst_status = $ftt_tst_status, ftt_tst_data_fim = NOW()  WHERE ftt_tst_id = ".$aRetorno["ftt_tst_id"];
       $dbsis_mysql->Execute($sSql) or die("ERRx001:INSERE CONTEUDO - \n ".$sSql);
       
       echo "<script>window.location.href = '".$sUrlRaiz."atena/f4.php'</script>";
   } 
                   
    
?>

<html>
  <head>
    <title><?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    <script language="JavaScript" src="<?=$sUrlRaiz?>atena/js.js" type="text/javascript" ></script>   
    
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       
    <script language="JavaScript" src="<?=$sUrlRaiz?>ext/jquery.bootpag.min.js"></script>
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
    
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>     
    
       <?inclui_fav();?>
<script>
var segundos = new Number();
segundos = <?=$segundos_executado?>;

function startCountdown(){

  if((segundos - 1) >= 0){

    var segundo = parseInt(segundos % 60); 
    var minutos = segundos / 60; 
    var minuto = parseInt(minutos % 60); 
    var hora = parseInt(minutos / 60); 
    
    // Formata o número menor que dez, ex: 08, 07, ...
      if(hora < 10){
          hora = "0"+hora;
          hora = hora.substr(0, 2);
      }
      // Formata o número menor que dez, ex: 08, 07, ...
      if(minuto < 10){
          minuto = "0"+minuto;
          minuto = minuto.substr(0, 2);
      }

      if(segundo <=9){
          segundo = "0"+segundo;
      }
      
      // Cria a variável para formatar no estilo hora/cronômetro
      var horaImprimivel = hora + ':' + minuto + ':' + segundo;

      //JQuery pra setar o valor
      document.getElementById('timer').innerHTML = horaImprimivel;      
    
      setTimeout('startCountdown()',1000);
      
      segundos--;
  }
  else {
      window.location.href = '<?=$sUrlRaiz?>atena/f5.php';
  }  
}


</script>
  </head>
  <body style="background-color: #ffffff; padding-left: 10; padding-top: 10; padding-right: 10" onload="startCountdown();startBloqueio();" >
      <input type="hidden" value="<?=$iEquipe?>" id="iEquipe" name="iEquipe">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
      <input type="hidden" value="<?=$ftt_can_id?>" id="ftt_can_id" name="ftt_can_id">  
      <input type="hidden" value="<?=$ftt_tsp_id?>" id="_ftt_tsp_id" name="_ftt_tsp_id">  
      <input type="hidden" value="<?=$ftt_per_id?>" id="ftt_per_id" name="ftt_per_id">  
      <input type="hidden" value="<?=$ftt_per_tipo?>" id="ftt_per_tipo" name="ftt_per_tipo">  
      <input type="hidden" value="<?=$ftt_tsp_id_teste?>" id="ftt_tsp_id_teste" name="ftt_tsp_id_teste">  
      <input type="hidden" value="<?=$segundos_executado?>" id="segundos_executado" name="segundos_executado">  
      <input type="hidden" value="<?=$aRetorno["ftt_tst_id"]?>" id="ftt_tst_id" name="ftt_tst_id">  
 
      
       <?cabecalho();?>
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right" nowrap>
                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td nowrap valign="center">                
                           <i class="fa fa-edit"></i>
                        </td>
                        <td>&nbsp;</td>
                        <td nowrap valign="center">                     
                            <h4><?=$ftt_tsp_ordem?>/<?=$qtd_questoes?></h4>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td nowrap valign="center">                
                           <i class="fa fa-clock-o"></i>
                        </td>
                        <td>&nbsp;</td>
                        <td nowrap valign="center">                     
                            <h4><div id="timer"></div></h4>
                        </td>
                    </tr> 
                </table>    
            </td>
        </tr>    
        <tr>
                <td align="center">
                    <table width="50%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="left">
                                                    <table width ="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="1%" nowrap>
                                                                <h3><b>Questão #<?=$ftt_tsp_ordem?></b></h3>
                                                            </td>
                                                            <td width="99%" align="right">
                                                                 <h6><font color="#CCCCCC"><?=$ftt_esp_descricao?> - ref: <?=$ftt_per_id?></font></h6>
                                                            </td>
                                                        </tr>
                                                    </table> 
                                                </td>    
                                            </tr>     
                                            <tr><td height="10px"></td></tr>    
                                            <tr>
                                                <td>
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <?=$ftt_per_descricao?>
                                                            </td>
                                                        </tr>
                                                    </table> 
                                                </td>    
                                            </tr>
                                            
                                            <?
                                            if ($ftt_per_tipo == 3){
                                                echo "
                                               <tr><td height=\"10px\"></td></tr>     
                                               <tr>
                                                  <td>
                                                      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                                          <tr>
                                                              <td>
                                                                   <mark>Você pode selecionar qualquer número de resposta (uma, ou mais que uma)</mark>
                                                              </td>
                                                          </tr>
                                                      </table> 
                                                  </td>    
                                               </tr>";     
                                            }    
                                            ?>
                                            
                                            <tr><td height="30px"></td></tr>    
                                            
                                            <?
                                            if ($ftt_per_tipo == 2 || $ftt_per_tipo == 3) {

                                                       $sSql = "
                                                                select 
                                                                   ftt_alt_id, 
                                                                   ftt_alt_desc, 
                                                                   ftt_alt_correta, 
                                                                   ftt_alt_id_pergunta, 
                                                                   ftt_vwa_selecionada,
                                                                   ftt_vwa_ordem
                                                                from ftt_view_alternativas
                                                                inner join ftt_pergunta_alternativas on ftt_vwa_id_alterativa = ftt_alt_id
                                                                where 
                                                                    ftt_vwa_id_teste = ".$aRetorno["ftt_tst_id"]." and
                                                                    ftt_vwa_id_candidato = $ftt_can_id and 
                                                                    ftt_vwa_id_pergunta = $ftt_per_id    
                                                                order by ftt_vwa_ordem
                                                          ";  
//                                                                                          echo $sSql."<BR>";

                                                      $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx002:serial_Listen <BR> $sSql");    

                                                      $aEspecialidade = array();

                                                      if ($SqlResult_1->NumRows() > 0) {
                                                          
                                                           $iCount = 1;
                                                           
                                                           while (!$SqlResult_1->EOF) {
                                                              $ftt_alt_id               = $SqlResult_1->fields["ftt_alt_id"];                              
                                                              $ftt_alt_desc             = $SqlResult_1->fields["ftt_alt_desc"]; 
                                                              $ftt_alt_correta          = $SqlResult_1->fields["ftt_alt_correta"];
                                                              $ftt_vwa_ordem            = $SqlResult_1->fields["ftt_vwa_ordem"];
                                                              $ftt_vwa_selecionada      = $SqlResult_1->fields["ftt_vwa_selecionada"];
                                                              
                                                              $ftt_alt_ordem = $ftt_vwa_ordem;
                                                              
                                                              if (trim($ftt_alt_desc)!=""){
                                                               echo "
                                                                       <tr>
                                                                          <td align=\"left\">
                                                                              <table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                                                                  <tr>
                                                                                      <td>
                                                                                         <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">   
                                                                                            <tr>
                                                                                              <td width=1%>
                                                                                                    
                                                                                                  <input type=hidden name=\"Selected\" id=\"Selected_$ftt_alt_ordem\">
                                                                                                  <input type=hidden name=\"optionsAlternativas\" id=\"optionsAlternativas_$ftt_alt_ordem\" value=$ftt_alt_id>
                                                                                                  <div id=alt_$ftt_alt_ordem><button type='button' class='btn btn-default btn-circle'  onclick=seleciona_alternativa($ftt_alt_ordem)>$ftt_alt_ordem</button></div>
                                                                                              </td>    
                                                                                              <td>&nbsp;&nbsp;</td>    
                                                                                              <td width=99% style=\"text-align: center\" >
                                                                                                <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">  
                                                                                                    <tr><td height=10px></td></tr>
                                                                                                    <tr>
                                                                                                      <td width=1%>
                                                                                                        $ftt_alt_desc
                                                                                                      </td>
                                                                                                  </tr>
                                                                                                </table>   
                                                                                              </td>
                                                                                            </tr>
                                                                                            <tr><td colspan=10 height=\"10px\"></td></tr> 
                                                                                         </table>   
                                                                                      </td>
                                                                                  </tr>
                                                                              </table> 
                                                                          </td>    
                                                                       </tr>   
                                                                       <tr><td colspan=10 height=\"10px\"></td></tr> 
                                                                       ";
                                                               }
                                                               
                                                               $iCount++;
                                                               
                                                               $SqlResult_1->MoveNext();

                                                            }  
                                                      }        

                                            }  
                                                      
                                            else if ($ftt_per_tipo == 1) {

                                                               echo "
                                                                       <tr>
                                                                          <td align=\"left\">
                                                                                <div id=\"ftt_tsp_resp_dissertativa\" name=\"ftt_tsp_resp_dissertativa\"></div>
                                                                                <script>
                                                                                    $(document).ready(function() {
                                                                                        $('#ftt_tsp_resp_dissertativa').summernote({
                                                                                            height: 200
                                                                                        });
                                                                                    });
                                                                                </script> 
                                                                          </td>    
                                                                       </tr>                             


                                                                       ";


                                            }

                                            ?>
                                </table>                                 
                                
                            </td>
                        </tr>
                    </table> 
                </td>    
            </tr>               
            <tr><td height="30px"></td></tr>
            <tr><td height="1" bgcolor="#CCCCCC"></td></tr>
            <tr><td height="30px"></td></tr>
            <tr>
                <td align="center">
                    <table width="50%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger btn-lg" onclick="anula_questao();">EU NÃO SEI</button>
                            </td>
                            <td>&nbsp;&nbsp;</td>
                            <td align="right">
                                <button type="button" class="btn btn-success btn-lg" onclick="registra_questao();">ENVIAR</button>
                            </td>
                        </tr>
                    </table> 
                </td>    
            </tr> 
            <tr>
                <td align="center">
                   <table width="50%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger btn-lg" onclick="anula_questao();">EU NÃO SEI</button>
                            </td>
                            <td>&nbsp;&nbsp;</td>
                            <td align="right">
                                <button type="button" class="btn btn-success btn-lg" onclick="registra_questao();">ENVIAR</button>
                            </td>
                        </tr>
                    </table> 
                </td>    
            </tr> 

            <tr><td align="right" height="10px"></td></tr>
            <tr><td height="30px"></td></tr>
      </table>
      <?//=$sModal?>
  
     
      
      
      
  </body>
  
  
</html>