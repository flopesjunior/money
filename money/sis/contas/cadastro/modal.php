<?php
require_once "../../../money.ini.php";

    $mny_con_id         = $_GET["mny_con_id"];
    
    if ($mny_con_id) {
        
            $sSql = "SHOW COLUMNS FROM money_contas ";
            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaCampos <br>".$sSql);

            if ($SqlResult_1->NumRows() > 0) {

                $sSql = "SELECT ";

                $aCampos = array();

                //Guarda todos os campos e seus valores "default".
                while (!$SqlResult_1->EOF) {
                    $Field   = $SqlResult_1->fields["Field"];

                    $sCamposConcat .= "$Field, ";

                    array_push($aCampos, $Field);

                    $SqlResult_1->MoveNext();
                }

                //$sCamposConcat .= "mny_ori_cartao_credito, ";
                
                $sSql .= substr($sCamposConcat, 0, -2);

                $sSql .= " FROM money_contas 
                        WHERE mny_con_id = $mny_con_id";

                //echo "SQL: $sSql";
                $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaCampos <br>".$sSql);

                if ($SqlResult_2->NumRows() == 1) {

                    foreach ($aCampos as $sCampo){
                         eval("\$$sCampo = \"".  trim($SqlResult_2->fields[$sCampo]."\";"));
                    }

                }

            }
            
            
            $mny_con_data_base      = fFormataData($mny_con_data_base);
            $mny_con_pausada_data   = fFormataData($mny_con_pausada_data);
            
            if ($mny_con_id_peridiocidade == "7"){
                $sFlagMostraParcela = true;
            }
            
            
    }
    
    
    
//$result    = ibase_query("SELECT blob_value FROM table");
//$data      = ibase_fetch_object($result);
//$blob_data = ibase_blob_info($mny_con_parcelas_detalhe);
//$blob_hndl = ibase_blob_open($mny_con_parcelas_detalhe);
//echo         ibase_blob_get($blob_hndl, $blob_data[0]);    
?>

<html>
  <head>
    <title>_Modal.CONTAS</title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    
    
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>sis/contas/cadastro/js.js" type="text/javascript" ></script>

    
    <script src="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="<?=$sUrlRaiz?>dist/js/sb-admin-2.js"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">       
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       
    
    <link href="<?=$sUrlRaiz?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="<?=$sUrlRaiz?>dist/css/timeline.css" rel="stylesheet">
    <link href="<?=$sUrlRaiz?>dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?=$sUrlRaiz?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   

    
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>    
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
 
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>   
    <style>
        .sla1 {
            background-color: #F0FBEF !important;
        }

        .sla2 {
            background-color: #F9EFD1 !important;
        }
        
        .sla3 {
            background-color: #ff3333 !important;
        }
        
        table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
            font-size: 12px;
        }        
        
        .body2 {
            height: 215px;
        }
        
        .row-centered {
            text-align:center;
        }
        
        .col-centered {
            display:inline-block;
            float:none;
            text-align:left;
            margin-right:-4px;
        }    
        .teste {
            display: none;
        }
    </style>    
    
    
</head>
  
