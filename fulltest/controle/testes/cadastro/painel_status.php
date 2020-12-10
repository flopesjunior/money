<?
require_once('../../../indicadores.ini.php');

    $ftt_tst_id         = $_GET["ftt_tst_id"];
    
    if ($ftt_tst_id) {
        $sSql = "
            select 	
            ftt_tst_id, 
            ftt_tst_id_candidato, 
            ftt_tst_status, 
            ftt_tst_data_cadastro, 
            ftt_tst_data_inicio, 
            ftt_tst_data_fim, 
            ftt_tst_id_prova,
            ftt_can_nome, 
            ftt_can_email,
            ftt_prv_nome
            from ftt_teste 
            inner join ftt_candidato on ftt_can_id = ftt_tst_id_candidato
            inner join ftt_prova on ftt_prv_id = ftt_tst_id_prova
            where ftt_tst_id = $ftt_tst_id
            ";   
//                                           echo $sSql."<BR>";

       $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


       if ($SqlResult_1->NumRows() > 0) {
            $ftt_tst_id                  = $SqlResult_1->fields["ftt_tst_id"];                              
            $ftt_tst_id_candidato        = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
            $ftt_tst_status              = $SqlResult_1->fields["ftt_tst_status"]; 
            $ftt_tst_data_cadastro       = $SqlResult_1->fields["ftt_tst_data_cadastro"];
            $ftt_tst_data_inicio         = $SqlResult_1->fields["ftt_tst_data_inicio"];
            $ftt_tst_data_fim            = $SqlResult_1->fields["ftt_tst_data_fim"];
            $ftt_tst_id_prova            = $SqlResult_1->fields["ftt_tst_id_prova"];
            $ftt_can_nome                = $SqlResult_1->fields["ftt_can_nome"];
            $ftt_can_email               = $SqlResult_1->fields["ftt_can_email"];
            $ftt_prv_nome                = $SqlResult_1->fields["ftt_prv_nome"];

            switch ($ftt_tst_status) {
                case 1:
                    $sStatus = "Aberto";
                    break;
                case 2:
                    $sStatus = "Em execução";
                    break;
                case 3:
                    $sStatus = "Pendente";
                    break;
                case 4:
                    $sStatus = "Finalizado";
                    break;            }
       }
       
}
?>

 <html>
  <head>
    <title>CADASTRO DAS TESTES - <?=$sNomeSistema?></title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/testes/cadastro/js.js" type="text/javascript" ></script>

    
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">       
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       
    
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../../../dist/css/timeline.css" rel="stylesheet">
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>    
    
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
  <form name="apuracao" method="post" action="<?=$PHP_SELF?>">
      <input type="hidden" value="<?=$sUrlRaiz?>" id="sUrlRaiz" name="sUrlRaiz">
      <input type="hidden" value="<?=$ftt_tst_id?>" id="ftt_tst_id" name="ftt_tst_id">
      <input type="hidden" value="<?=$ftt_tst_id_candidato?>" id="ftt_tst_id_candidato" name="ftt_tst_id_candidato">
      <input type="hidden" value="" id="em_invalido" name="em_invalido">

    <div class="row">
       <?
       $sTitulo = "CADASTRO DAS TESTES";
       ?>                          
   </div>
      
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-wrench fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div><h1>Cadastro de Testes</h1></div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" >
                        <div class='row'>
                                <table cellpadding=0 cellspacing=0 border=0 width=1%>
                                    <tr><td colspan="20" height="10"></td></td>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align=left>
                                            <button onclick="window.location.href = '<?=$sUrlRaiz?>controle/testes/cadastro/modal1.php'" type="button" class="btn btn-warning">NOVO</button> 
                                        </td>    
                                        <?if ($ftt_tst_status == 1 || !$ftt_tst_status){?>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left>
                                            <button onclick="registrar_teste();" type="button" class="btn btn-success">SALVAR</button> 
                                        </td>       
                                        <?}?>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left>
                                            <button onclick="window.close();opener.location.reload();" type="button" class="btn btn-default">FECHAR</button></center>
                                        </td>     
                                        <?if ($ftt_tst_status){?>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left nowrap>
                                            Status: <?=$sStatus?>
                                        </td>  
                                        <?}?>
                                    </tr>  
                                    <tr><td colspan="20" height="10"></td></td>
                                </table>                                
                        </div>                         
                        <div class='row'>
                            <div class='col-xs-12'>
                                <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                    <tr>
                                        <td align=left>
                                            <div class="panel panel-primary">
                                                <div class="panel-heading">
                                                    Dados do Candidato
                                                </div>    
                                                <div class="panel-body" >
                                                    <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                        <tr>
                                                            <td colspan="3" align=left>
                                                                Email do Candidato: 
                                                            </td>
                                                        </tr>  
                                                        <tr>    
                                                            <td>
                                                                <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                                    <tr>
                                                                        <td align=left width=1%>
                                                                            <input style="width: 500px" onblur="validacaoEmail(this);" class="form-control" name="ftt_can_email" id="ftt_can_email" value="<?=$ftt_can_email?>"></input>    
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;</td>
                                                                        <td align=left width=99% valign="center">
                                                                            <div id="candidato_existe"></div>
                                                                        </td>
                                                                    </tr>    
                                                                </table>
                                                            </td>    
                                                        </tr>
                                                        <tr><td height="10px"></td></tr>
                                                        <tr>
                                                            <td align=left>
                                                                Nome do Candidato: 
                                                            </td>
                                                        </tr>    
                                                        <tr>    
                                                            <td align=left>
                                                                <input class="form-control" name="ftt_can_nome" id="ftt_can_nome" value="<?=$ftt_can_nome?>"></input>    
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>      
                                         </td>
                                     </tr>    
                                     <tr><td height="10px"></td></tr>
                                     <tr>
                                        <td align=left>
                                            <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                <tr>
                                                    <td align=left>
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                Dados da Prova
                                                            </div>    
                                                            <div class="panel-body" >
                                                                
                                                                <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                                    <tr>
                                                                        <td align=left>
                                                                            Selecione a prova que será aplicada: 
                                                                        </td>
                                                                    </tr>    
                                                                    <tr>    
                                                                        <td align=left>
                                                                            <div class="form-group">
                                                                                    <select class="form-control" id="ftt_tst_id_prova" value=""  onchange="busca_prova()">
                                                                                            <option value='0'>Selecione</option>
                                                                                        <?
                                                                                            $sSql = "
                                                                                            select 
                                                                                            ftt_prv_id, 
                                                                                            ftt_prv_nome 
                                                                                            from ftt_prova
                                                                                            order by ftt_prv_nome
                                                                                            ";  
                                //                                    echo $sSql."<BR>";

                                                                                            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                                            if ($SqlResult_1->NumRows() > 0) {

                                                                                                while (!$SqlResult_1->EOF) {

                                                                                                    $ftt_prv_id                = $SqlResult_1->fields["ftt_prv_id"];                              
                                                                                                    $ftt_prv_nome              = $SqlResult_1->fields["ftt_prv_nome"]; 

                                                                                                    if ($ftt_tst_id_prova == $ftt_prv_id) $flag = "selected";
                                                                                                    else $flag = "";

                                                                                                    echo "<option value='$ftt_prv_id' $flag>$ftt_prv_nome</option>";

                                                                                                    $SqlResult_1->MoveNext();

                                                                                                 }                                                                    
                                                                                            }     
                                                                                        ?>
                                                                                    </select>
                                                                                </div>  
                                                                        </td>
                                                                    </tr>  
                                                                    <tr>
                                                                        <td>
                                                                            <div id="mostra_dados_prova"></div>
                                                                        </td>    
                                                                    </tr>   
                                                                </table>    
                                                                
                                                            </div>
                                                        </div>    
                                                    </td>
                                                </tr>                                                 
                                            </table>
                                         </td>
                                     </tr>                                         
                                </table>    
                            </div>
                        </div>   
                </div>
            </div>
        </div>
     </div>
  </form>    
  </body>
  
  <?fAbreMaximizado();?> 
  
     
</html>

  
  
