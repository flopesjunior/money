<?php
require_once "../../money.ini.php";

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

for ($i=6;$i>=0;$i--){

    $dData = $AnoAtual."-".$MesAtual."-01";
    $sSql = "SELECT MONTH(DATE_SUB('$dData', INTERVAL $i MONTH)) AS mes, YEAR(DATE_SUB('$dData', INTERVAL $i MONTH)) as ano";

    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen<BR>$sSql");  
    $_mes  = $SqlResult_1->fields["mes"]; 
    $_ano  = $SqlResult_1->fields["ano"]; 

    $aPeriodos[$i]["mes"] = $_mes;
    $aPeriodos[$i]["ano"] = $_ano;

    //echo $_mes."/".$_ano."<BR>";
}        

//PREENCHE O ARRAY COM AS CATEGORIAS
$sSql = "
        SELECT 
            mny_cat_id,
            mny_cat_descricao
        FROM money_extrato_cc
        INNER JOIN money_categoria ON mny_cat_id = mny_exc_id_categoria
        WHERE 
            month(mny_exc_data) = $MesAtual AND 
            year(mny_exc_data) = $AnoAtual
        GROUP BY mny_exc_id_categoria
        ORDER BY  sum(mny_exc_valor) desc
";

$SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

$aCategoria = array();

while (!$SqlResult_1->EOF) {
    $mny_cat_id             = $SqlResult_1->fields["mny_cat_id"];                              
    $mny_cat_descricao      = $SqlResult_1->fields["mny_cat_descricao"];    

    $aCategoria[$mny_cat_id] = $mny_cat_descricao;

    $SqlResult_1->MoveNext();
}
//print_r($aCategoria);

$aValores = array();
foreach ($aCategoria as $mny_cat_id => $mny_cat_descricao) {

    //echo $mny_cat_id."<BR>";
    foreach ($aPeriodos as $dPeriodo) {
        
        $MesQuery = $dPeriodo["mes"];
        $AnoQuery = $dPeriodo["ano"];
        
         $sSql = "
                SELECT 
                    mny_cat_id,
                    SUM(mny_exc_valor) AS total
                FROM money_extrato_cc
                INNER JOIN money_categoria ON mny_cat_id = mny_exc_id_categoria
                WHERE 
                    month(mny_exc_data) = $MesQuery AND 
                    year(mny_exc_data) = $AnoQuery AND 
                    mny_cat_id = $mny_cat_id
        ";

         //echo $sSql."<BR>";
        $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);    

        //while (!$SqlResult_1->EOF) {
            //$mny_cat_id             = $SqlResult_1->fields["mny_cat_id"];                              
            $total                  = number_format($SqlResult_1->fields["total"], 2, ".", "") ;    

            //echo $total."<BR>";
            $aValores[$mny_cat_id][$MesQuery."-".$AnoQuery] = $total;
            $aValores_Extrato[$mny_cat_id][$MesQuery."-".$AnoQuery] = $total;

        //  $SqlResult_1->MoveNext();
        //}        
    }

}
    

foreach ($aPeriodos as $dPeriodo) {

    $aParam["mes"] = $dPeriodo["mes"]; 
    $aParam["ano"] = $dPeriodo["ano"];     
    
    $aContasPagar = array();
    $aContasPagar = fRetonaArrayContasPagar($aParam);

    foreach ($aContasPagar as $value) {
        
        $Moeda = "";
        if ($value["mny_pag_id"] != "" && $value["mny_con_id_categoria"] != ""){
            
            if ($aCategoria[$value["mny_con_id_categoria"]] != ""){
                $Moeda = fFormataMoeda($value["mny_pag_valor_pago"]);

                //echo $value["mny_con_id_categoria"]." - ".$value["mny_cat_descricao"]." => ".$dPeriodo["mes"]."-".$dPeriodo["ano"]." => ".$Moeda."<BR>";

                $CatId = $value["mny_con_id_categoria"];
                $MesAno = $dPeriodo["mes"]."-".$dPeriodo["ano"];


    //            if ($aCategoria[$CatId] == ""){
    //                $aCategoria[$CatId] = $value["mny_cat_descricao"];
    //            }        

                $aValores[$CatId][$MesAno] = $aValores[$CatId][$MesAno] + $Moeda;
                $aValores_Contas[$CatId][$MesAno] = $aValores_Contas[$CatId][$MesAno] + $Moeda;
            }
            
        }
    }

}

//echo "################################### <BR>";

foreach ($aCategoria as $mny_cat_id => $mny_cat_descricao) {
    
    foreach ($aPeriodos as $dPeriodo) {
        
        $MesAno = $dPeriodo["mes"]."-".$dPeriodo["ano"];
        
        //echo $dPeriodo["mes"]."-".$dPeriodo["ano"]." => ".$mny_cat_descricao." => ".$aValores[$mny_cat_id][$MesAno]." => ".$aValores_Contas[$mny_cat_id][$MesAno]." + ".$aValores_Extrato[$mny_cat_id][$MesAno]."<BR>";
    }    
    
}    
    

?>

