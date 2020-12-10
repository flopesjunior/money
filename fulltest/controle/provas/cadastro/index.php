<?
require_once('../../../indicadores.ini.php');

$apu_zon_id_filtro = $_GET["apu_zon_id_filtro"];
//if (!$iEquipe || $iEquipe > $iIndiceEquipe){
//        echo "<script>alert(\"Equipe invalida\");</script>";
//
//    exit;
//}

//$aRetorno = fMontaOpcoesCombo_Demandas($iEquipe);
//
//$EquipeCod = $aRetorno[0];
//$sEquipe   = $aRetorno[1];

?>

<html>
  <head>
    <title>PROVAS <?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/provas/cadastro/js.js" type="text/javascript" ></script>
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       

<!-- MetisMenu CSS -->
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../../../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    
    <style type="text/css" class="init">
        div.dataTables_wrapper {
                margin-bottom: 3em;
        }      
            
        table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
            font-size: 12px;
        }      
        
        td.details-control {
            background: url('details_open.png') no-repeat center center !important;
            cursor: pointer;
        }
        
        tr.shown td.details-control {
            background: url('details_close.png') no-repeat center center !important;
        }
        
      .modal-content {
            position: relative;
            background-color: #fff;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 1px solid #999;
            border: 1px solid rgba(0,0,0,.2);
            border-radius: 6px;
            outline: 0;
            -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
            box-shadow: 0 3px 9px rgba(0,0,0,.5);
            width: 1024px;
        }     
        
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
            font-size: smaller;
        }  
        
        .modal {
            position: fixed;
            top: 0;
            right: 400;
            bottom: 0;
            left: 0;
            z-index: 1050;
            display: none;
            overflow: hidden;
            -webkit-overflow-scrolling: touch;
            outline: 0;
        }      
        
        
        .fa-star:before {
            content: "\f005";
            color: #125acd;
            font-size: medium;
        }            
        
    </style>
        
    <script>
        function abrejanela(ind_prj_WBS, iEquipe){
            window.open("<?=$sUrlRaiz?>controle/projeto/prj_projetos/modal.php?ind_prj_WBS="+ind_prj_WBS+"&iEquipe="+iEquipe, 'modal');
        }
        function abrejanelaPDF(ind_prj_TipoCodigo){
            window.open("<?=$sUrlRaiz?>controle/projeto/prj_projetos/pdf.php?ind_prj_TipoCodigo="+ind_prj_TipoCodigo, 'lancamento');
        }
        function abrejanelaVencimentos(ind_prj_WBS, ind_prj_UID, iEquipe, ind_prj_ManualFinish_sf,ind_prj_ManualFinish){
            window.open("<?=$sUrlRaiz?>controle/projeto/prj_projetos/modal_venc.php?ind_prj_UID="+ind_prj_UID+"&ind_prj_WBS="+ind_prj_WBS+"&iEquipe="+iEquipe+"&ind_prj_ManualFinish_sf="+ind_prj_ManualFinish_sf+"&ind_prj_ManualFinish="+ind_prj_ManualFinish, 'modal2');
        }
    </script>  
    
        <?inclui_fav();?>
  </head>
  <body style="padding-left: 10; padding-top: 10; padding-right: 10">
      <input type="hidden" value="<?=$iEquipe?>" id="iEquipe" name="iEquipe">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
             <?
             $sTitulo = "CADASTRO DAS PROVAS ";
             $sUrlAlvo = $sUrlRaiz."controle/projeto/prj_projetos/";
             echo fMontaCabecalho($sUrlAlvo, $sTitulo);
             
             $link = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/provas/cadastro/modal.php','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
             
             ?>   
          
          
             <tr><td height="30px"></td></tr>
             <tr>
                <td>
                    <table width="1%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <button type="button" class="btn btn-primary" <?=$link?>>NOVO</button>
                            </td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?=$sUrlRaiz?>controle/provas/cadastro/index.php'">ATUALIZAR</button>
                            </td>
                        </tr>
                    </table> 
                </td>    
             </tr> 
             <tr>
                 <td width="1%" nowrap  align="center">
                     
                   
                        
                     
                         <?
                         
                                    $sDisplay = "";
                                     
                                    $sSql = "
                                        select 	
                                                ftt_prv_id, 
                                                ftt_prv_descricao, 
                                                ftt_prv_nome,
                                                ftt_prv_tempo, 
                                                ftt_prv_nivel, 
                                                ftt_prv_data_cadastro, 
                                                ftt_prv_data_ultalt
                                                from ftt_prova 
                                                ORDER BY ftt_prv_descricao
                                        ";  
