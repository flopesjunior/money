<?php
require_once "../../money.ini.php";

$GET_MesAtual = $_GET["mes"]; 
$GET_AnoAtual = $_GET["ano"];
$GET_QtdMes   = $_GET["QtdMes"];

if (empty($GET_QtdMes)){
    $iQtdMes = 0;
}
else if ($GET_QtdMes > 6){
    echo "<script>alert('O numero máximo são 6 meses');</script>";
    $iQtdMes = 0;
}
else {
    $iQtdMes = $GET_QtdMes - 1;
}
        

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
$dDataInicio = date("Y-m-d");

$data = new DateTime($dDataInicio);

$i = 2;

$sFator = "P".$i."M";

$data->add(new DateInterval($sFator));

$dDataFim = $data->format('Y-m-d');



$sSql = "SELECT DATEDIFF('$dDataFim', '$dDataInicio') AS Dias";
$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
$Dias  = $SqlResult_1->fields["Dias"]; 

echo $dDataInicio."<BR>";

$DataCorrente = $dDataInicio;

for ($j=1;$j<=($Dias - 1);$j++){
  $sFator = "P1D";  
  $data2 = new DateTime($DataCorrente);
  $data2->add(new DateInterval($sFator));
  $DataCorrente = $data2->format('Y-m-d');
  echo $DataCorrente."<BR>";
}

echo $dDataFim."<BR>";
*/
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


$iMes_tab = date("n");
$iAno_tab = date("Y");
for ($i=0;$i<=$iQtdMes;$i++){

    $dData = $iAno_tab."-".$iMes_tab."-01";
    $sSql = "SELECT MONTH(DATE_ADD('$dData', INTERVAL $i MONTH)) AS mes, YEAR(DATE_ADD('$dData', INTERVAL $i MONTH)) as ano";

    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
    $_mes  = $SqlResult_1->fields["mes"]; 
    $_ano  = $SqlResult_1->fields["ano"]; 

    $aPeriodos_Tab[$i]["mes"] = fArrumaDigitosCodigo($_mes, 2);
    $aPeriodos_Tab[$i]["ano"] = $_ano;

    //echo $_mes."/".$_ano."<BR>";
}        

$sSql = "SELECT  mny_exs_data, myy_exs_saldo_atual, mny_exs_tipo_mov FROM money_extrato_cc_saldo ORDER BY mny_exs_data DESC LIMIT 0, 1";
$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
$myy_exs_saldo_atual    = $SqlResult_1->fields["myy_exs_saldo_atual"]; 
$mny_exs_tipo_mov       = $SqlResult_1->fields["mny_exs_tipo_mov"]; 
$mny_exs_data           = $SqlResult_1->fields["mny_exs_data"]; 

if ($mny_exs_tipo_mov == "C"){
    $fSaldo = $myy_exs_saldo_atual;
}
else if ($mny_exs_tipo_mov == "D"){
    $fSaldo = $myy_exs_saldo_atual * -1;
}



//echo "$mny_exs_data -> inicio: ".$fSaldo."<BR>";  
$ContasAbertas[$mny_exs_data] = $fSaldo;

