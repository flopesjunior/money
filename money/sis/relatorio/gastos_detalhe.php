<?php

require_once "../../money.ini.php";

$MesQuery   = $_POST["mes"]; 
$AnoQuery   = $_POST["ano"];
$mny_cat_id = $_POST["mny_cat_id"];

//PREENCHE O ARRAY COM AS CATEGORIAS
$sSql = "
        SELECT 
            mny_cat_id,
            mny_cat_descricao
        FROM money_categoria
        WHERE 
            mny_cat_id = $mny_cat_id
";

$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);

$mny_cat_descricao             = $SqlResult_1->fields["mny_cat_descricao"]; 

//################################################################################
        
$sSql = "
       SELECT 
           mny_exc_data,
           mny_exc_historico,
           mny_exc_valor
       FROM money_extrato_cc
       INNER JOIN money_categoria ON mny_cat_id = mny_exc_id_categoria
       WHERE 
           month(mny_exc_data) = $MesQuery AND 
           year(mny_exc_data) = $AnoQuery AND 
           mny_cat_id = $mny_cat_id
";


$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

$iCount = 0;
$aDados = array();
$iValorTotal = 0;
while (!$SqlResult_1->EOF) {
$mny_exc_data             = $SqlResult_1->fields["mny_exc_data"]; 
$mny_exc_historico        = utf8_encode($SqlResult_1->fields["mny_exc_historico"]); 
$mny_exc_valor            = $SqlResult_1->fields["mny_exc_valor"];  

    //echo $mny_exc_data.$mny_exc_historico.$mny_exc_valor."<BR>";
    
    $aDados[$iCount]["Data"]       = fFormataData($mny_exc_data);
    $aDados[$iCount]["Historico"]  = "<span class=\"badge badge-light\"><small>CONTA CORRENTE</small></span> ".$mny_exc_historico;
    $aDados[$iCount]["Valor"]      = $mny_exc_valor;
    
    $iValorTotal = $iValorTotal + $mny_exc_valor;
    
    $iCount++;
    
    $SqlResult_1->MoveNext();
}  

$aParam["mes"] = $MesQuery; 
$aParam["ano"] = $AnoQuery;     

$aContasPagar = array();
$aContasPagar = fRetonaArrayContasPagar($aParam);

foreach ($aContasPagar as $value) {

    if ($value["mny_pag_id"] != "" && $value["mny_con_id_categoria"] == $mny_cat_id){
        $Parc = "";
        if ($value["parcela"] > 0){
            $Parc = " - Parc.:".$value["parcela"]."/".$value["parcela_total"];
        }

        $aDados[$iCount]["Data"]       = fFormataData($value["mny_pag_vencimento_pago"]);
        $aDados[$iCount]["Historico"]  = "<span class=\"badge badge-light\"><small>CARTAO</small></span> ".$value["origem"]." - [".$value["observacao"]."$Parc]";
        $aDados[$iCount]["Valor"]      = $value["mny_pag_valor_pago"];

        $iValorTotal = $iValorTotal + $value["mny_pag_valor_pago"];
        
    }
    
    $iCount++;
}

$sDisplay .= "
    

    <div class=\"row\">    
        <div class=\"col-lg-12\">
            <h3>$mny_cat_descricao</h3>
        </div>
    </div>    
    <div class=\"row\">    
        <div class=\"col-lg-12\">
            <div class=\"panel panel-default\">
                <div class=\"panel-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-striped table-bordered table-hover\">
                            <thead>
                               <tr>
                                   <th>Data</th>
                                   <th>Descrição</th>
                                   <th>Valor</th>
                               </tr>    
                            </thead>  
                            <tbody>";
    
 foreach ($aDados as $value2) {
     
                        $sDisplay .= "
                                <tr>
                                    <td nowrap>".$value2["Data"]."</td>
                                    <td nowrap>".$value2["Historico"]."</td>
                                    <td nowrap><table width=100%><tr><td width=50% align=left>R$</td><td width=50% align=right>".number_format($value2["Valor"], 2, ",", ".")."</td></tr></table></td>
                                </tr>";     
     
}   

$sDisplay .= "   
                                <tr>
                                    <td nowrap colspan=2 align=right>Total</td>
                                    <td nowrap align=right>R$ ".number_format($iValorTotal, 2, ",", ".")."</td>
                                </tr>    
                            </tbody>
                        </table>  
                    </div>
                </div>    
            </div>        
        </div>            
    </div>                
                ";  

echo $sDisplay;
?>

