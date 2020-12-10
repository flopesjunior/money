<?
require_once('../../../indicadores.ini.php');

    $ftt_per_id     = $_GET["ftt_per_id"];
    $pag            = $_GET["pag"];
    
    if (!$pag) {
        echo "<script>window.close();</script>";
    }    
    
    $btnsuccess_1 = "btn-default";
    $btnsuccess_2 = "btn-default";
    $btnsuccess_3 = "btn-default";
    $btnsuccess_4 = "btn-default";
    $btnsuccess_5 = "btn-default";
    $flagTipoResposta_1             = "checked";
    $StyleAlternativas              = "display:none";
    $ftt_per_descricao              = "";
    $ftt_per_tipo                   = "";
    $ftt_per_nivel                  = "";
    $ftt_per_data_cadastro          = "";
    $ftt_per_id_especialidade       = "";
    $ftt_esp_descricao              = "";
    $alt_correta                    = "";
    
//    if (!$ftt_per_id) {
//        $ftt_per_id = 0;
//    }
    if ($ftt_per_id) {
        $sSql = "
           select 	ftt_per_id, ftt_per_descricao, ftt_per_tipo, ftt_per_nivel, 
                   ftt_per_data_cadastro, 
                   ftt_per_id_especialidade,
                   ftt_esp_descricao
                   from ftt_pergunta 
                   INNER JOIN ftt_especialidade ON (ftt_esp_id = ftt_per_id_especialidade)
                   where ftt_per_id = $ftt_per_id
                   ORDER BY ftt_per_id_especialidade, ftt_per_nivel, ftt_per_id
                   
           ";  
       //                                    echo $sSql."<BR>";

       $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


       if ($SqlResult_1->NumRows() > 0) {

               $ftt_per_id                    = $SqlResult_1->fields["ftt_per_id"];                              
               $ftt_per_descricao             = $SqlResult_1->fields["ftt_per_descricao"]; 
               $ftt_per_tipo                  = $SqlResult_1->fields["ftt_per_tipo"];
               $ftt_per_nivel                 = $SqlResult_1->fields["ftt_per_nivel"];
               $ftt_per_data_cadastro         = $SqlResult_1->fields["ftt_per_data_cadastro"];
               $ftt_per_id_especialidade      = $SqlResult_1->fields["ftt_per_id_especialidade"];
               $ftt_esp_descricao             = $SqlResult_1->fields["ftt_esp_descricao"];    
       }
       
       if ($ftt_per_tipo == 1){
           $StyleAlternativas = "display:none";
           $flagTipoResposta_1 = "checked";
           $flagTipoResposta_2 = "";
           $flagTipoResposta_3 = "";
       }
       elseif ($ftt_per_tipo == 2){
           $StyleAlternativas = "display:block";
           $flagTipoResposta_1 = "";
           $flagTipoResposta_2 = "checked";
           $flagTipoResposta_3 = "";
       }
       elseif ($ftt_per_tipo == 3){
           $StyleAlternativas = "display:block";
           $flagTipoResposta_1 = "";
           $flagTipoResposta_2 = "";
           $flagTipoResposta_3 = "checked";
       }
       
        $sSql = "
                    select ftt_alt_id, ftt_alt_desc, ftt_alt_correta, ftt_alt_id_pergunta, 
                 ftt_alt_ordem
                 from 
                 ftt_pergunta_alternativas 
                            where ftt_alt_id_pergunta = $ftt_per_id
                   
           ";  
       //                                    echo $sSql."<BR>";

       $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    

       $aEspecialidade = array();
       
       if ($SqlResult_1->NumRows() > 0) {
           
            while (!$SqlResult_1->EOF) {
               $ftt_alt_id               = $SqlResult_1->fields["ftt_alt_id"];                              
               $ftt_alt_desc             = $SqlResult_1->fields["ftt_alt_desc"]; 
               $ftt_alt_correta          = $SqlResult_1->fields["ftt_alt_correta"];
               $ftt_alt_ordem            = $SqlResult_1->fields["ftt_alt_ordem"];

               switch ($ftt_alt_ordem) {
                   case 1:
                       $txt_alternativa_1 = $ftt_alt_desc;
                       if ($ftt_alt_correta=="S") {
                           $btnsuccess_1 = "btn-success";
                           $alt_correta = 1;
                           $flag_alternativa_1 = "checked";
                       }    
                       break;
                   case 2:
                       $txt_alternativa_2 = $ftt_alt_desc;
                       if ($ftt_alt_correta=="S") {
                           $btnsuccess_2 = "btn-success";
                           $alt_correta = 2;
                           $flag_alternativa_2 = "checked";
                       }    
                       break;
                   case 3:
                       $txt_alternativa_3 = $ftt_alt_desc;
                       if ($ftt_alt_correta=="S") {
                           $btnsuccess_3 = "btn-success";
                           $alt_correta = 3;
                           $flag_alternativa_3 = "checked";
                       }    
                       break;
                   case 4:
                       $txt_alternativa_4 = $ftt_alt_desc;
                       if ($ftt_alt_correta=="S") {
                           $btnsuccess_4 = "btn-success";
                           $alt_correta = 4;
                           $flag_alternativa_4 = "checked";
                       }    
                       break;
                   case 5:
                       $txt_alternativa_5 = $ftt_alt_desc;
                       if ($ftt_alt_correta=="S") {
                           $btnsuccess_5 = "btn-success";
                           $alt_correta = 5;
                           $flag_alternativa_5 = "checked";
                       }    
                       break;
               }
               

                $SqlResult_1->MoveNext();

             }           

       }       
}
?>

 <html>
  <head>
    <title>CADASTRO DAS QUESTÕES - <?=$sNomeSistema?></title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/questoes/cadastro/js.js" type="text/javascript" ></script>

    
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">       
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       
    
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../../../dist/css/timeline.css" rel="stylesheet">
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>     
    
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>    
    
    <style>
        .sla1 {
            background-color: #F0FBEF !important;
        }

        .sla2 {
            background-color: #F9EFD1 !important;
        }
        
        .sla3 {
            background-color: #ff3333 !important;
        }
        
        table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
            font-size: 12px;
        }        
        
        .body2 {
            height: 215px;
        }
        
        .row-centered {
            text-align:center;
        }
        
        .col-centered {
            display:inline-block;
            float:none;
            text-align:left;
            margin-right:-4px;
        }    
        .teste {
            display: none;
        }
    </style>    
    
    
  </head>    
  
  <body style="margin-left: 12px; margin-right: 12px; margin-top: 12px">
  <form name="apuracao" method="post" enctype="text/plain" action="<?=$PHP_SELF?>">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">
      <input type="hidden" value="<?=$ftt_per_id?>" id="ftt_per_id" name="ftt_per_id">
      <input type="hidden" value="<?=$alt_correta?>" id="ftt_alt_correta" name="ftt_alt_correta">

    <div class="row">
       <?
       $sTitulo = "CADASTRO DAS QUESTÕES";
       
        $link_view = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/questoes/cadastro/view.php?pag=$pag','view','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";

       ?>                          
   </div>
      
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div><h1>Cadastro de Questões</h1></div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" >
                        <div class='row'>
                            <table cellpadding=0 cellspacing=0 border=0 width=100%>
                                <tr>
                                    <td width="1%">
                                        <table cellpadding=0 cellspacing=0 border=0 width=1%>
                                            <tr><td colspan="20" height="10"></td></td>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align=left>
                                                    <button onclick="window.location.href = '<?=$sUrlRaiz?>controle/questoes/cadastro/modal.php'" type="button" class="btn btn-warning">NOVO</button> 
                                                </td>    
                                                <td>&nbsp;&nbsp;</td>
                                                <td align=left>
                                                     <button onclick="registrar_pergunta();" type="button" class="btn btn-success">SALVAR</button> 
                                                </td>                                         
                                                <td>&nbsp;&nbsp;</td>
                                                <td align=left>
                                                    <button onclick="window.close();opener.location.reload();" type="button" class="btn btn-default">FECHAR</button></center>
                                                </td>                                                        
                                            </tr>  
                                            <tr><td colspan="20" height="10"></td></td>
                                        </table>                                
                                    </td>
                                    <td width="99%" align="right">
                                        <button <?=$link_view?> type="button" class="btn btn-default"><i class="fa  fa-eye"></i></button></center>
                                    </td> 
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                        </div>                    
                        <div class='row'>
                            <div class='col-xs-12 text-right'>
                                <div class='huge'>
                                    <center>
                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                        <tr>
                                            <td align=left>
                                                <h4>Digite a questão:<h4/> 
                                            </td>
                                        </tr>    
                                        <tr>    
                                            <td align=left>
                                                <div id="ftt_per_descricao" name="ftt_per_descricao"><?=$ftt_per_descricao?></div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#ftt_per_descricao').summernote({
                                                            height: 150
                                                        });
                                                    });
                                                </script>                                                
                                                
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td align=left>
                                                <h4>Selecione o nível de dificuldade:<h4/> 
                                            </td>
                                        </tr>                                         
                                        <tr>    
                                            <td align=left>
                                                <div class="form-group">
                                                    
                                                    <?
                                                           $checked_1 = "";
                                                           $checked_2 = "";
                                                           $checked_3 = "";
                                                           $checked_4 = "";
                                                           switch ($ftt_per_nivel) {
                                                               case 1:
                                                                   $checked_1 = "checked";
                                                                   break;
                                                               case 2:
                                                                   $checked_2 = "checked";
                                                                   break;
                                                               case 3:
                                                                   $checked_3 = "checked";
                                                                   break;
                                                               case 4:
                                                                   $checked_4 = "checked";
                                                                   break;
                                                               default:
                                                                   $checked_1 = "checked";
                                                           }
                                                    ?>
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="1" <?=$checked_1?>>Iniciante
                                                        </label>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="2" <?=$checked_2?>>Júnior
                                                        </label>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="3" <?=$checked_3?>>Pleno
                                                        </label>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_nivel" value="4" <?=$checked_4?>>Senior
                                                        </label>
                                                    </div>
                                                </div>                                       
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align=left>
                                                <h4>Selecione a especialidade:<h4/> 
                                            </td>
                                        </tr>                                         
                                        <tr>    
                                            <td align=left>
                                                <div class="form-group">
                                                    <select class="form-control" id="ftt_per_id_especialidade" value="3">
                                                            <option value='0'>Selecione</option>
                                                        <?
                                                            $sSql = "
                                                            select 
                                                            ftt_esp_id, 
                                                            ftt_esp_descricao 
                                                            from 
                                                            ftt_especialidade
                                                            order by ftt_esp_descricao
                                                            ";  