//$fSaldo = 0;
foreach ($aPeriodos_Tab as $value) {

    $aParam["mes"] = $value["mes"]; 
    $aParam["ano"] = $value["ano"];     
    $aContasPagar = fRetonaArrayContasPagar($aParam);
    
    $sSql = "TRUNCATE money_previsao_tmp";
    $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");   
    
    foreach ($aContasPagar as $key => $value2) {
        //$aData_vencimento[$key] = $value["data_vencimento_f"];
        //$aData_vencimento[$key] = $value["data_vencimento_tmstmp"];
        
        $sSql = "INSERT INTO money_previsao_tmp (mny_prev_data, mny_prv_valor, mny_prv_pag_id, mny_prv_tipomov) values ('".$value2["data_vencimento"]."', '".$value2["valor"]."','".$value2["mny_pag_id"]."','".$value2["tipo_movimentacao"]."')";
        $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");         
    }

    //array_multisort($aData_vencimento, SORT_NUMERIC, SORT_ASC, $aContasPagar); 

    $sSql = "SELECT mny_prev_data, mny_prv_valor, mny_prv_pag_id, mny_prv_tipomov FROM money_previsao_tmp ORDER BY mny_prev_data ASC";
    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaCampos <br>".$sSql);
    
    while (!$SqlResult_1->EOF) {
    $mny_prev_data      = $SqlResult_1->fields["mny_prev_data"];
    $mny_prv_valor      = $SqlResult_1->fields["mny_prv_valor"];
    $mny_prv_pag_id     = $SqlResult_1->fields["mny_prv_pag_id"];
    $mny_prv_tipomov    = $SqlResult_1->fields["mny_prv_tipomov"];

        if ($mny_prv_pag_id == 0){

            if ($mny_prv_tipomov == "C"){

                $_fSaldo = $fSaldo;
                $fSaldo = $fSaldo + fFormataMoeda($mny_prv_valor);
                //echo $mny_prev_data." -> ".$_fSaldo." + ".$mny_prv_valor." = ".$fSaldo."<BR>";
                $ContasAbertas[$mny_prev_data] = $fSaldo;
            }    
            else if ($mny_prv_tipomov == "D"){
                
                $_fSaldo = $fSaldo;
                $fSaldo = $fSaldo - fFormataMoeda($mny_prv_valor);
                //echo $mny_prev_data." -> ".$_fSaldo." - ".$mny_prv_valor." = ".$fSaldo."<BR>";
                $ContasAbertas[$mny_prev_data] = $fSaldo;
            }    

        }         

        $SqlResult_1->MoveNext();
    }

    //echo "-------<BR>";
    
    //foreach ($ContasAbertas as $key => $value) {
    //    echo $key." => ".$value."<BR>";
    //}
    
    /*
    foreach ($aContasPagar as $key => $value) {

        //echo $value["data_vencimento"]." -> ".fFormataMoeda($value["valor"])." -> ".$value["tipo_movimentacao"]." -> ".$value["mny_pag_id"]."<BR>";

        if ($value["mny_pag_id"] == 0){

            if ($value["tipo_movimentacao"] == "C"){

                //echo $value["data_vencimento_tmstmp"]." -> ".$value["data_vencimento_f"]." -> ".$fSaldo." + ".fFormataMoeda($value["valor"])."<BR>";
                $fSaldo = $fSaldo + fFormataMoeda($value["valor"]);
                //echo " = $fSaldo <BR>"; 
                $ContasAbertas[$value["data_vencimento"]] = $fSaldo;
            }    
            else if ($value["tipo_movimentacao"] == "D"){

                //echo $value["data_vencimento_tmstmp"]." -> ".$value["data_vencimento_f"]." -> ".$fSaldo." - ".fFormataMoeda($value["valor"])."<BR>";
                $fSaldo = $fSaldo - fFormataMoeda($value["valor"]);
                //echo " = $fSaldo <BR>"; 
                $ContasAbertas[$value["data_vencimento"]] = $fSaldo;
            }    

        }    
    }
     */
     
}


$aValue = end($aPeriodos_Tab);

//echo "mes :".$aValue["mes"]."<BR>";

$DiasMes = cal_days_in_month(CAL_GREGORIAN, $aValue["mes"], $aValue["ano"]);

$dDataFim = $aValue["ano"]."-".$aValue["mes"]."-".$DiasMes;

$sSql = "SELECT DATEDIFF('$dDataFim', '$mny_exs_data') AS Dias";
$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
$Dias  = $SqlResult_1->fields["Dias"]; 

//echo $dDataInicio."<BR>";

//echo "-------- <BR>";

$DataCorrente = $mny_exs_data;

for ($j=0;$j<=($Dias);$j++){

  if ($j > 0){  
    $sFator = "P1D";  
    $data2 = new DateTime($DataCorrente);
    $data2->add(new DateInterval($sFator));
    $DataCorrente = $data2->format('Y-m-d');
  }

  if (empty($ContasAbertas["$DataCorrente"])){
     $aDadosGrafico["$DataCorrente"] = $fUltimoValor;
  }
  else {
     $aDadosGrafico["$DataCorrente"] = $ContasAbertas["$DataCorrente"];
     $fUltimoValor = $ContasAbertas["$DataCorrente"]; 
  }

  //echo "$DataCorrente -> ".$ContasAbertas["$DataCorrente"]."<BR>";

  //echo $DataCorrente."<BR>";
}

