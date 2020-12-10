<?php
require_once "../../money.ini.php";

$GET_MesAtual = $_GET["mes"]; 
$GET_AnoAtual = $_GET["ano"];

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

$aParam["mes"] = $MesAtual; 
$aParam["ano"] = $AnoAtual; 

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
    <title>CONTAS A PAGAR/RECEBER<?=$sNomeSistema?></title>
    
    <link rel="icon" type="image/png" href="<?=$sUrlRaiz?>favicon.ico"/>    
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

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
    <input type="hidden" value="" id="iPopUpCompensa" name="iPopUpCompensa">
    <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
     <?=fCabecalho("CONTAS A PAGAR/RECEBER")?>
    <span id="message"></span>
    <div class="row">
        
        <ul class="nav nav-tabs">
            
        <?php
        
            $aDesc_Mes_Tab = array('', 'JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ');
       
            $iMes_tab = date("n");
            $iAno_tab = date("Y");
            for ($i=3;$i>=1;$i--){

                $dData = $iAno_tab."-".$iMes_tab."-01";
                $sSql = "SELECT MONTH(DATE_SUB('$dData', INTERVAL $i MONTH)) AS mes, YEAR(DATE_SUB('$dData', INTERVAL $i MONTH)) as ano";
                //echo $sSql."<BR>";

                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
                $_mes  = $SqlResult_1->fields["mes"]; 
                $_ano  = $SqlResult_1->fields["ano"]; 

                $aPeriodos_Tab_Ant[$i]["mes"] = $_mes;
                $aPeriodos_Tab_Ant[$i]["ano"] = $_ano;

                //echo "......".$_mes."/".$_ano."<BR>";
            }        
        
        
            foreach ($aPeriodos_Tab_Ant as $value) {
                
                if ($MesAtual == $value["mes"] && $AnoAtual == $value["ano"]){
                    $sActive = "class=\"active\"";
                }
                else {
                    $sActive = "";
                }
                
                $sUrl = $sUrlRaiz."sis/contas_pagar/index.php?mes=".$value["mes"]."&ano=".$value["ano"];
                
                echo "  
                        <li $sActive>
                          <a href=\"$sUrl\">".$aDesc_Mes_Tab[$value["mes"]]."/".$value["ano"]."</a>
                        </li>
                                "; 
            }
            
            $iMes_tab = date("n");
            $iAno_tab = date("Y");
            for ($i=0;$i<=10;$i++){

                $dData = $iAno_tab."-".$iMes_tab."-01";
                $sSql = "SELECT MONTH(DATE_ADD('$dData', INTERVAL $i MONTH)) AS mes, YEAR(DATE_ADD('$dData', INTERVAL $i MONTH)) as ano";

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
                
                $sUrl = $sUrlRaiz."sis/contas_pagar/index.php?mes=".$value["mes"]."&ano=".$value["ano"];
                
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
    
    
    
    //------------------------------------------------------------
                            

            
                            
            //---------------------------------------------------------------------------------------------------
            $sWhere = " AND mny_con_tipo_movimentacao = 'C'";               
            $aParam["sWhere"] = $sWhere; 
            $aParam["Tabela"] = "CREDITOS"; 
            $aRetorno = fMontaGridContasPagar($aParam);  
            
            $_aValores          = $aRetorno[0];
            $sDisplay_1         = $aRetorno[1];  
            $fValorTotalGeral_1 = $aRetorno[2];
            
            $aValores["D"] = $aValores["D"] + $_aValores["D"];
            $aValores["C"] = $aValores["C"] + $_aValores["C"];
            
            //---------------------------------------------------------------------------------------------------
            $sWhere = " AND mny_ori_cartao_credito = 0 AND mny_con_tipo_movimentacao <> 'C' ";               
            $aParam["sWhere"] = $sWhere; 
            $aParam["Tabela"] = "DEBITOS"; 
            $aRetorno = fMontaGridContasPagar($aParam);  
            
            $_aValores          = $aRetorno[0];
            $sDisplay_2         = $aRetorno[1];  
            $fValorTotalGeral_2 = $aRetorno[2];
            
            $aValores["D"] = $aValores["D"] + $_aValores["D"];
            $aValores["C"] = $aValores["C"] + $_aValores["C"];
            
            //---------------------------------------------------------------------------------------------------
            $sWhere = " AND mny_ori_cartao_credito = 1 AND mny_con_tipo_movimentacao <> 'C'";               
            $aParam["sWhere"] = $sWhere;  
            $aRetorno = fMontaGridContasPagar($aParam);  
            
            $_aValores          = $aRetorno[0];
            $sDisplay_3         = $aRetorno[1];  
            $fValorTotalGeral_3 = $aRetorno[2];  
            
            $aValores["D"] = $aValores["D"] + $_aValores["D"];
            $aValores["C"] = $aValores["C"] + $_aValores["C"];
            
            //---------------------------------------------------------------------------------------------------
            
            $iSaldo = $aValores["C"] - $aValores["D"];
                            
            
            $sHeader  = "";
            $sHeader .= "
                        <BR>
                        <div class=\"row\">
                            <div class=\"col-lg-4 col-md-6\">
                                <div class=\"panel panel-default\">
                                    <div class=\"panel-heading\">
                                        <div class=\"row\">
                                            <div class=\"col-xs-3\">
                                                <i class=\"fa fa-sign-in fa-5x\"></i>
                                            </div>
                                            <div class=\"col-xs-9 text-right\">
                                                <div class=\"huge\">R$ ".fFormataMoeda($aValores["C"], 2)."</div>
                                                <div>Total a receber</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class=\"col-lg-4 col-md-6\">
                                <div class=\"panel panel-default\">
                                    <div class=\"panel-heading\">
                                        <div class=\"row\">
                                            <div class=\"col-xs-3\">
                                                <i class=\"fa fa-sign-out fa-5x\"></i>
                                            </div>
                                            <div class=\"col-xs-9 text-right\">
                                                <div class=\"huge\">R$ ".fFormataMoeda($aValores["D"], 2)."</div>
                                                <div>Total a pagar</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class=\"col-lg-4 col-md-6\">
                                <div class=\"panel panel-default\">
                                    <div class=\"panel-heading\">
                                        <div class=\"row\">
                                            <div class=\"col-xs-3\">
                                                <i class=\"fa fa-money fa-5x\"></i>
                                            </div>
                                            <div class=\"col-xs-9 text-right\">
                                                <div class=\"huge\">R$ ".fFormataMoeda($iSaldo, 2)."</div>
                                                <div>Saldo</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                             
                        </div>";
            
            echo $sHeader;
            
            echo "
                
                        <div class=\"row\">
                            <div class=\"col-lg-12 text-right\" >
                                <i class=\"fa  fa-star-o fa-fw\"></i> Pago Total
                            </div> 
                        </div> 
                        <div class=\"row\">
                            <div class=\"col-lg-12 col-md-6\">
                                <div class=\"panel panel-default\">
                                    <div class=\"panel-heading\">
                                        <div class=\"row\">
                                            <div class=\"col-xs-9 text-left\">
                                                <div class=\"huge\">A RECEBER</div>
                                                <div> <h4><b> <i class=\"fa fa-chevron-circle-right\"></i> Total:</b> R$ ". fFormataMoeda($fValorTotalGeral_1, 2)."</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"panel-body\">
                                        $sDisplay_1
                                    </div>
                                </div>
                            </div> 
                        </div>    
                        <div class=\"row\">
                            <div class=\"col-lg-12 col-md-6\">
                                <div class=\"panel panel-default\">
                                    <div class=\"panel-heading\">
                                        <div class=\"row\">
                                            <div class=\"col-xs-9 text-left\">
                                                <div class=\"huge\">A PAGAR</div>
                                                <div> <h4><b> <i class=\"fa fa-chevron-circle-right\"></i> Total:</b> R$ ". fFormataMoeda($fValorTotalGeral_2, 2)."</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"panel-body\">
                                        $sDisplay_2
                                    </div>
                                </div>
                            </div> 
                        </div>    
                        <div class=\"row\">
                            <div class=\"col-lg-12 col-md-6\">
                                <div class=\"panel panel-default\">
                                    <div class=\"panel-heading\">
                                        <div class=\"row\">
                                            <div class=\"col-xs-9 text-left\">
                                                <div class=\"huge\">CARTÕES DE CRÉDITO</div>
                                                <div> <h4><b> <i class=\"fa fa-chevron-circle-right\"></i> Total:</b> R$ ". fFormataMoeda($fValorTotalGeral_3, 2)."</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"panel-body\">
                                        $sDisplay_3
                                    </div>
                                </div>
                            </div> 
                        </div>                          
            ";            
            
    ?>
      
  
      <script>
          
          
            //alert("xxx");
                var clear_timer;
                var aDadosSelected  = []; 
                var aExratoSelected = []; 
                function fLancamentoSelected(mny_exc_id, mny_exc_data, mny_exc_historico, mny_exc_tipo_mov, mny_exc_valor){
                var sRetorno;
                var sRetorno2;
                
                    aExratoSelected[0] = mny_exc_id;
                    aExratoSelected[1] = mny_exc_data;
                    aExratoSelected[2] = mny_exc_historico;
                    aExratoSelected[3] = mny_exc_tipo_mov;
                    aExratoSelected[4] = mny_exc_valor;
                
                    $('#mny_exc_id').val(mny_exc_id);
                    sRetorno = "<table class=table><tbody><tr><td width=1% align=center><b>"+mny_exc_tipo_mov+"</b></td><td nowrap width=1%>"+mny_exc_data+"</td><td nowrap  width=95%>"+mny_exc_historico+"</td><td nowrap align=right>R$ "+mny_exc_valor+"</td></tr> </tbody></table> ";     
                    $('#mostra_lancamento').html(sRetorno);
                    

                }
                
                function fBaixarContaPagarReceber(Tipo){
                 
                    switch (Tipo) {
                        case '1':
                            if (aDadosSelected[16] != aExratoSelected[4] || aDadosSelected[2] != aExratoSelected[1]){
                                if (confirm('(Conta) Valor: R$ ' + aDadosSelected[16] + ' - Venc.: '+aDadosSelected[2]+' \n(Extrato) Valor: R$ ' + aExratoSelected[4] +' - Venc: ' + aExratoSelected[1] +'\nOs valores entre o extrato e conta são diferentes, a baixa levará em consideação os dados do extrato. \nConfirma a operação?')){
                                    fBaixarConciliacao(Tipo);
                                }
                                else {
                                    return;
                                }
                                //$('#msgAlertBox').modal('show'); 
                            } 
                            else {
                                fBaixarConciliacao(Tipo);
                            }
                            
                            break;
                            
                        case '2':
                            
                            fBaixarConciliacao(Tipo);
                            
                            break;   
                            
                        case '3':
                            
                            fBaixarConciliacao(Tipo);
                            
                            break;                            
                    }       
                 
  
                }    

                function fExtornarContaPagarReceber(){
                var mny_pag_id_modal         = $('#mny_pag_id_modal').val();
                var parcela                  = aDadosSelected[12];
                var mny_con_id               = aDadosSelected[11];
                
                    if (confirm("Confirma o extorno do lançamento?") == false){
                        return false;
                    }    
                
                    $.ajax({
                         url:"_extornar.php",
                         dataType: 'html',
                         method: 'POST',
                         data: {
                                mny_pag_id_modal:mny_pag_id_modal,
                                parcela:parcela,
                                mny_con_id:mny_con_id
                            }
                    }).done(function(data){
                            var sRetorno   = data;

                            console.log(sRetorno);
                            
                            if (sRetorno.trim() == "true"){
                                //alert("Lançamento extronado com sucesso");
                                $('#myModal').modal('hide'); 
                                window.location.reload();
                            }    
                            else {
                                alert(sRetorno.trim());
                            }    
                            
                    });                 
                }
    
                function fBaixarConciliacao(Tipo){
                    
                    var mny_exc_id               = aExratoSelected[0];
                    var mny_exc_data             = aExratoSelected[1];
                    var mny_exc_historico        = aExratoSelected[2];
                    var mny_exc_tipo_mov         = aExratoSelected[3];
                    var mny_exc_valor            = aExratoSelected[4];              
                    //
                    var data_vencimento_f        = aDadosSelected[2];
                    var tipo_movimentacao        = aDadosSelected[3];
                    var origem                   = aDadosSelected[4];
                    var periodicidade            = aDadosSelected[6];
                    var parcela_f                = aDadosSelected[7];
                    var observacao               = aDadosSelected[9];
                    var mny_con_id_origem        = aDadosSelected[11];
                    var mny_con_id               = aDadosSelected[12];
                    var parcela                  = aDadosSelected[13];
                    var data_vencimento          = aDadosSelected[14];
                    var mny_con_id_peridiocidade = aDadosSelected[15];
                    var valor                    = aDadosSelected[16];
                    var pago                     = aDadosSelected[17];
                    var mes_atual                = '<?=$MesAtual?>';
                    var ano_atual                = '<?=$AnoAtual?>';

                    /*
                    <th width=\"1%\"></th>                  <!--0-->
                    <th width=\"1%\">Status</th>            <!--1-->
                    <th width=\"1%\">Vencimento</th>        <!--2-->
                    <th width=\"1%\">Deb/Crd</th>           <!--3-->
                    <th width=\"1%\">Origem</th>            <!--4-->
                    <th width=\"1%\">Valor</th>             <!--5-->
                    <th width=\"1%\">Periodicidade</th>     <!--6-->
                    <th width=\"1%\">Parcela</th>           <!--7-->
                    <th width=\"1%\">Categoria</th>         <!--8-->
                    <th width=\"1%\">Observação</th>        <!--9-->
                    <th width=\"97%\">&nbsp;</th>           <!--10-->
                    <th width=\"1%\">&nbsp;</th>            <!--11-->
                    <th width=\"1%\">&nbsp;</th>            <!--12-->
                    <th width=\"1%\">&nbsp;</th>            <!--13-->
                    <th width=\"1%\">&nbsp;</th>            <!--14-->
                    <th width=\"1%\">&nbsp;</th>            <!--15-->
                    <th width=\"1%\">&nbsp;</th>            <!--16-->
                    <th width=\"1%\">&nbsp;</th>            <!--17-->
                    <th width=\"1%\">&nbsp;</th>            <!--18-->
                    */
                    
                    $.ajax({
                         url:"_salvar_conciliado.php",
                         dataType: 'html',
                         method: 'POST',
                         data: {
                                data_vencimento_f:data_vencimento_f,
                                tipo_movimentacao:tipo_movimentacao,
                                origem:origem,
                                valor:valor,
                                periodicidade:periodicidade,
                                observacao:observacao,
                                mny_con_id_origem:mny_con_id_origem,
                                mny_con_id:mny_con_id,
                                parcela:parcela,
                                data_vencimento:data_vencimento,
                                mny_con_id_peridiocidade:mny_con_id_peridiocidade,
                                pago:pago,
                                parcela_f:parcela_f,
                                mes_atual:mes_atual,
                                ano_atual:ano_atual,
                                mny_exc_id:mny_exc_id,
                                mny_exc_data:mny_exc_data,
                                mny_exc_historico:mny_exc_historico,
                                mny_exc_tipo_mov:mny_exc_tipo_mov,
                                mny_exc_valor:mny_exc_valor,
                                tipo_baixa:Tipo
                            }
                    }).done(function(data){
                            var sRetorno   = data;

                            console.log(sRetorno);
                            
                            if (sRetorno.trim() == "true"){
                                //$('#message').html('<div class="alert alert-success">Salvo com sucesso</div>');
                                //alert("Salvo com sucesso");
                                $('#myModal').modal('hide'); 
                                window.location.reload();
                            }    
                            else {
                                //$('#message').html('<div class="alert alert-danger">'+sRetorno.trim()+'</div>');
                                alert(sRetorno.trim());
                            }  
                            
                            //clear_timer = setInterval(LimpaMsgStatus, 2000);
                    });  
                    
                }
                
                function LimpaMsgStatus(){
                   $('#message').html(''); 
                   clearInterval(clear_timer);
                }    
    
                function fCancelaConciliacao(){
                    $('#mny_exc_id').val('');
                    
                    $('#frm input[type="radio":checked]').each(function(){
                        $(this).checked = false;  
                    });  
              
                    $('#mostra_lancamento').html('');
                    $('#botao_mostra_lancamento').html('');              
        
                }    
                
                function fMontaModalBaixa(){
                var data_vencimento_f        = aDadosSelected[2];
                var tipo_movimentacao        = aDadosSelected[3];
                var origem                   = aDadosSelected[4];
                var periodicidade            = aDadosSelected[6];
                var parcela_f                = aDadosSelected[7];
                var observacao               = aDadosSelected[9];
                var mny_con_id_origem        = aDadosSelected[11];
                var mny_con_id               = aDadosSelected[12];
                var parcela                  = aDadosSelected[13];
                var data_vencimento          = aDadosSelected[14];
                var mny_con_id_peridiocidade = aDadosSelected[15];
                var valor                    = aDadosSelected[16];
                var pago                     = aDadosSelected[17];
                var mny_pag_id               = aDadosSelected[18];
                var mes_atual                = '<?=$MesAtual?>';
                var ano_atual                = '<?=$AnoAtual?>';

                    $('#iPopUpCompensa').val('');

                    $.ajax({
                         url:"modal.php",
                         dataType: 'html',
                         method: 'POST',
                         data: {
                                data_vencimento_f:data_vencimento_f,
                                tipo_movimentacao:tipo_movimentacao,
                                origem:origem,
                                valor:valor,
                                periodicidade:periodicidade,
                                observacao:observacao,
                                mny_con_id_origem:mny_con_id_origem,
                                mny_con_id:mny_con_id,
                                parcela:parcela,
                                data_vencimento:data_vencimento,
                                mny_con_id_peridiocidade:mny_con_id_peridiocidade,
                                pago:pago,
                                parcela_f:parcela_f,
                                mes_atual:mes_atual,
                                ano_atual:ano_atual,
                                mny_pag_id:mny_pag_id
                            }
                    }).done(function(data){
                            var sRetorno   = data;

                            $('#mostra_detalhe').html(sRetorno);
                    });                        

                }
            
   
                var table = $('table.display').DataTable({
                               "className": 'details-control',
                               "paging":   false,
                               "info":     false,
                               "ordering": true,
                               "order": [[ 2, "asc" ]],
                                columnDefs: [ 
                                        {
                                            "targets": [ 0 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 1 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 3 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 4 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 5 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 6 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 7 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 8 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 9 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 10 ],
                                            "orderable": false
                                        },
                                        {
                                            "targets": [ 11 ],
                                            "visible": false
                                        }, {
                                            "targets": [ 12 ],
                                            "visible": false
                                        }, {
                                            "targets": [ 13 ],
                                            "visible": false                                   
                                        }, {
                                            "targets": [ 14 ],
                                            "visible": false                                     
                                        }, {
                                            "targets": [ 15 ],
                                            "visible": false
                                        }, {
                                            "targets": [ 16 ],
                                            "visible": false
                                        }, {
                                            "targets": [ 17 ],
                                            "visible": false
                                        }, {
                                            "targets": [ 18 ],
                                            "visible": false
                                        }                                           
                                    ],                       
                               "language": {
                                           "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                                       }                    
                           }   
                       );    
               
            
                       
                var selected = [];  
                var tableDEB = $('#tabelaDEBITOS').DataTable();
                
                $('#tabelaDEBITOS tbody').on('click', 'tr', function () {
                    var id = this.id;
                    var index = $.inArray(id, selected);

                    //alert(index);

                    if ( index === -1 ) {
                        selected.push( id );
                    } else {
                        selected.splice( index, 1 );
                    }

                    $(this).toggleClass('selected');
                    
                    
                    var dataDEB = tableDEB.row( this ).data();
                    
                    
                    aDadosSelected = dataDEB;
                    
                    if ($('#iPopUpCompensa').val() === '1'){
                        fMontaModalBaixa();
                    }
                    
                } );
               
               
                var selected2 = [];   
                var tableCRED = $('#tabelaCREDITOS').DataTable();
                $('#tabelaCREDITOS tbody').on('click', 'tr', function () {
                    var id = this.id;
                    var index = $.inArray(id, selected2);

                    
                    if ( index === -1 ) {
                        selected2.push( id );
                    } else {
                        selected2.splice( index, 1 );
                    }

                    $(this).toggleClass('selected');
                    
                    var dataCRED = tableCRED.row( this ).data();
                    
                   
                    aDadosSelected = dataCRED;
                    
                    if ($('#iPopUpCompensa').val() === '1'){
                        fMontaModalBaixa();
                    }                    
                    
                } );
                
                <?PHP
                    $sSql = "
                    SELECT 
                        mny_ori_id
                    FROM money_origem_transacao
                    WHERE mny_ori_cartao_credito = 1";
                    
                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);   
                    
                    while (!$SqlResult_1->EOF) {
                    $mny_ori_id = $SqlResult_1->fields["mny_ori_id"];  
                    
                        echo "
                            var selected$mny_ori_id = [];   
                            var tableCARD$mny_ori_id = $('#tabela$mny_ori_id').DataTable();
                            $('#tabela$mny_ori_id tbody').on('click', 'tr', function () {
                                var id = this.id;
                                var index = $.inArray(id, selected$mny_ori_id);
                                
                                if ( index === -1 ) {
                                    selected$mny_ori_id.push( id );
                                } else {
                                    selected$mny_ori_id.splice( index, 1 );
                                }

                                $(this).toggleClass('selected');
                                
                                var dataCARD$mny_ori_id = tableCARD$mny_ori_id.row( this ).data();

                                aDadosSelected = dataCARD$mny_ori_id;

                                if ($('#iPopUpCompensa').val() === '1'){
                                    fMontaModalBaixa();
                                }                    


                            } );";
                        
                        $SqlResult_1->MoveNext();
                    }
            
                ?>
                
    </script>    
      
    <div class="modal fade" id="myModal" style="width: 100% !important" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="mostra_detalhe"></div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->  
      
    
    
    
  </body>
  
  
</html>