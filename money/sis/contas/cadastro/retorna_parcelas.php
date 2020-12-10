<?php
require_once "../../../money.ini.php";

$mny_con_data_base      = fFormataData($_POST["mny_con_data_base"]);
$mny_con_valor          = $_POST["mny_con_valor"];
$mny_con_parcelas       = $_POST["mny_con_parcelas"];


$fValorTotal = $mny_con_parcelas * fFormataMoeda($mny_con_valor);

$sRetorno  = "";

$sRetorno .= "

<div class=\"table-responsive\">
    <table class=\"table table-striped table-bordered table-hover\">
        <thead>
            <tr><th colspan=4>Relação das parcelas</th></tr>
            <tr>
                <th width=50px style=\"vertical-align:middle; text-align: center\">#</th>
                <th width=100px style=\"vertical-align:middle; text-align: center\">Vencimento</th>
                <th width=100px style=\"vertical-align:middle; text-align: center\">Valor</th>
                <th width=20px style=\"vertical-align:middle; text-align: center\">Pago</th>
            </tr>
        </thead>
        <tbody>";     
            
        $sPacelasDetalhe = "[";
        for ($i=0;$i <$mny_con_parcelas; $i++){


            $data = new DateTime($mny_con_data_base);

            $sFator = "P".$i."M";

            $data->add(new DateInterval($sFator));

            $iParc = $i + 1;

            //$sSql           = "SELECT DATE_FORMAT(DATE_ADD('$mny_con_data_base',INTERVAL $i MONTH), '%d/%m/%Y') AS venc;";  
            //$SqlResult_1    = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");   

            //$venc           = $SqlResult_1->fields["venc"];

            $sRetorno .= "
                <tr>
                    <td style=\"vertical-align:middle; text-align: center\" nowrap>$iParc</td>    
                    <td style=\"vertical-align:middle; text-align: center\" nowrap>".$data->format('d/m/Y')."</td>   
                    <td style=\"vertical-align:middle; text-align: right\" nowrap>$mny_con_valor</td>  
                    <td style=\"vertical-align:middle; text-align: center\" nowrap>0</td>     
                </tr>    
            ";
            
            if ($iParc > 1){
                $sPacelasDetalhe .= ",";
            }
            
            //$sPacelasDetalhe .= $iParc.";".$data->format('d/m/Y').";".$mny_con_valor.";0";
            //$sPacelasDetalhe .= "{\"parcela\":$iParc,\"data\": \"".$data->format('Y-m-d')."\",\"valor\": \"$mny_con_valor\",\"pago\":0}";
            $sPacelasDetalhe .= "{|parcela|:$iParc,|data|: |".$data->format('Y-m-d')."|,|valor|: |$mny_con_valor|,|pago|:0}";
            
//[{"parcela":1,"data": "2020-10-20","valor": "10,00","pago":0},{"parcela":1,"data": "2020-10-20","valor": "10,00","pago":0}]            
            

        }
        $sPacelasDetalhe .= "]";

$sRetorno .= "
                <tr>
                    <td style=\"vertical-align:middle; text-align: right\" colspan=2><b>Total</b></td>    
                    <td style=\"vertical-align:middle; text-align: right\"><b>".fFormataMoeda($fValorTotal, "2")."</b></td>  
                    <td></td>
                </tr>
        </tbody>
    </table>
</div>

<div style=\"display:none;\"  style=\"visibility:'hidden'\" id=\"mny_con_parcelas_detalhe\" name=\"mny_con_parcelas_detalhe\">$sPacelasDetalhe</div>
";

echo $sRetorno;
//echo "<BR> $sPacelasDetalhe";
?>