//foreach ($aDadosGrafico as $key => $value) {
//    echo $key." => ".$value."<BR>";
//}

//exit;
?>

<html>
  <html lang="en">
<head>
    <title>PREVISÃO<?=$sNomeSistema?></title>
    
    <link rel="icon" type="image/png" href="<?=$sUrlRaiz?>favicon.ico"/>    
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- Custom CSS -->
    <link href="<?=$sUrlRaiz?>dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=$sUrlRaiz?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    
    <!-- MetisMenu CSS -->
    <link href="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?=$sUrlRaiz?>dist/css/timeline.css" rel="stylesheet">
        
</head>
<body style="padding-left: 10; padding-top: 10; padding-right: 10">
    <input type="hidden" value="" id="iPopUpCompensa" name="iPopUpCompensa">
    <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">  
     <?=fCabecalho("PREVISÃO")?>
    <span id="message"></span>
    <div class="row">    
        <div class="col-lg-2">    
            <form class="form-inline">
              <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Meses</label>
              <select class="custom-select my-1 mr-sm-2" id="SelecionaQtdMes">
                <option selected>Selecione...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
              </select>
            </form>
        </div>
    </div>      
    
    <div class="row">    
        <div class="col-lg-12">
            <div align=center id="chart_burnup"></div>     
        </div>
        
    </div>  


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="<?=$sUrlRaiz?>dist/js/sb-admin-2.js"></script>

<script src="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.js"></script>    
    
    

  
<?php
/*
foreach ($aDadosGrafico as $key => $value) {
    
    echo $key." => ".$value."<BR>";
}
exit;
*/
# GRAFICO CHAMADOS REGISTRADOS NO PERÍODO ####################### 