<html>
  <head>
    <title>GASTOS DO PERÍODO<?=$sNomeSistema?></title>
    
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
    <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz"> 
    
    <?=fCabecalho(".")?>
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
                
                $sUrl = $sUrlRaiz."sis/relatorio/gastos.php?mes=".$value["mes"]."&ano=".$value["ano"];
                
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

    $sDisplay .= "    
        <BR>
        <div class=\"row\">    
            <div class=\"col-lg-12\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        <div class=\"table-responsive\">
                            <table class=\"table table-striped table-bordered table-hover\">
                                <thead>
                                   <tr>
                                       <th></th>
                                   ";
                                $iCount = 1;      
                                foreach ($aPeriodos as $value) {
                                    
                                    if($iCount % 2 == 0){
                                        $bgColor = "#FFFACD";
                                    }
                                    else {
                                        $bgColor = "#FFFFF0";
                                    }                                       
                                    
                                    $sDisplay .= " 
                                        <th style=\"vertical-align:middle;text-align: center; background-color: $bgColor\">".$aDesc_Mes[$value["mes"]]."/".$value["ano"]."</th>
                                     
                                    ";
                                    
                                    $iCount++;
                                }

                   $sDisplay .= "    
                                   </tr>    
                                </thead>  
                                <tbody>";


                               foreach ($aCategoria as $mny_cat_id => $mny_cat_descricao) {

                                   //echo "categoria: $mny_cat_descricao ";
                                   $sDisplay .= "
                                           <tr>
                                               <td nowrap>".$mny_cat_descricao."</td>"; 

                                   $ValorCelula_ANT = 0;
                                   foreach ($aPeriodos as $dPeriodo) {

                                        $MesQuery = $dPeriodo["mes"];
                                        $AnoQuery = $dPeriodo["ano"];

                                        $ValorCelula = $aValores[$mny_cat_id][$MesQuery."-".$AnoQuery];

                                        //$iMoeda = str_replace('.', '*',  $ValorCelula);
                                        //$iMoeda = str_replace(',', '.', $iMoeda);
                                        //$iMoeda = str_replace('*', ',', $iMoeda);

                                        $ValorCelula ? $ValorCelula : $ValorCelula = "0.00";
                                        $sColorPorc = "#B5B5B5";

                                        //$ValorCelula = str_replace(',', '',  $ValorCelula);

                                        $iPorcGastoPeriodAnt = 0;
                                        if ($ValorCelula_ANT > 0){
                                             $iPorcGastoPeriodAnt = ceil((($ValorCelula - $ValorCelula_ANT) / $ValorCelula_ANT) * 100);
                                             //echo "(((".$ValorCelula." - ".$ValorCelula_ANT.") / ".$ValorCelula_ANT.") * 100) = ".$iPorcGastoPeriodAnt."<BR>";
                                        }
                                       
                                        $ImgFlecha = "";
                                        if ($iPorcGastoPeriodAnt < 0){
                                            $iPorcGastoPeriodAnt = ($iPorcGastoPeriodAnt * (-1));
                                            $ImgFlecha = "<font color=red><i class=\"fa fa-arrow-circle-o-down fa-fw\"></i></font>";
                                        }
                                        else if ($iPorcGastoPeriodAnt > 0){
                                            $ImgFlecha = "<font color=blue><i class=\"fa fa-arrow-circle-o-up fa-fw\"></i></font>";
                                        }
                                        
                                        
                                        //fa-arrow-circle-up
                                        //fa-arrow-circle-down
                                        //$sDisplay .= "<td>".number_format($ValorCelula, 2, ',', '.');
                                        $sDisplay .= "  
                                                    <td>
                                                        
                                                            <table>
                                                                <tr>
                                                                    <td align=left width=1%  nowrap>R$</td>  
                                                                    <td align=right width=98%  nowrap><font color=black><a href=\"#\" onclick=\"fAbreModalDetalhe($mny_cat_id, $MesQuery, $AnoQuery);\">".number_format($ValorCelula, 2, ",", ".")."</font></td>  
                                                                    <td>&nbsp;</td>    
                                                                    <td align=right width=70px nowrap><font color=$sColorPorc>".$iPorcGastoPeriodAnt."%</font> $ImgFlecha</td>
                                                                </tr>        
                                                            </table>  
                                                        
                                                    </td>        
                                        ";
                                        //echo $MesQuery."-".$AnoQuery." => ".$aValores[$mny_cat_id][$MesQuery."-".$AnoQuery];

                                        $ValorCelula_ANT = $ValorCelula; 

                                   }    

                                   $sDisplay .= "
                                       </tr>";    
                               }    

                   $sDisplay .= "    
                                </tbody>
                            </table>  
                        </div>
                    </div>    
                </div>        
            </div>            
        </div>                
                ";      

    //echo $sHeader;
    echo $sDisplay;
    
    
    
    ?>
      
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
  
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="<?=$sUrlRaiz?>dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script>
        
            /*
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
               
            */   
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
            
            function fAbreModalDetalhe(mny_cat_id, MesQuery, AnoQuery){
                    

                    $.ajax({
                         url:"gastos_detalhe.php",
                         dataType: 'html',
                         method: 'POST',
                         data: {
                                mny_cat_id:mny_cat_id,
                                mes:MesQuery,
                                ano:AnoQuery
                            }
                    }).done(function(data){
                            var sRetorno   = data;
                            //alert(sRetorno);
                            $('#mostra_detalhe').html(sRetorno);
                            $('#myModal').modal('show'); 
                            
                    });  
                    
                }            
            
            
      </script>       
</html>