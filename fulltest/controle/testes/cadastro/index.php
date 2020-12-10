<?
require_once('../../../indicadores.ini.php');

?>

<html>
  <head>
    <title>TESTES <?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/testes/cadastro/js.js" type="text/javascript" ></script>
    
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
         <?inclui_fav();?>   
  </head>
  <body style="padding-left: 10; padding-top: 10; padding-right: 10">
      <input type="hidden" value="<?=$iEquipe?>" id="iEquipe" name="iEquipe">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
             <?
             $sTitulo = "CADASTRO DE TESTES ";
             $sUrlAlvo = $sUrlRaiz."controle/projeto/prj_projetos/";
             echo fMontaCabecalho($sUrlAlvo, $sTitulo);
             
             $link = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/testes/cadastro/modal1.php','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
             
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
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?=$sUrlRaiz?>controle/testes/cadastro/index.php'">ATUALIZAR</button>
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
                                        ftt_tst_id, 
                                        ftt_tst_id_candidato, 
                                        ftt_tst_tempo_excedido,
                                        ftt_tst_bloqueado,
                                        ftt_tst_status, 
                                        date_format(ftt_tst_data_cadastro, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_cadastro,   
                                        date_format(ftt_tst_data_inicio, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_inicio, 
                                        date_format(ftt_tst_data_fim, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_fim,  
                                        ftt_tst_id_prova,
                                        ftt_can_nome, 
                                        ftt_can_email,
                                        ftt_prv_nome,
                                        timediff(ftt_tst_data_fim, ftt_tst_data_inicio) as tempo_total
                                        from ftt_teste                                        
                                        inner join ftt_candidato on ftt_can_id = ftt_tst_id_candidato
                                        inner join ftt_prova on ftt_prv_id = ftt_tst_id_prova
                                        order by ftt_tst_status asc, ftt_can_nome 
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
                                                    <th width=\"1%\" nowrap>Status</th>
                                                    <th width=\"1%\" nowrap>Candidato</th>
                                                    <th width=\"1%\" nowrap>Email</th>
                                                    <th width=\"1%\" nowrap>Prova</th>
                                                    <th width=\"1%\" nowrap>Data Cadastro</th>
                                                    <th width=\"1%\" nowrap>Data Inicio</th>
                                                    <th width=\"1%\" nowrap>Data Fim</th>
                                                    <th width=\"1%\" nowrap>Tempo Total</th>
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
                                            $ftt_tst_id                  = $SqlResult_1->fields["ftt_tst_id"];                              
                                            $ftt_tst_id_candidato        = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
                                            $ftt_tst_status              = $SqlResult_1->fields["ftt_tst_status"]; 
                                            $ftt_tst_data_cadastro       = $SqlResult_1->fields["ftt_tst_data_cadastro"];
                                            $ftt_tst_data_inicio         = $SqlResult_1->fields["ftt_tst_data_inicio"];
                                            $ftt_tst_data_fim            = $SqlResult_1->fields["ftt_tst_data_fim"];
                                            $ftt_tst_id_prova            = $SqlResult_1->fields["ftt_tst_id_prova"];
                                            $ftt_can_nome                = $SqlResult_1->fields["ftt_can_nome"];
                                            $ftt_can_email               = $SqlResult_1->fields["ftt_can_email"];
                                            $ftt_prv_nome                = $SqlResult_1->fields["ftt_prv_nome"];
                                            $tempo_total                 = $SqlResult_1->fields["tempo_total"];
                                            $ftt_tst_bloqueado           = $SqlResult_1->fields["ftt_tst_bloqueado"];
                                            $ftt_tst_tempo_excedido      = $SqlResult_1->fields["ftt_tst_tempo_excedido"];
                                            

                                            
                                            if (!$ftt_tst_data_inicio)  $ftt_tst_data_inicio = "-";
                                            if (!$ftt_tst_data_fim)     $ftt_tst_data_fim = "-";
                                            if (!$tempo_total)          $tempo_total = "-";
                                            
                                            //1-aberto/2-em execução/3-pendente /4-finalizado
                                            switch ($ftt_tst_status) {
                                                case 1:
                                                    $sStatus = "<font color='#228B22'>Aberto</font>";
                                                    break;
                                                case 2:
                                                    $sStatus = "<font color='#0000CD'>Em execução</font>";
                                                    break;
                                                case 3:
                                                    $sStatus = "<font color='#DAA520'>Pendente</font>"; 
                                                    break;
                                                case 4:
                                                    
                                                    $sStatus2 = "";
                                                    if ($ftt_tst_bloqueado == "1"){
                                                        $sStatus2 = " - Bloqueado pelo adm";
                                                    }
                                                    else if ($ftt_tst_tempo_excedido == "1"){
                                                        $sStatus2 = " - Tempo expirado";
                                                    }
                                                    
                                                    $sStatus = "Finalizado";
                                                    break;
                                            }
                                            
                                            if (strlen($ftt_prv_descricao) > 100){
                                                $ftt_prv_descricao = substr($ftt_prv_descricao, 0, 100)."...";
                                            }
                                            
                                            $Tempo = m2h($ftt_prv_tempo);
                                            
                                            $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/testes/cadastro/modal1.php?ftt_tst_id=$ftt_tst_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                            $linkBlok  = "onClick=\"BloqueiaTeste($ftt_tst_id);\"";
                                            
                                            $sDisplay .= "
                                                       <tr>  
                                                         <td width=1%>
                                                            <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit ><i class=\"fa fa-list\"></i></button>
                                                         </td>
                                                         <td width=1%>";
                                            
                                                         if ($ftt_tst_status == 2){
                                                           $sDisplay .= "<button type=\"button\" class=\"btn btn-default btn-circle\" $linkBlok ><i class=\"fa  fa-stop\"></i></button>";
                                                         }  
                                                         
                                            $sDisplay .= "                                                         
                                                         </td>
                                                         <td width=1%>
                                                            $iCount 
                                                         </td>
                                                         <td nowrap>
                                                            $sStatus $sStatus2
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_can_nome
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_can_email 
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_prv_nome 
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_tst_data_cadastro 
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_tst_data_inicio 
                                                         </td>
                                                         <td nowrap>
                                                            $ftt_tst_data_fim 
                                                         </td>
                                                         <td nowrap>
                                                            $tempo_total 
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