$sGraf1  = "";
$sGraf1 .= "
<script type=\"text/javascript\">

    $(document).ready(function(){

        $(\"#SelecionaQtdMes\").val('".$GET_QtdMes."');

        $(\"#SelecionaQtdMes\").change(function(){
            var QtdMes = $(this).val();
            window.location.href = '".$sUrlRaiz."sis/relatorio/previsao.php?QtdMes='+QtdMes;
        });
        
        MostraGrafico();
        
        function MostraGrafico() {
            google.charts.load(\"current\", {packages:['corechart', 'line']});
            google.charts.setOnLoadCallback(drawChart_1);
        }

        function drawChart_1() {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'Data');
                data.addColumn('number', 'Valor Previsto (+)');
                data.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
                data.addColumn('number', 'Valor Previsto (-)');
                data.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});

                data.addRows([
    ";            
            $iCount = 0;
            foreach ($aDadosGrafico as $key => $value) {

                $_aDataBase = explode("-", $key);
                $_AnoAtualGraf = $_aDataBase[0]; 
                $_MesAtualGraf = intval($_aDataBase[1]); 
                $_DiaAtualGraf = intval($_aDataBase[2]); 

                //$sHtml_Previsto = "";
                //$sHtml_Realizado = "<table  cellpadding=\"10px\"><tr><td> <b>Data:</b> </td><td>$i/$MesAtual/$AnoAtual</td></tr><tr><td><font color=#FF8C00><b>Realizado:</b></font></td><td>$iQtdPH_Realizado</td></tr><tr><td><font color=#FF8C00><b>Yield:</b></font></td><td nowrap>".$iPorcDiferencaPeriodo."% ".$sImageDif."</td></tr></table>";             


                if ($_MesAtualGraf == 1){
                    $MesAtual_Atualizado = 12;
                    $AnoAtual_Atualizado = $_AnoAtualGraf - 1;
                }
                else {
                    $MesAtual_Atualizado = $_MesAtualGraf - 1;
                    $AnoAtual_Atualizado = $_AnoAtualGraf;
                }


                $iValorPositivo = "null";
                $iValorNegativo = "null";
                
                if ($value < 0){
                    $iValorNegativo = intval($value);
                    
                    if ($ValorAnterior == "+"){
                        //$sGraf1 .= ",[new Date($AnoAtual_Atualizado, $MesAtual_Atualizado, $_DiaAtualGraf), null, '',0, '']";
                        
                        //$iValorPositivo = 0;
                    }
                    
                    $ValorAnterior = "-";
                }
                else {
                    $iValorPositivo = intval($value);
                    
                    if ($ValorAnterior == "-"){
                        //$sGraf1 .= ",[new Date($AnoAtual_Atualizado, $MesAtual_Atualizado, $_DiaAtualGraf), 0, '', null, '']";
                        
                        //$iValorNegativo = 0;
                    }
                    $ValorAnterior = "+";
                }
                
                if ($iCount > 0) {
                    $sGraf1 .= ",";
                }
                $sHtml_Previsto_Pos = "";
                $sHtml_Previsto_Neg = "";
                
                if ($iValorPositivo != "null" || $iValorPositivo != 0) {
                    $sHtml_Previsto_Pos  = "<table  cellpadding=\"10px\"><tr><td> <b>Data:</b> </td><td>$_aDataBase[2]/$_aDataBase[1]/$_aDataBase[0]</td></tr><tr><td><font color=black><b>Previsto:</b>&nbsp;</font></td><td nowrap>R$ ".fFormataMoeda($iValorPositivo, 2)."</td></tr></table>";        
                }
                if ($iValorNegativo != "null" || $iValorNegativo != 0) {
                    $sHtml_Previsto_Neg  = "<table  cellpadding=\"10px\"><tr><td> <b>Data:</b> </td><td>$_aDataBase[2]/$_aDataBase[1]/$_aDataBase[0]</td></tr><tr><td><font color=black><b>Previsto:</b>&nbsp;</font></td><td nowrap>R$ ".fFormataMoeda($iValorNegativo, 2)."</td></tr></table>";        
                }
                
                
                $sGraf1 .= "[new Date($AnoAtual_Atualizado, $MesAtual_Atualizado, $_DiaAtualGraf), $iValorPositivo, '$sHtml_Previsto_Pos', $iValorNegativo, '$sHtml_Previsto_Neg']";
                //$sGraf1 .= "[new Date($AnoAtual, $MesAtual, $DiaAtual),  ".intval($value)."]";

                $AnoAtual_Atualizado_ANT = $AnoAtual_Atualizado;
                $MesAtual_Atualizado_ANT = $MesAtual_Atualizado;
                $_DiaAtualGraf_ANT       = $_DiaAtualGraf;       
                //$fValorTotal = $fValorTotal + $key

                $iCount++;
            }

    //$iQtdMax = $iQtdPH_Previsto + 50;

    $sGraf1 .= "

                ]);

                var options = {
                    series: {
                      0: {
                        lineWidth: 6
                      },
                      1: {
                        lineWidth: 6
                      }
                    },
                    colors:['#6495ED', '#CD5C5C'],
                    height: 650,
                    chartArea: {width: '90%', height: '80%'},
                    tooltip: { isHtml: true },
                    legend: {
                        position: 'top'
                        },
                    hAxis:{
                        title: 'PERÍODO',
                        textStyle : {
                            fontSize: 12 // or the number you want
                        },
                        format: 'dd/MM',
                        gridlines: {count: 30}
                    },
                    vAxis:{
                        title: 'VALOR',
                        textStyle : {
                            fontSize: 12 // or the number you want
                        }
                    } 
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_burnup'));
                chart.draw(data, options);

                /*
                google.visualization.events.addListener(chart, 'select', function() {
                       // grab a few details before redirecting

                       //var sPeriodo = String(data.getValue(chart.getSelection()[0].row, 0));
                       //alert(sPeriodo);
                       //var aPeriodo = sPeriodo.split(\" \");

                       //dash11_busca_cards('".$GET_BdrName."', aPeriodo[2], aPeriodo[1], aPeriodo[3]);

                      //alert('ano: '+aPeriodo[3] + 'mes: '+aPeriodo[1] + 'dia: '+aPeriodo[2]);
                       //location.href = 'http://www.google.com?row=' + row + '&col=' + col + '&year=' + year;
                });
                */

        } 
    });    
</script>    
";


echo $sGraf1;    

?>
    
</body>

</html>