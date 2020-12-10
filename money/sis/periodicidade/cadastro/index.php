<?php
require_once "../../../money.ini.php";

?>

<html>
  <head>
    <title>PERIODICIDADE <?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
     <link rel="icon" type="image/png" href="<?=$sUrlRaiz?>favicon.ico"/>
    
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="<?=$sUrlRaiz?>dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       

<!-- MetisMenu CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?=$sUrlRaiz?>dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=$sUrlRaiz?>dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$sUrlRaiz?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    
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
        
  </head>
  <body style="padding-left: 10; padding-top: 10; padding-right: 10">
      <input type="hidden" value="<?=$iEquipe?>" id="iEquipe" name="iEquipe">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz"> 
      
      <?=fCabecalho("CADASTRO DE PERIODICIDADE")?>
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          
             <?php
             //$sTitulo = "CADASTRO DAS CONTAS ";
             //$sUrlAlvo = $sUrlRaiz."controle/projeto/prj_projetos/";
             //echo fMontaCabecalho($sUrlAlvo, $sTitulo);
             
             $link = "onClick=\"JavaScript:window.open('".$sUrlRaiz."sis/periodicidade/cadastro/modal.php','periodicidademodal','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
             
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
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?=$sUrlRaiz?>sis/periodicidade/cadastro/index.php'">ATUALIZAR</button>
                            </td>
                        </tr>
                    </table> 
                </td>    
             </tr> 
             <tr>
                 <td width="1%" nowrap  align="center">
                     
                         <?php
                         
                                    $sDisplay = "";
                                     
                                    $sSql = "
                                            SELECT 
                                                mny_per_id, 
                                                mny_per_descricao
                                            FROM money_periodicidade
                                            ORDER BY mny_per_descricao
                                        ";  
//                                    echo $sSql."<BR>";
                                    
                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    


                                    $sDisplay .= "    
                                        <table id=\"tabela001$iCount\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                             <thead>
                                                <tr>
                                                    <th width=\"1%\"></th>
                                                    <th width=\"1%\">#</th>
                                                    <th width=\"1%\">Descrição</th>
                                                    <th width=\"97%\">&nbsp;</th>
                                                </tr>    
                                             </thead>  
                                             <tbody>
                                            ";  
                                    
                                    if ($SqlResult_1->NumRows() > 0) {

                                        while (!$SqlResult_1->EOF) {
                                            $mny_per_id                 = $SqlResult_1->fields["mny_per_id"];                              
                                            $mny_per_descricao          = $SqlResult_1->fields["mny_per_descricao"]; 
                                            
                                            
                                            $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."sis/periodicidade/cadastro/modal.php?mny_per_id=$mny_per_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                            
                                            $sDisplay .= "
                                                       <tr>  
                                                         <td width=1%>
                                                            <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit ><i class=\"fa fa-list\"></i></button>
                                                         </td>
                                                         <td width=1% align=center>
                                                            $mny_per_id 
                                                         </td>
                                                         <td nowrap>
                                                            $mny_per_descricao 
                                                         </td>
                                                         <td>
                                                             &nbsp;
                                                         </td>
                                                       </tr>

                                            ";

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