//                                    echo $sSql."<BR>";
                                    
                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                    $sDisplay .= "    
                                        <table id=\"tabela001$iCount\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                             <thead>
                                                <tr>
                                                    <th width=\"1%\"></th>
                                                    <th width=\"1%\"></th>
                                                    <th width=\"1%\">#</th>
                                                    <th width=\"1%\">Nome</th>
                                                    <th width=\"1%\">Tempo</th>
                                                    <th width=\"97%\">&nbsp;</th>
                                                </tr>    
                                             </thead>  
                                             <tbody>
                                            ";  
                                    
                                    if ($SqlResult_1->NumRows() > 0) {

                                        $iCount = 1;
                                        $iCount2 = 1;
                                        $sModal   = "";
                                        
                                        while (!$SqlResult_1->EOF) {
                                            $ftt_prv_id                    = $SqlResult_1->fields["ftt_prv_id"];                              
                                            $ftt_prv_descricao             = $SqlResult_1->fields["ftt_prv_descricao"]; 
                                            $ftt_prv_nome                  = $SqlResult_1->fields["ftt_prv_nome"]; 
                                            $ftt_prv_tempo                  = $SqlResult_1->fields["ftt_prv_tempo"];
                                            $ftt_prv_nivel                 = $SqlResult_1->fields["ftt_prv_nivel"];
                                            $ftt_prv_data_cadastro         = $SqlResult_1->fields["ftt_prv_data_cadastro"];
                                            
                                            if (strlen($ftt_prv_descricao) > 100){
                                                $ftt_prv_descricao = substr($ftt_prv_descricao, 0, 100)."...";
                                            }
                                            
                                            $Tempo = m2h($ftt_prv_tempo);
                                            
                                            $linkEdit    = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/provas/cadastro/modal.php?ftt_prv_id=$ftt_prv_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                            $linkRanking = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/provas/cadastro/ranking.php?ftt_prv_id=$ftt_prv_id','ranking','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                            $linkDel     = "onClick=\"deleta_prova($ftt_prv_id);\"";
                                            
                                            $sDisplay .= "
                                                       <tr>  
                                                         <td width=1%>
                                                            <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit ><i class=\"fa fa-list\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                           <button type=\"button\" class=\"btn btn-default btn-circle\"  ><i class=\"fa  fa-times\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                           <button type=\"button\" class=\"btn btn-default btn-circle\" $linkRanking ><i class=\"fa  fa-trophy\"></i></button>
                                                         </td>
                                                         <td width=1%>
                                                            $iCount 
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_prv_nome 
                                                         </td>
                                                         <td>
                                                            $Tempo 
                                                         </td>
                                                         <td>
                                                             &nbsp;
                                                         </td>
                                                       </tr>

                                            ";


                                            $iCount++;
                                            $iCount2++;

                                            $SqlResult_1->MoveNext();

                                        }

   
                                        

                                    }
                                    
                                    $sDisplay .= "</tbody></table>";        

                                    echo $sDisplay;
                                    
                         ?>
                         
                 </td>
             </tr>
             <tr><td align="right" height="10px"></td></tr>
             <tr><td height="30px"></td></tr>
      </table>
      <?//=$sModal?>
  
      <script>
            var table = $('table.display').DataTable({
                               "className": 'details-control',
                               "paging":   false,
                               "ordering": false,
                               "info":     false,
                               "language": {
                                           "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                                       }                    
                           }   
                       );           
      </script>    
      
      
      
  </body>
  
  
</html>