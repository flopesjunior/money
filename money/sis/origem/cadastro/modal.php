<?php
require_once "../../../money.ini.php";

    $mny_ori_id         = $_GET["mny_ori_id"];
    
    if ($mny_ori_id) {
        
            $sSql = "SHOW COLUMNS FROM money_origem_transacao ";
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

                $sSql .= substr($sCamposConcat, 0, -2);

                $sSql .= " FROM money_origem_transacao WHERE mny_ori_id = $mny_ori_id";

                //echo "SQL: $sSql";
                $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarregaCampos <br>".$sSql);

                if ($SqlResult_2->NumRows() == 1) {

                    foreach ($aCampos as $sCampo){
                         eval("\$$sCampo = \"".  trim($SqlResult_2->fields[$sCampo]."\";"));
                    }

                }

            }
            
    }
?>

<html>
  <head>
    <title>_Modal.ORIGEM</title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    
    
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>sis/origem/cadastro/js.js" type="text/javascript" ></script>

    
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
<input type="hidden" value="<?=$mny_ori_id?>" id="mny_ori_id" name="mny_ori_id">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div><h1>Cadastro de Origem da Transação</h1></div>
                        </div>
                    </div>
                </div>
                <span id="message"></span>
                <form method="post" id="form-origem" autocomplete="off">
                    <div class="panel-body" >
                            <div class='row'>
                                    <table cellpadding=0 cellspacing=0 border=0 width=100%>
                                        <tr><td colspan="20" height="10"></td></td>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align=left>
                                                <button onclick="window.location.href = '<?=$sUrlRaiz?>sis/origem/cadastro/modal.php'" type="button" class="btn btn-warning" data-placement="top" title="Ctrl+N">NOVO</button> 
                                            </td>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td align=left>
                                                <button type="submit" name="btnSalvar" id="btnSalvar" class="btn btn-success" data-placement="top" title="Ctrl+S">SALVAR</button> 
                                            </td>                                         
                                            <td>&nbsp;&nbsp;</td>
                                            <td align=left>
                                                <button onclick="window.close();opener.location.reload();" type="button" class="btn btn-default">FECHAR</button></center>
                                            </td>                                                        
                                            <td>&nbsp;&nbsp;</td>
                                            <td align=right width="99%">
                                                <button onclick="excluir_registro(<?=$mny_ori_id?>)" type="button" class="btn btn-danger">EXCLUIR</button> 
                                            </td>    
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>  
                                        <tr><td colspan="20" height="10"></td></td>
                                    </table>                                
                            </div> 
                            <BR>
                            <div class='row'>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="validationCustom01">Descrição</label>
                                        <input class="form-control" type="text" name="mny_ori_descricao" id="mny_ori_descricao" value="<?=$mny_ori_descricao?>"/>                                
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
                $('#form-origem').submit();
            }
            if(e.wich == 14 || e.keyCode == 14){
                window.location.href = '<?=$sUrlRaiz?>sis/origem/cadastro/modal.php';                 
            }  
            if(e.wich == 13 || e.keyCode == 13){
                return false;
            }             
      })
    })    
        
    $('#form-origem').submit(function(){      
        
        $.ajax({
             url:"_salvar.php",
             dataType: 'html',
             method: 'POST',
             data: {
                mny_ori_id:$("#mny_ori_id").val(),
                mny_ori_descricao:$("#mny_ori_descricao").val()
             },
                beforeSend:function(){
                $('#btnSalvar').attr('disabled','disabled');
                
            },
         }).done(function(data){
                var sRetorno   = data;

                if (sRetorno.trim() === "true"){
                    $('#message').html('<div class="alert alert-success">Registro salvo com sucesso!</div>');
                    
                    if ($("#mny_ori_id").val() != ""){
                        location.reload();
                    }
                    else{
                        document.getElementById("form-origem").reset();
                        $('#btnSalvar').attr('disabled',false);
                    }
                    
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
    
    
    
    function excluir_registro(mny_ori_id){

        var r = confirm("Deseja excluir o registro?");
            
        if (r = false){
            return;
        }

        $.ajax({
             url:"_excluir.php",
             dataType: 'html',
             method: 'POST',
             data: {
                mny_ori_id:mny_ori_id
             }
         }).done(function(data){
                var sRetorno   = data;
                
                if (sRetorno.trim() == "true"){
                    window.close();
                    opener.location.reload();
                }

         });    

    }       
    
</script>

</html>