//                                    echo $sSql."<BR>";
                                    
                                                            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                            if ($SqlResult_1->NumRows() > 0) {

                                                                while (!$SqlResult_1->EOF) {

                                                                    $ftt_esp_id                     = $SqlResult_1->fields["ftt_esp_id"];                              
                                                                    $ftt_esp_descricao              = utf8_encode($SqlResult_1->fields["ftt_esp_descricao"]); 
                                                                    
                                                                    if ($ftt_per_id_especialidade == $ftt_esp_id) $flag = "selected";
                                                                    else $flag = "";
                                                                    
                                                                    echo "<option value='$ftt_esp_id' $flag>$ftt_esp_descricao</option>";
                                                                    
                                                                    $SqlResult_1->MoveNext();

                                                                 }                                                                    
                                                            }     
                                                        ?>
                                                    </select>
                                                </div>                   
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td align=left>
                                                <h4>Selecione o tipo da resposta:<h4/> 
                                            </td>
                                        </tr>                                         
                                        <tr>    
                                            <td align=left>
                                                <div class="form-group">
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_tipo" value="1" <?=$flagTipoResposta_1?> onclick="alternativas();">Dissertativa
                                                        </label>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_tipo" value="2" <?=$flagTipoResposta_2?> onclick="alternativas();">Única Alternativa 
                                                        </label>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <label>
                                                            <input type="radio" name="ftt_per_tipo" value="3" <?=$flagTipoResposta_3?> onclick="alternativas();">Multipla Escolha
                                                        </label>
                                                    </div>
                                                </div>                                       
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td align=left>
                                                <div id="alternativas" style="<?=$StyleAlternativas?>">
                                                    <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                       <tr><td height="10px" colsoan="2"></td></tr>
                                                       <tr>
                                                           <td align=left colspan="7">
                                                               <b>Importante:</b> Após digitar as alternativas, clique no numero para marcar a correta.
                                                           </td>
                                                       </tr>
                                                       <tr><td height="10px" colsoan="2"></td></tr>
                                                       <tr>
                                                           <td align=left width=2%> 
                                                               1)
                                                           </td>    
                                                           <td align=left width=3%> 
                                                               <input type="checkbox" name="chk_alternativa" id="chk_alternativa_1" onclick="seleciona_alternativa(1)" <?=$flag_alternativa_1?>>
                                                           </td>    
                                                           <td align=left width=97%>
                                                               
                                                                 <div id="txt_alternativa_1" name="txt_alternativa_1"><?=$txt_alternativa_1?></div>
                                                                 <script>
                                                                    $(document).ready(function() {
                                                                        $('#txt_alternativa_1').summernote({
                                                                            height: 50
                                                                        });
                                                                    });
                                                                 </script>         
                                                           </td>
                                                       </tr>
                                                       <tr><td height="10px" colsoan="2"></td></tr>
                                                       <tr>
                                                           <td align=left width=2%> 
                                                               2)
                                                           </td>    
                                                           <td align=left width=3%> 
                                                               <input type="checkbox" name="chk_alternativa" id="chk_alternativa_2" onclick="seleciona_alternativa(2)" <?=$flag_alternativa_2?>>
                                                           </td>    
                                                           <td align=left width=99%>
                                                                 <div id="txt_alternativa_2" name="txt_alternativa_2"><?=$txt_alternativa_2?></div>
                                                                 <script>
                                                                    $(document).ready(function() {
                                                                        $('#txt_alternativa_2').summernote({
                                                                            height: 50
                                                                        });
                                                                    });
                                                                 </script>         
                                                           </td>
                                                       </tr>
                                                       <tr><td height="10px" colsoan="2"></td></tr>
                                                       <tr>
                                                           <td align=left width=2%> 
                                                               3)
                                                           </td>    
                                                           <td align=left width=3%> 
                                                               <input type="checkbox" name="chk_alternativa" id="chk_alternativa_3" onclick="seleciona_alternativa(3)" <?=$flag_alternativa_3?>>
                                                           </td>    
                                                           <td align=left width=99%>
                                                                 <div id="txt_alternativa_3" name="txt_alternativa_3"><?=$txt_alternativa_3?></div>
                                                                 <script>
                                                                    $(document).ready(function() {
                                                                        $('#txt_alternativa_3').summernote({
                                                                            height: 50
                                                                        });
                                                                    });
                                                                 </script>                                                               
                                                           </td>
                                                       </tr>
                                                       <tr><td height="10px" colsoan="2"></td></tr>
                                                       <tr>
                                                           <td align=left width=2%> 
                                                               4)
                                                           </td>    
                                                           <td align=left width=3%> 
                                                               <input type="checkbox" name="chk_alternativa" id="chk_alternativa_4" onclick="seleciona_alternativa(4)" <?=$flag_alternativa_4?>>
                                                           </td>    
                                                           <td align=left width=99%>
                                                                 <div id="txt_alternativa_4" name="txt_alternativa_4"><?=$txt_alternativa_4?></div>
                                                                 <script>
                                                                    $(document).ready(function() {
                                                                        $('#txt_alternativa_4').summernote({
                                                                            height: 50
                                                                        });
                                                                    });
                                                                 </script>                                                                
                                                           </td>
                                                       </tr>
                                                       <tr><td height="10px" colsoan="2"></td></tr>
                                                       <tr>
                                                           <td align=left width=2%> 
                                                               5)
                                                           </td>    
                                                           <td align=left width=3%> 
                                                               <input type="checkbox" name="chk_alternativa" id="chk_alternativa_5" onclick="seleciona_alternativa(5)" <?=$flag_alternativa_5?>>
                                                           </td>    
                                                           <td align=left width=99%>
                                                                 <div id="txt_alternativa_5" name="txt_alternativa_5"><?=$txt_alternativa_5?></div>
                                                                 <script>
                                                                    $(document).ready(function() {
                                                                        $('#txt_alternativa_5').summernote({
                                                                            height: 50
                                                                        });
                                                                    });
                                                                 </script>                                                                
                                                           </td>
                                                       </tr>
                                                   </table>                                                     
                                                    
                                                    
                                                </div>                                       
                                            </td>
                                        </tr>
                                    </table>    
                                    </center>
                                </div>
                            </div>
                        </div>   
                    
                       
                       
                </div>
            </div>
        </div>
     </div>
  </form>    
  </body>
  
  <?fAbreMaximizado();?> 
  
</html>

  
  
