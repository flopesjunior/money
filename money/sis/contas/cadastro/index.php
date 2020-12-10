<?php
require_once "../../../money.ini.php";

      
?>

<html>
  <head>
    <title>CONTAS <?=$sNomeSistema?></title>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <script language="JavaScript" src="<?=$sUrlRaiz?>sis/contas/cadastro/js.js" type="text/javascript" ></script>
    
    <link rel="icon" type="image/png" href="<?=$sUrlRaiz?>favicon.ico"/>    
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
     <?=fCabecalho("CADASTRO DE CONTAS")?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

             <?php
             //$sTitulo = "CADASTRO DAS CONTAS ";
             //$sUrlAlvo = $sUrlRaiz."controle/projeto/prj_projetos/";
             //echo fMontaCabecalho($sUrlAlvo, $sTitulo);
             
             $link = "onClick=\"JavaScript:window.open('".$sUrlRaiz."sis/contas/cadastro/modal.php','contasmodal','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
             
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
                                <button type="button" class="btn btn-success" onclick="window.location.href = '<?=$sUrlRaiz?>sis/contas/cadastro/index.php'">ATUALIZAR</button>
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
                                                    mny_con_id, 
                                                    mny_con_id_origem, 
                                                    mny_con_data_base, 
                                                    day(mny_con_data_base) as dia_transacao,
                                                    month(mny_con_data_base) as mes_transacao,                                                    
                                                    mny_con_tipo_movimentacao, 
                                                    mny_con_id_peridiocidade, 
                                                    mny_con_parcelas,
                                                    mny_con_parcelas_detalhe,
                                                    mny_con_observacao,
                                                    mny_con_valor,
                                                    mny_ori_descricao,
                                                    mny_ori_cartao_credito,
                                                    mny_per_descricao,
                                                    mny_con_pausada_data,
                                                    mny_cat_descricao
                                                FROM money_contas
                                                INNER JOIN money_origem_transacao ON (mny_ori_id = mny_con_id_origem)
                                                INNER JOIN money_periodicidade ON (mny_per_id = mny_con_id_peridiocidade)
                                                LEFT JOIN money_categoria ON (mny_cat_id = mny_con_id_categoria)
                                                WHERE mny_con_encerrada = 0
                                                ORDER BY 
                                                    mny_ori_cartao_credito, 
                                                    mny_con_tipo_movimentacao, 
                                                    DAY(mny_con_data_base), 
                                                    mny_ori_descricao, 
                                                    mny_per_descricao
                                                    
                                            ";  
    //                                    echo $sSql."<BR>";

                                        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    



                                        if ($SqlResult_1->NumRows() > 0) {

                                            $iCount = 0;
                                            $iCountTable = 0;
                                            $sModal   = "";

                                            while (!$SqlResult_1->EOF) {
                                            $mny_con_id                 = $SqlResult_1->fields["mny_con_id"];                              
                                            $mny_con_id_origem          = $SqlResult_1->fields["mny_con_id_origem"]; 
                                            $mny_con_data_base          = $SqlResult_1->fields["mny_con_data_base"]; 
                                            $mny_con_data_base_f        = fFormataData($SqlResult_1->fields["mny_con_data_base"]); 
                                            $mny_con_tipo_movimentacao  = $SqlResult_1->fields["mny_con_tipo_movimentacao"]; 
                                            $mny_con_id_peridiocidade   = $SqlResult_1->fields["mny_con_id_peridiocidade"]; 
                                            $mny_con_parcelas           = $SqlResult_1->fields["mny_con_parcelas"]; 
                                            $mny_con_parcelas_detalhe   = $SqlResult_1->fields["mny_con_parcelas_detalhe"]; 
                                            $mny_con_observacao         = $SqlResult_1->fields["mny_con_observacao"]; 
                                            $mny_con_valor              = $SqlResult_1->fields["mny_con_valor"]; 
                                            $mny_ori_descricao          = strtoupper($SqlResult_1->fields["mny_ori_descricao"]); 
                                            $mny_ori_cartao_credito     = $SqlResult_1->fields["mny_ori_cartao_credito"]; 
                                            $mny_per_descricao          = $SqlResult_1->fields["mny_per_descricao"]; 
                                            $dia_transacao              = $SqlResult_1->fields["dia_transacao"]; 
                                            $mes_transacao              = $SqlResult_1->fields["mes_transacao"];  
                                            $mny_con_pausada_data       = fFormataData($SqlResult_1->fields["mny_con_pausada_data"]);  
                                            $mny_cat_descricao          = $SqlResult_1->fields["mny_cat_descricao"];  
                                            
                                            

                                                if (($iCount == 0) || ($mny_ori_cartao_credito == 1 && $mny_con_id_origem != $mny_con_id_origem_ULT) || ($mny_con_tipo_movimentacao != $mny_con_tipo_movimentacao_ULT)){
                                                
                                                    if ($iCount > 0){    
                                                        $sDisplay .= "</tbody></table>"; 
                                                    }
                                                    
                                                    $sDisplay .= "    
                                                    <table id=\"tabela$iCountTable\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                                         <thead>
                                                            <tr>
                                                                <th width=\"1%\"></th>
                                                                <th width=\"1%\">Deb/Crd</th>
                                                                <th width=\"1%\">Origem</th>
                                                                <th width=\"1%\" nowrap>Dt. Base</th>
                                                                <th width=\"1%\">Periodicidade</th>
                                                                <th width=\"1%\">Vencimento</th>
                                                                <th width=\"1%\">Parcelas</th>
                                                                <th width=\"1%\">Valor</th>
                                                                <th width=\"1%\">Pausada</th>
                                                                <th width=\"1%\">Categoria</th>
                                                                <th width=\"1%\">Observação</th>
                                                                <th width=\"97%\">&nbsp;</th>
                                                            </tr>    
                                                         </thead>  
                                                         <tbody>
                                                        ";  
                                                    
                                                    $iCountTable++;
                                                    
                                                }
                                            
                                            
                                                $aParc = json_decode(str_replace("|","\"",$mny_con_parcelas_detalhe));

                                                $aUltimo = end($aParc);

                                                if (!$mny_con_parcelas)     $mny_con_parcelas = "-";
                                                if (!$mny_con_pausada_data) $mny_con_pausada_data = "-";

                                                $aDataBase = explode("-", $mny_con_data_base);

                                                $diasemana = array('todos os domingos', 'todas as segundas', 'todas as terças', 'todas as quartas', 'todas as quintas', 'todas as sextas', 'todos os sabados');
                                                $data = date('Y-m-d');
                                                $diasemana_numero = date('w', strtotime($mny_con_data_base));

                                                $aDesc_Mes = array('', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');

                                                switch ($mny_con_id_peridiocidade) {
                                                    case 1://'1', 'DiÃ¡rio'
                                                        $sVencimento = "todos os dias a partir de $mny_con_data_base_f";
                                                        break;
                                                    case 2://'2', 'Semanal x'
                                                        $sVencimento = $diasemana[$diasemana_numero];
                                                        break;
                                                    case 3://'3', 'Semanas alternadas'
                                                        $sVencimento = $diasemana[$diasemana_numero]." alternadamente";
                                                        break;
                                                    case 4://'4', 'Mensal'
                                                        $sVencimento = "todo dia ".fArrumaDigitosCodigo($dia_transacao, 2);
                                                        break;
                                                    case 5://'5', 'Anual'
                                                        $sVencimento = "todo dia ".fArrumaDigitosCodigo($dia_transacao, 2)."/".fArrumaDigitosCodigo($mes_transacao, 2);
                                                        break;
                                                    case 6://'6', 'Uma vez apenas'
                                                        $sVencimento = "dia ".$mny_con_data_base_f;
                                                        break;
                                                    case 7://'7', 'Parcelado (Mensal)'
                                                        $sVencimento = "todo dia ".fArrumaDigitosCodigo($dia_transacao, 2).", até ".fFormataData($aUltimo->data);
                                                        break;
                                                    case 10://'10', 'Trimestral'
                                                        $sVencimento = "todo dia ".fArrumaDigitosCodigo($dia_transacao, 2).", a cada 3 meses";
                                                        break;
                                                }


                                                switch ($mny_con_tipo_movimentacao) {
                                                    case "C":
                                                        $color = "blue";
                                                        break;

                                                    case "D":
                                                        $color = "red";
                                                        break;
                                                }

                                                $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."sis/contas/cadastro/modal.php?mny_con_id=$mny_con_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                                $linkDel  = "onClick=\"deleta_candidato($mny_con_id);\"";

                                                $sDisplay .= "
                                                           <tr>  
                                                             <td width=1%>
                                                                <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit ><i class=\"fa fa-cog\"></i></button>
                                                             </td>
                                                             <td width=1% align=center>
                                                                $mny_con_tipo_movimentacao
                                                             </td>
                                                             <td nowrap>
                                                                $mny_ori_descricao 
                                                             </td>
                                                             <td nowrap>
                                                                $mny_con_data_base_f 
                                                             </td>
                                                             <td nowrap>
                                                                $mny_per_descricao  
                                                             </td>
                                                             <td nowrap>
                                                                $sVencimento
                                                             </td>                                                         
                                                             <td nowrap align=center>
                                                                $mny_con_parcelas 
                                                             </td>
                                                             <td nowrap align=right>
                                                                <font color=$color>R$ $mny_con_valor</font>
                                                             </td>
                                                             <td nowrap>
                                                                $mny_con_pausada_data
                                                             </td>
                                                             <td nowrap>
                                                                $mny_cat_descricao 
                                                             </td>
                                                             <td nowrap>
                                                                $mny_con_observacao 
                                                             </td>
                                                             <td>
                                                                 &nbsp;
                                                             </td>
                                                           </tr>

                                                ";

                                                $mny_con_id_origem_ULT          = $mny_con_id_origem;
                                                $mny_ori_cartao_credito_ULT     = $mny_ori_cartao_credito;
                                                $mny_con_tipo_movimentacao_ULT  = $mny_con_tipo_movimentacao; 

                                                $iCount++;
                                                

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
  
   
      
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="<?=$sUrlRaiz?>dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.js"></script>
      
       <script>
            var table = $('table.display').DataTable({
                               "className": 'details-control',
                               "paging":   false,
                               "ordering": false,
                               "info":     false,
                               "stripe":   false,
                               "language": {
                                           "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                                       }                    
                           }   
                       );        
               
            <?php  
            /*
                    echo "
                    $(document).ready(function() {";
                    
                for ($i=0;$i<$iCountTable;$i++){
                    echo "
                        var table$i = $('#tabela$i').DataTable();

                        $('#tabela$i tbody').on('click', 'tr', function () {
                            var data$i = table$i.row( this ).data();
                            alert( 'You clicked on '+data".$i."[2]+'\'s row' );
                        } );  
                        
                        //--------------";
                } 
                echo "
                    } );";
             * 
             */
            ?>
      </script>      
  </body>
  
  
</html>