<body style="margin-left: 12px; margin-right: 12px; margin-top: 12px">
<input type="hidden" value="<?=$mny_con_id?>" id="mny_con_id" name="mny_con_id">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div><h1>Cadastro de Contas</h1></div>
                        </div>
                    </div>
                </div>
                <span id="message"></span>
                <form method="post" id="form-contas" autocomplete="off">
                    <div class="panel-body" >
                            <div class='row'>
                                    <table cellpadding=0 cellspacing=0 border=0 width=100%>
                                        <tr><td colspan="20" height="10"></td></td>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align=left>
                                                <button onclick="window.location.href = '<?=$sUrlRaiz?>sis/contas/cadastro/modal.php'" target="cadcontasmodal" type="button" class="btn btn-warning" data-placement="top" title="Ctrl+N">NOVO</button> 
                                            </td>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td align=left>
                                                <button type="submit" name="btnSalvar" id="btnSalvar" class="btn btn-success"  data-placement="top" title="Ctrl+S">SALVAR</button> 
                                            </td>                                         
                                            <td>&nbsp;&nbsp;</td>
                                            <td align=left>
                                                <button onclick="window.close();opener.location.reload();" type="button" class="btn btn-default">FECHAR</button></center>
                                            </td>                                                        
                                            <td>&nbsp;&nbsp;</td>
                                            <td align=right width="99%">
                                                <button onclick="excluir_registro(<?=$mny_con_id?>)" type="button" class="btn btn-danger">EXCLUIR</button> 
                                            </td>    
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>  
                                        <tr><td colspan="20" height="10"></td></td>
                                    </table>                                
                            </div> 
                            <BR>
                            <div class='row'>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <label for="validationCustom01">Tipo Movimentação</label>
                                        <select class="form-control" name="mny_con_tipo_movimentacao" id="mny_con_tipo_movimentacao" value="<?=$mny_con_tipo_movimentacao?>">
                                            <?php
                                            
                                            switch ($mny_con_tipo_movimentacao) {
                                                case "C":
                                                    $sFlag_C = "selected";
                                                    break;
                                                case "D":
                                                    $sFlag_D = "selected";
                                                    break;
                                            }
                                            
                                            ?>
                                            
                                            <option value="">Selecione</option>
                                            <option value="D" <?=$sFlag_D?>>1 - Débito</option>
                                            <option value="C" <?=$sFlag_C?>>2 - Crédito</option>
                                        </select>
                                    </div>                                
                                    <div class="col-md-2">
                                        <label for="validationCustom01">Origem</label>
                                        <select class="form-control" name="mny_con_id_origem" id="mny_con_id_origem" value="<?=$mny_con_id_origem?>">
                                            <?php

                                                if (!$mny_con_id_origem){
                                                    echo "<option selected>Selecione</option>";
                                                } 

                                                $sSql = "
                                                        SELECT 
                                                            mny_ori_id, 
                                                            mny_ori_descricao
                                                        FROM money_origem_transacao 
                                                        ORDER BY mny_ori_descricao
                                                    ";  
                    //                                    echo $sSql."<BR>";

                                                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);     

                                                if ($SqlResult_1->NumRows() > 0) {

                                                    while (!$SqlResult_1->EOF) {

                                                        $mny_ori_id                     = $SqlResult_1->fields["mny_ori_id"];                              
                                                        $mny_ori_descricao              = $SqlResult_1->fields["mny_ori_descricao"]; 

                                                        if ($mny_con_id_origem == $mny_ori_id) $flag = "selected";
                                                        else $flag = "";

                                                        echo "<option value='$mny_ori_id' $flag>$mny_ori_id - $mny_ori_descricao</option>";

                                                        $SqlResult_1->MoveNext();

                                                     }                                                                    
                                                }                                 
                                         ?>

                                        </select>
                                    </div> 

                                    <div class="col-md-2">
                                        <label for="validationCustom01">Data</label>
                                        <input class="form-control" type="text" name="mny_con_data_base" id="mny_con_data_base" value="<?=$mny_con_data_base?>" placeholder="DD/MM/YYY" />                                
                                    </div>

                                    <div class="col-md-2">
                                        <label for="validationCustom01">Valor</label>
                                        <input class="form-control" type="text" name="mny_con_valor" id="mny_con_valor" value="<?=$mny_con_valor?>"  onkeypress="$(this).mask('#.##0,00', {reverse: true});" />                        
                                    </div>                                               

                                    <div class="col-md-2">
                                        <label for="validationCustom01">Periodicidade</label>
                                        <select class="form-control" name="mny_con_id_peridiocidade" id="mny_con_id_peridiocidade" value="<?=$mny_con_id_peridiocidade?>">
                                            <option value=value="">Selecione</option>
                                            <?php


                                                $sSql = "
                                                        SELECT 
                                                            mny_per_id, 
                                                            mny_per_descricao
                                                        FROM money_periodicidade 
                                                        ORDER BY mny_per_descricao
                                                    ";  
                    //                                    echo $sSql."<BR>";

                                                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);     

                                                if ($SqlResult_1->NumRows() > 0) {

                                                    while (!$SqlResult_1->EOF) {

                                                        $mny_per_id                     = $SqlResult_1->fields["mny_per_id"];                              
                                                        $mny_per_descricao              = $SqlResult_1->fields["mny_per_descricao"]; 

                                                        if ($mny_con_id_peridiocidade == $mny_per_id) $flag = "selected";
                                                        else $flag = "";

                                                        echo "<option value='$mny_per_id' $flag>$mny_per_id - $mny_per_descricao</option>";

                                                        $SqlResult_1->MoveNext();

                                                     }                                                                    
                                                }                                 
                                         ?>

                                        </select>
                                    </div>                                 
                                    <div class="col-md-1">
                                        <?php
                                            if ($mny_con_id_peridiocidade == 7){
                                                $flag = "enabled";
                                            }
                                            else {
                                                $flag = "disabled";
                                            }
                                        ?>
                                        <label for="validationCustom02">Parcelas</label>
                                        <input type="text" name="mny_con_parcelas" id="mny_con_parcelas" value="<?=$mny_con_parcelas?>" class="form-control" onkeypress="$(this).mask('000', {reverse: false});" <?=$flag?> />                        
                                    </div>                                               

                                </div>  
                            </div>  
                            <BR>
                            <div class='row'>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="validationCustom02">Observação</label>
                                        <input class="form-control" type="text" maxlength="100" name="mny_con_observacao" id="mny_con_observacao" value="<?=$mny_con_observacao?>">                        
                                    </div> 
                                    <div class="col-md-2">
                                        <label for="validationCustom02">Pausar lançamento a partir de</label>
                                        <input class="form-control" type="text" name="mny_con_pausada_data" id="mny_con_pausada_data" value="<?=$mny_con_pausada_data?>" placeholder="DD/MM/YYY" />                                
                                    </div>
                                    
                                    <?PHP 
                                    
                                        $FlagCat = "disabled";
                                        if ($mny_con_id_origem == 16 || $mny_con_id_origem == 17 || $mny_con_id_origem == 18){
                                            $FlagCat = "";
                                        }
                                    
                                        echo "    
                                        <div class=\"col-md-2\">
                                            <label for=\"validationCustom01\">Categoria</label>
                                            <select class=\"form-control\" name=\"mny_con_id_categoria\" id=\"mny_con_id_categoria\" value=\"$mny_con_id_categoria\" $FlagCat>
                                                <option value=\"\">Selecione</option>";

                                                    $sSql = "
                                                            SELECT 
                                                                mny_cat_id, 
                                                                mny_cat_descricao
                                                            FROM money_categoria 
                                                            ORDER BY mny_cat_descricao
                                                        ";  
                        //                                    echo $sSql."<BR>";

                                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen <BR>".$sSql);     

                                                    if ($SqlResult_1->NumRows() > 0) {

                                                        while (!$SqlResult_1->EOF) {

                                                            $mny_cat_id                     = $SqlResult_1->fields["mny_cat_id"];                              
                                                            $mny_cat_descricao              = $SqlResult_1->fields["mny_cat_descricao"]; 

                                                            if ($mny_con_id_categoria == $mny_cat_id) $flag = "selected";
                                                            else $flag = "";

                                                            echo "<option value='$mny_cat_id' $flag>$mny_cat_id - $mny_cat_descricao</option>";

                                                            $SqlResult_1->MoveNext();

                                                        }                                                                    
                                                    }                                 


                                        echo "    
                                            </select>
                                        </div>";                                      
                                    
                                   
                                   ?>    
                                    
                                </div>
                            </div>    
                            <BR>
                            <div class='row'>
                                <div class="col-md-4">
                                    <div id="mostra_parcelas">
                                        
                                        <?php
                                        
                                        if ($mny_con_parcelas_detalhe){
                                            
                                            
                                            
                                            $sRetornoParc  = "";

                                            $sRetornoParc .= "

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
                                                    $aParc = json_decode(str_replace("|","\"",$mny_con_parcelas_detalhe));
                                                    
                                                    $fValorTotal            = 0;
                                                    $fValorTotal_Devedor    = 0;
                                                    $fValorTotal_Pago       = 0;
                                                    foreach ($aParc as $value) {
                                                        
                                                        $fValorTotal = $fValorTotal + fFormataMoeda($value->valor);
                                                        
                                                        switch ($value->pago) {
                                                            case 0:
                                                                $fValorTotal_Devedor = $fValorTotal_Devedor + fFormataMoeda($value->valor);
                                                                $img_pago = "-";
                                                                break;
                                                            case 1:
                                                                $fValorTotal_Pago = $fValorTotal_Pago + fFormataMoeda($value->valor);
                                                                $img_pago = "<font color=blue><i class=\"fa fa-check\"></i></font>";
                                                                break;
                                                        }
                                                        
                                                        
                                                        $sRetornoParc .= "
                                                            <tr>
                                                                <td style=\"vertical-align:middle; text-align: center\" nowrap>".$value->parcela."</td>    
                                                                <td style=\"vertical-align:middle; text-align: center\" nowrap>".fFormataData($value->data)."</td>   
                                                                <td style=\"vertical-align:middle; text-align: right\" nowrap>".$value->valor."</td>    
                                                                <td style=\"vertical-align:middle; text-align: center\" nowrap>".$img_pago."</td>    
                                                            </tr>    
                                                        ";                                                        
                                                    }
                                                    
                                            $sRetornoParc .= "
                                                            <tr>
                                                                <td style=\"vertical-align:middle; text-align: right\" colspan=2><b>Total</b></td>    
                                                                <td style=\"vertical-align:middle; text-align: right\"><b>".fFormataMoeda($fValorTotal, "2")."</b></td>  
                                                                <td></td>    
                                                            </tr>
                                                            <tr>
                                                                <td style=\"vertical-align:middle; text-align: right\" colspan=2><b>Total Pago</b></td>    
                                                                <td style=\"vertical-align:middle; text-align: right\"><font color=blue><b>".fFormataMoeda($fValorTotal_Pago, "2")."</b></font></td>  
                                                                <td></td>    
                                                            </tr>
                                                            <tr>
                                                                <td style=\"vertical-align:middle; text-align: right\" colspan=2><b>Total Devedor</b></td>    
                                                                <td style=\"vertical-align:middle; text-align: right\"><font color=red><b>".fFormataMoeda($fValorTotal_Devedor, "2")."</b></font></td>  
                                                                <td></td>    
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div style=\"display:none;\"  id=\"mny_con_parcelas_detalhe\" name=\"mny_con_parcelas_detalhe\">$mny_con_parcelas_detalhe</div>
                                            ";                                        
                                        
                                            
                                            echo $sRetornoParc;
                                        }
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                    </div>    
                </form>
            </div> 
        </div>    
    </div>  
  </body>

  
