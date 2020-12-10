<?php
require_once "../../../money.ini.php";

$GET_MesAtual = $_GET["mes"]; 
$GET_AnoAtual = $_GET["ano"];


$aParam["mes"] = $_GET["mes"]; 
$aParam["ano"] = $_GET["ano"]; 
        

if (($GET_MesAtual != "" && $GET_AnoAtual != "") && (($GET_MesAtual != date("n") || ($GET_AnoAtual != date("Y"))))) {


    $MesAtual = $GET_MesAtual;
    $AnoAtual = $GET_AnoAtual;

    $DiaAtual = date("t", mktime(0,0,0,$MesAtual,'01',$AnoAtual));

    $aDesc_Mes = array('', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');

    $MesAtualDesc = $aDesc_Mes[$MesAtual]; 

    $DiasMes = cal_days_in_month(CAL_GREGORIAN, $MesAtual, $AnoAtual); 
    
    $sFlagPeriodoAtual = false;
    
    $dUltimoDia = $AnoAtual."-".$MesAtual."-".$DiasMes;
    
}    
else {
    
    $DiaAtual = date("j");
    $MesAtual = date("n");
    $AnoAtual = date("Y");
    $aDesc_Mes = array('', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');

    $MesAtualDesc = $aDesc_Mes[$MesAtual]; 

    $DiasMes = cal_days_in_month(CAL_GREGORIAN, $MesAtual, $AnoAtual);
    
    $sFlagPeriodoAtual = true;
    
    $dUltimoDia = $AnoAtual."-".$MesAtual."-".$DiasMes;

}



/*

function cmp($a, $b) {
	return $a['data_vencimento_f'] > $b['data_vencimento_f'];
}
*/
// Ordena
//usort($aContasPagar, 'cmp');

//// Mostra os valores
//echo '<pre>';
//print_r( $aContasPagar );
//echo '</pre>';
//
//exit;

?>

<html>
  <head>
    <title>EXTRATO<?=$sNomeSistema?></title>
    
    <link rel="icon" type="image/png" href="<?=$sUrlRaiz?>favicon.ico"/>
      
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
   
    
    
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
    
    <?=fCabecalho("EXTRATO")?>
    
    <div class="row">
        
        <ul class="nav nav-tabs">
            
        <?php
            $aDesc_Mes_Tab = array('', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');
            $iMes_tab = date("n");
            $iAno_tab = date("Y");
            for ($i=12;$i>=0;$i--){

                $dData = $iAno_tab."-".$iMes_tab."-01";
                $sSql = "SELECT MONTH(DATE_SUB('$dData', INTERVAL $i MONTH)) AS mes, YEAR(DATE_SUB('$dData', INTERVAL $i MONTH)) as ano";

                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
                $_mes  = $SqlResult_1->fields["mes"]; 
                $_ano  = $SqlResult_1->fields["ano"]; 

                $aPeriodos_Tab[$i]["mes"] = $_mes;
                $aPeriodos_Tab[$i]["ano"] = $_ano;

                //echo $_mes."/".$_ano."<BR>";
            }        
        
        
            foreach ($aPeriodos_Tab as $value) {
                
                if ($MesAtual == $value["mes"] && $AnoAtual == $value["ano"]){
                    $sActive = "class=\"active\"";
                }
                else {
                    $sActive = "";
                }
                
                $sUrl = $sUrlRaiz."sis/extrato/cadastro/index.php?mes=".$value["mes"]."&ano=".$value["ano"];
                
                echo "  
                        <li $sActive>
                          <a href=\"$sUrl\">".$aDesc_Mes_Tab[$value["mes"]]."/".$value["ano"]."</a>
                        </li>
                                "; 
            }
        ?>         
        </ul>
        
    </div>  
    
    
    <?php
    
    
    
    $sDisplay = "";

    $sSql = "
            SELECT 
                mny_cat_id, 
                mny_cat_descricao
            FROM money_categoria
            ORDER BY 
                mny_cat_descricao
    ";
    
    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    
    
    $aCategoria = array();
    
    while (!$SqlResult_1->EOF) {
        $mny_cat_id             = $SqlResult_1->fields["mny_cat_id"];                              
        $mny_cat_descricao      = $SqlResult_1->fields["mny_cat_descricao"];    
        
        $aCategoria[$mny_cat_id] = $mny_cat_descricao;
        
        $SqlResult_1->MoveNext();
    }
    
    $sSql = "
            SELECT 
                mny_exc_id, 
                mny_exc_data, 
                mny_exc_historico, 
                mny_exc_id_tipo, 
                mny_exc_valor, 
                mny_exc_numdocumento, 
                mny_exc_tipo_mov,
                mny_exc_id_categoria
            FROM money_extrato_cc
            WHERE 
                month(mny_exc_data) = $MesAtual AND 
                year(mny_exc_data) = $AnoAtual AND  
                mny_exc_numdocumento <> '-1'
            ORDER BY 
                mny_exc_data, 
                mny_exc_tipo_mov
    ";  
//                                    echo $sSql."<BR>";

    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

    if ($SqlResult_1->NumRows() > 0) {

        $iCount = 0;
        $iCountTable = 0;
        $sModal   = "";
        
        $sDisplay = "";
        
        $sDisplay .= "    
                <BR>
                <table id=\"tabela\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                     <thead>
                        <tr>
                            <th width=\"1%\"></th>
                            <th width=\"1%\">Tipo</th>
                            <th width=\"1%\">Data</th>
                            <th width=\"1%\">Histórico</th>
                            <th width=\"1%\">Documento</th>
                            <th width=\"1%\" align=right>Valor</th>
                            <th width=\"1%\"></th>
                            <th width=\"97%\">&nbsp;</th>
                        </tr>    
                     </thead>  
                     <tbody>
                    ";  

        //Pega o saldo anterior 
        $aValoresSI = fRetornaSaldoInicial($MesAtual, $AnoAtual);
        
        $sDisplay .= "
                       <tr>  
                         <td width=1%>
                            &nbsp;
                         </td>
                         <td width=1% align=center>
                            <b>".$aValoresSI["mny_exc_tipo_mov"]."</b>
                         </td>
                         <td nowrap>
                            &nbsp;
                         </td>
                         <td nowrap>
                            <b>SALDO INICIAL</b>
                         </td>
                         <td nowrap>
                            &nbsp;  
                         </td>
                         <td nowrap align=right>
                            <b>".fFormataMoeda($aValoresSI["mny_exc_valor"], 2)."</b>  
                         </td>
                         <td></td>
                         <td>
                             &nbsp;
                         </td>
                       </tr>

            ";        
        
         
        
        while (!$SqlResult_1->EOF) {
        $mny_exc_id             = $SqlResult_1->fields["mny_exc_id"];                              
        $mny_exc_data           = fFormataData($SqlResult_1->fields["mny_exc_data"]); 
        $mny_exc_historico      = utf8_encode($SqlResult_1->fields["mny_exc_historico"]); 
        $mny_exc_id_tipo        = $SqlResult_1->fields["mny_exc_id_tipo"]; 
        $mny_exc_numdocumento   = $SqlResult_1->fields["mny_exc_numdocumento"]; 
        $mny_exc_tipo_mov       = $SqlResult_1->fields["mny_exc_tipo_mov"]; 
        $mny_exc_valor          = $SqlResult_1->fields["mny_exc_valor"]; 
        $mny_exc_id_categoria   = $SqlResult_1->fields["mny_exc_id_categoria"]; 
        
            $sSql = "
                    SELECT 
                        mny_pag_id_extrato
                    FROM money_pagamentos
                    WHERE 
                        mny_pag_id_extrato = $mny_exc_id 
            ";  
        //                                    echo $sSql."<BR>";

            $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

            $mny_pag_id_extrato = "";
            if ($SqlResult_2->NumRows() > 0) {        
                $mny_pag_id_extrato          = $SqlResult_2->fields["mny_pag_id_extrato"]; 
            }
        
            $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."sis/contas/cadastro/modal.php?mny_con_id=$mny_con_id','cadastro','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
            $linkDel  = "onClick=\"deleta_candidato($mny_con_id);\"";

            $aValoresTipoMov[$mny_exc_tipo_mov] = $aValoresTipoMov[$mny_exc_tipo_mov] + $mny_exc_valor;
            
            
            switch ($mny_exc_tipo_mov) {
                case "C":
                    $ColorFont = "blue";
                    break;
                case "D":
                    $ColorFont = "red";
                    break;
                default:
                    $ColorFont = "black";
                    break;
            }
            
            if ($mny_pag_id_extrato != ""){
                $sMostraCheck = "<font color=green><b><i class=\"fa fa-check fa-fw\"></i></b></font>";
            }   
            else {
                $sMostraCheck = "<button type=\"button\" class=\"btn btn-default btn-circle\" onClick=\"excluir_registro($mny_exc_id);\"><i class=\"fa fa-trash-o\"></i></button>";
            }

            $sDisplay .= "
                       <tr>  
                         <td width=1%>
                            $sMostraCheck
                         </td>
                         <td width=1% align=center>
                            <font color=$ColorFont><b>$mny_exc_tipo_mov</b></font>
                         </td>
                         <td nowrap>
                            $mny_exc_data 
                         </td>
                         <td nowrap>
                            $mny_exc_historico 
                         </td>
                         <td nowrap>
                            $mny_exc_numdocumento  
                         </td>
                         <td nowrap align=right>
                            ".fFormataMoeda($mny_exc_valor, 2)."  
                         </td>
                         <td width=400px><select class=\"form-control\" onchange=\"getval(this, $mny_exc_id);\">
                                <option value=\"\"></option>
            ";
            
            foreach ($aCategoria as $_mny_cat_id => $_mny_cat_descricao) {
                
                if ($mny_exc_id_categoria == $_mny_cat_id) $flag = "selected";
                else $flag = "";
                
                $sDisplay .= "  <option value=\"$_mny_cat_id\" $flag>$_mny_cat_descricao</option>";
            }
            
            $sDisplay .= "
                            </select>     
                         </td>
                         <td>
                             &nbsp;
                         </td>
                       </tr>
            ";

            $iCount++;

            $SqlResult_1->MoveNext();

        }




    }

    switch ($aValoresSI["mny_exc_tipo_mov"]) {
        case "C":
            $fSaldoFinal = (($aValoresTipoMov["C"] - $aValoresTipoMov["D"]) + $aValoresSI["mny_exc_valor"]);
            //echo "((".$aValoresTipoMov["C"]." - ".$aValoresTipoMov["D"].") + ".$aValoresSI["mny_exc_valor"].") = $fSaldoFinal <BR>";
            break;
        case "D":
            $fSaldoFinal = (($aValoresTipoMov["C"] - $aValoresTipoMov["D"]) - $aValoresSI["mny_exc_valor"]);
            //echo "((".$aValoresTipoMov["C"]." - ".$aValoresTipoMov["D"].") - ".$aValoresSI["mny_exc_valor"].") = $fSaldoFinal <BR>";
            break;
    }    
    
    if ($fSaldoFinal < 0){
        $TimoMovSaldoFinal = "D";
    }
    else {
        $TimoMovSaldoFinal = "C";
    }
    
        $sDisplay .= "
                       <tr>  
                         <td width=1%>
                            &nbsp;
                         </td>
                         <td width=1% align=center>
                            <b>$TimoMovSaldoFinal</b>
                         </td>
                         <td nowrap>
                            &nbsp;
                         </td>
                         <td nowrap>
                            <b>SALDO FINAL</b>
                         </td>
                         <td nowrap>
                            &nbsp;  
                         </td>
                         <td nowrap align=right>
                            <b>".fFormataMoeda($fSaldoFinal, 2)."</b>  
                         </td>
                         <td></td>
                         <td>
                             &nbsp;
                         </td>
                       </tr>

            ";      
    
    
    
    $sDisplay .= "</tbody></table>";        

    switch ($aValoresSI["mny_exc_tipo_mov"]) {
        case "C":
            $Display_SI = "<font color='blue'>R$ ".fFormataMoeda($aValoresSI["mny_exc_valor"], 2)."</font>";
            break;
        case "D":
            $Display_SI = "<font color='red'>(R$ ".fFormataMoeda($aValoresSI["mny_exc_valor"], 2).")</font>";
            break;
    }  
    
    switch ($aValoresSI["mny_exc_tipo_mov"]) {
        case "C":
            $Display_SI = "<font color='#111111'>R$ ".fFormataMoeda($aValoresSI["mny_exc_valor"], 2)."</font>";
            break;
        case "D":
            $Display_SI = "<font color='#111111'>(R$ ".fFormataMoeda($aValoresSI["mny_exc_valor"], 2).")</font>";
            break;
    }
    
    switch ($TimoMovSaldoFinal) {
        case "C":
            $Display_SF = "<font color='#111111'>R$ ".fFormataMoeda($fSaldoFinal, 2)."</font>";
            break;
        case "D":
            $Display_SF = "<font color='#111111'>(R$ ".fFormataMoeda(($fSaldoFinal * -1), 2).")</font>";
            break;
    }    
    
    
    
    $sHeader  = "";
    $sHeader .= "
                <BR>
                <div class=\"row\">
                    <div class=\"col-lg-3 col-md-6\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <div class=\"row\">
                                    <div class=\"col-xs-12 text-right\">
                                        <div class=\"huge\">".$Display_SI."</div>
                                        <div>SALDO INICIAL</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class=\"col-lg-3 col-md-6\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <div class=\"row\">
                                    <div class=\"col-xs-12 text-right\">
                                        <div class=\"huge\">R$ ".fFormataMoeda($aValoresTipoMov["C"], 2)."</div>
                                        <div><font color='blue'>CRÉDITO</font></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class=\"col-lg-3 col-md-6\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <div class=\"row\">
                                    <div class=\"col-xs-12 text-right\">
                                        <div class=\"huge\">R$ ".fFormataMoeda($aValoresTipoMov["D"], 2)."</div>
                                        <div><font color='red'>DÉBITO</font></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class=\"col-lg-3 col-md-6\">
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <div class=\"row\">
                                    <div class=\"col-xs-12 text-right\">
                                        <div class=\"huge\">".$Display_SF."</div>
                                        <div>SALDO</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>";    
    
    
    echo $sHeader;
    echo $sDisplay;
    
    
    
    ?>
      
  
      
      
      
      
  </body>
  
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
                               "info":     false,
                               "ordering": false,             
                               "language": {
                                           "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                                       }                    
                           }   
                       );     
               
               
            function getval(sel, mny_exc_id){
                
                var mny_cat_id = sel.value;
                
                $.ajax({
                    url:"_salvar.php",
                    dataType: 'html',
                    method: 'POST',
                    data: {
                       mny_cat_id:mny_cat_id,
                       mny_exc_id:mny_exc_id
                    }
                }).done(function(data){
                    var sRetorno   = data;

                    if (sRetorno.trim() != "1"){
                        alert('Problema ao salvar registro: '+sRetorno);
                    }   
                    else {
                        console.log(sRetorno);
                    }
                    
                });                    
                
                
                
            }  
            
            function excluir_registro(mny_exc_id){

                var r = confirm("Deseja excluir o registro?");

                if (r == false){
                    return;
                }

                $.ajax({
                     url:"excluir_lancamento.php",
                     dataType: 'html',
                     method: 'POST',
                     data: {
                        mny_exc_id:mny_exc_id
                     }
                 }).done(function(data){
                        var sRetorno   = data;

                        if (sRetorno.trim() == "true"){
                            location.reload();
                        }
                        else {
                            alert("Problema na exclusão!");
                        }    

                 });    

            }                   
            
      </script>       
</html>