<?fAbreMaximizado();?> 

<script>
    
    $(document).ready(function(){
      $(document).keypress(function(e){
            //alert(e.keyCode);
            if(e.wich == 19 || e.keyCode == 19){
                $('#form-contas').submit();
            }
            if(e.wich == 14 || e.keyCode == 14){
                window.location.href = '<?=$sUrlRaiz?>sis/contas/cadastro/modal.php';
            }    
            if(e.wich == 13 || e.keyCode == 13){
                return false;
            } 
            
            //$("#mny_con_tipo_movimentacao").focus();
      })
    })    
    
    
    
    $(document).ready(function(){
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var date_input=$('input[name="mny_con_data_base"]'); //our date input has the name "date"
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
        
        var date_input2=$('input[name="mny_con_pausada_data"]'); //our date input has the name "date"
        date_input2.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });        
        
    })
    
    
    
    $("#mny_con_id_origem").change(function(){
        if (document.getElementById('mny_con_id_origem').value == 16 || document.getElementById('mny_con_id_origem').value == 17 || document.getElementById('mny_con_id_origem').value == 18){
            // habilita
            $("#mny_con_id_categoria").removeAttr('disabled');
        }
        else {
            // desabilita
            $("#mny_con_id_categoria").attr('disabled','disabled');
        }
    });    
    
    $("#mny_con_id_peridiocidade").change(function(){
        if (document.getElementById('mny_con_id_peridiocidade').value == 7){
            // habilita
            $("#mny_con_parcelas").removeAttr('disabled');
        }
        else {
            // desabilita
            $("#mny_con_parcelas").attr('disabled','disabled');
            $("#mostra_parcelas").html('');
            $("#mny_con_parcelas").val('');
        }
    });
    
    $("#mny_con_parcelas").blur(function(){
        if (document.getElementById('mny_con_id_peridiocidade').value == 7 && 
            document.getElementById('mny_con_parcelas').value != "" &&
            document.getElementById('mny_con_valor').value != "" &&
            document.getElementById('mny_con_data_base').value != "" 
        ){
            retorna_parcelas();
        }
        else {
            $("#mostra_parcelas").html('');
        }
        
    });
    
    $("#mny_con_valor").blur(function(){
        if (document.getElementById('mny_con_id_peridiocidade').value == 7 && 
            document.getElementById('mny_con_parcelas').value != "" &&
            document.getElementById('mny_con_valor').value != "" &&
            document.getElementById('mny_con_data_base').value != "" 
        ){
            retorna_parcelas();
        }
        else {
            $("#mostra_parcelas").html('');
        }
    });
    
    
    $("#mny_con_data_base").change(function(){
        if (document.getElementById('mny_con_id_peridiocidade').value == 7 && 
            document.getElementById('mny_con_parcelas').value != "" &&
            document.getElementById('mny_con_valor').value != "" &&
            document.getElementById('mny_con_data_base').value != "" 
        ){
            retorna_parcelas();
        }
        else {
            $("#mostra_parcelas").html('');
        }
        
    }); 
    
              
    $('#form-contas').submit(function(){      
        
        if ($("#mny_con_parcelas_detalhe").length){ 

            var mny_con_parcelas_detalhe = $("#mny_con_parcelas_detalhe").val();
    
        }
        //alert($("#mny_con_parcelas_detalhe").html());
        
        $.ajax({
             url:"registra_contas.php",
             dataType: 'html',
             method: 'POST',
             data: {
                mny_con_id:$("#mny_con_id").val(),
                mny_con_data_base:$("#mny_con_data_base").val(),
                mny_con_valor:$("#mny_con_valor").val(),
                mny_con_parcelas:$("#mny_con_parcelas").val(),
                mny_con_parcelas_detalhe:$("#mny_con_parcelas_detalhe").html(),
                mny_con_id_peridiocidade:$("#mny_con_id_peridiocidade").val(),
                mny_con_observacao:$("#mny_con_observacao").val(),
                mny_con_tipo_movimentacao:$("#mny_con_tipo_movimentacao").val(),
                mny_con_id_origem:$("#mny_con_id_origem").val(),
                mny_con_pausada_data:$("#mny_con_pausada_data").val(),
                mny_con_id_categoria:$("#mny_con_id_categoria").val()
             },
                beforeSend:function(){
                $('#btnSalvar').attr('disabled','disabled');
                
            },
         }).done(function(data){
                var sRetorno   = data;

                if (sRetorno.trim() === "true"){
                    $('#message').html('<div class="alert alert-success">Registro salvo com sucesso!</div>');
                    $("#mostra_parcelas").html('');
                    $("#mny_con_parcelas").attr('disabled','disabled');
                    
                    if ($("#mny_con_id").val() != ""){
                        location.reload();
                    }
                    else{
                        document.getElementById("form-contas").reset();
                        $('#btnSalvar').attr('disabled',false);
			
                    }
                    
                    //$("#mny_con_tipo_movimentacao").focus();
                    
                }
                else {
                    $('#message').html('<div class="alert alert-danger">Problema ao salvar registro: '+sRetorno+'</div>');
                }
                
                setTimeout(LimpaMsg, 4000);
         });    
         
        return false;
        
    });
    
    function LimpaMsg(){
        $('#message').html('');
    }
    
    function retorna_parcelas(){
    var mny_con_data_base   = document.getElementById('mny_con_data_base').value;
    var mny_con_valor       = document.getElementById('mny_con_valor').value;
    var mny_con_parcelas    = document.getElementById('mny_con_parcelas').value;

        if ($("#mny_con_parcelas_detalhe").html() !== ""){
            if (confirm("Existem parcelas já geradas, informações sobre elas serão perdidas.\n Deseja continuar?") === false){
                return;
            }    
        }
        
        $.ajax({
             url:"retorna_parcelas.php",
             dataType: 'html',
             method: 'POST',
             data: {
                mny_con_data_base:mny_con_data_base,
                mny_con_valor:mny_con_valor,
                mny_con_parcelas:mny_con_parcelas
             }
         }).done(function(data){
                var sRetorno   = data;
                
                document.getElementById('mostra_parcelas').innerHTML = sRetorno;

         });    

    }    
    
    function excluir_registro(mny_con_id){

        var r = confirm("Deseja excluir o registro?");
            
        if (r == false){
            return;
        }

        $.ajax({
             url:"excluir_contas.php",
             dataType: 'html',
             method: 'POST',
             data: {
                mny_con_id:mny_con_id
             }
         }).done(function(data){
                var sRetorno   = data;
                
                if (sRetorno.trim() == "true"){
                    window.close();
                    opener.location.reload();
                }
                else if (sRetorno.trim() == "false1"){
                    alert("Código da conta inválida");
                }    
                else if (sRetorno.trim() == "false"){
                    alert("FALHA NA EXCLUSÃO! \nExistem lançamentos para esta conta, ela não poderá ser excluída. \nCaso seja necessário, colocar o lançamento em pausa.");
                }    

         });    

    }       
    
</script>

<?php
/*
if ($sFlagMostraParcela == true){
    echo "<script type=\"text/javascript\">
        $(document).ready(function() {
            retorna_parcelas();
        })
        </script>
    ";
}

    $aParc = json_decode(str_replace("|","\"",$mny_con_parcelas_detalhe));
    
    var_dump($aParc);
    
    echo "<BR>";
    
    $aUltimo = end($aParc);
    
    echo "parc: ".$aUltimo->parcela;
    
    $aUltimo->parcela = 10;
    
    echo "<BR>";
    
    echo str_replace("\"","|",json_encode($aParc));
    
    //foreach ($aParc[2] as $Valores) {

    //    echo $Valores->parcela." - ".$Valores->data."<BR>";
        
    //}
    
    //[parcela] => 1 [data] => 2020-10-15 [valor] => 142,00 [pago] => 0 )
 * 
 */
?>

</html>