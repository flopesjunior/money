<?
require_once('../../../indicadores.ini.php');

    $ftt_tst_id         = $_GET["ftt_tst_id"];
    
    if ($ftt_tst_id) {
        
        
        
        $sSql = "
            select 
            TIMEDIFF(ftt_tst_data_fiM,ftt_tst_data_inicio) as tempo_teste,
            ftt_tst_id, 
            ftt_tst_id_candidato, 
            ftt_tst_status, 
            ftt_tst_data_cadastro, 
            ftt_tst_data_inicio, 
            ftt_tst_data_fim, 
            ftt_tst_id_prova,
            ftt_tst_carrecao,
            ftt_can_nome, 
            ftt_can_email,
            ftt_prv_nome,
            ftt_tst_id_area,
            ftt_prv_tempo
            from ftt_teste 
            inner join ftt_candidato on ftt_can_id = ftt_tst_id_candidato
            inner join ftt_prova on ftt_prv_id = ftt_tst_id_prova
            where ftt_tst_id = $ftt_tst_id
            ";   
                                      //     echo $sSql."<BR>";

       $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    

       $aRetorno = array();
       if ($SqlResult_1->NumRows() > 0) {
            $ftt_tst_id                  = $SqlResult_1->fields["ftt_tst_id"];                              
            $ftt_tst_id_candidato        = $SqlResult_1->fields["ftt_tst_id_candidato"]; 
            $ftt_tst_status              = $SqlResult_1->fields["ftt_tst_status"]; 
            $ftt_tst_data_cadastro       = $SqlResult_1->fields["ftt_tst_data_cadastro"];
            $ftt_tst_data_inicio         = $SqlResult_1->fields["ftt_tst_data_inicio"];
            $ftt_tst_data_fim            = $SqlResult_1->fields["ftt_tst_data_fim"];
            $ftt_tst_id_prova            = $SqlResult_1->fields["ftt_tst_id_prova"];
            $ftt_tst_carrecao            = $SqlResult_1->fields["ftt_tst_carrecao"];
            $ftt_tst_id_area             = $SqlResult_1->fields["ftt_tst_id_area"];
            $ftt_can_nome                = $SqlResult_1->fields["ftt_can_nome"];
            $ftt_can_email               = $SqlResult_1->fields["ftt_can_email"];
            $ftt_prv_nome                = $SqlResult_1->fields["ftt_prv_nome"];
            $tempo_teste                 = $SqlResult_1->fields["tempo_teste"];
            $ftt_prv_tempo               = $SqlResult_1->fields["ftt_prv_tempo"];
            
            $Tempo = m2h($ftt_prv_tempo);

            switch ($ftt_tst_status) {
                case 1:
                    $sStatus = "Aberto";
                    $flag_campo = "";
                    break;
                case 2:
                    $sStatus = "Em execução";
                    $flag_campo = "disabled";
                    break;
                case 3:
                    $sStatus = "Pendente";
                    $flag_campo = "disabled";

                    $aRetorno                   = fRetornaCorrecao($ftt_tst_id);
                    $iTotalPerguntas            = $aRetorno["iTotalPerguntas"];
                    $aResultadoFinal            = $aRetorno["aResultadoFinal"]; 
                    $iTotalPontos               = $aRetorno["iTotalPontos"]; 
                    $iTotalCorreto              = $aRetorno["iTotalCorreto"];
                    $iTotalErrado               = $aRetorno["iTotalErrado"];
                    $iTotalAnuladoCandidato     = $aRetorno["iTotalAnuladoCandidato"];
                    $iTotalAnuladoTempo         = $aRetorno["iTotalAnuladoTempo"];               
                    break;
                case 4:
                    $sStatus = "Finalizado";
                    $flag_campo = "disabled";
                        
                    
                    $aRetorno                   = fRetornaCorrecao($ftt_tst_id);
                    $iTotalPerguntas            = $aRetorno["iTotalPerguntas"];
                    $aResultadoFinal            = $aRetorno["aResultadoFinal"]; 
                    $iTotalPontos               = $aRetorno["iTotalPontos"]; 
                    $iTotalCorreto              = $aRetorno["iTotalCorreto"];
                    $iTotalErrado               = $aRetorno["iTotalErrado"];
                    $iTotalAnuladoCandidato     = $aRetorno["iTotalAnuladoCandidato"];
                    $iTotalAnuladoTempo         = $aRetorno["iTotalAnuladoTempo"];               
                    
                    break;            
            }
                    
                    
       }
       
       $aResultadoTotalTeste = array();
       $aResultadoTotalTeste["correto"] = 0;
       $aResultadoTotalTeste["errado"] = 0;
       $aResultadoTotalTeste["anulado_candidato"] = 0;
       $aResultadoTotalTeste["anulado_tempo"] = 0;
       
       if ($aResultadoFinal){
            foreach ($aResultadoFinal as $value) {
                switch ($value) {
                    case "correto":
                        $aResultadoTotalTeste["correto"]++;
                        break;
                    case "errado":
                        $aResultadoTotalTeste["errado"]++;
                        break;
                    case "anulado_candidato":
                        $aResultadoTotalTeste["anulado_candidato"]++;
                        break;
                    case "anulado_tempo":
                        $aResultadoTotalTeste["anulado_tempo"]++;
                        break;
                }
            }
       }     
       
}
?>

 <html>
  <head>
    <title>RESULTADO  - <?=$sNomeSistema?></title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/testes/cadastro/js.js" type="text/javascript" ></script>

    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">  
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       

<!-- MetisMenu CSS -->
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../../../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">    
    
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>     
    
    
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
        
        .modal.modal-wide .modal-dialog {
          width: 90%;
        }
        .modal-wide .modal-body {
          overflow-y: auto;
        }
        #tallModal .modal-body p { margin-bottom: 900px }
    </style>    
    <script>
        $(".modal-wide").on("show.bs.modal", function() {
          var height = $(window).height() - 200;
          $(this).find(".modal-body").css("max-height", height);
        });        
    </script>    
    
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
                                        <td align=left valign="bottom">
                                            <button onclick="window.location.href = '<?=$sUrlRaiz?>controle/testes/cadastro/modal1.php'" type="button" class="btn btn-warning">NOVO</button> 
                                        </td>    
                                        <?if ($ftt_tst_status == 1 || !$ftt_tst_status){?>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left valign="bottom">
                                            <button onclick="registrar_teste();" type="button" class="btn btn-success">SALVAR</button> 
                                        </td>       
                                        <?}?>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left valign="bottom">
                                            <button onclick="window.close();opener.location.reload();" type="button" class="btn btn-default">FECHAR</button></center>
                                        </td>     
                                        <?if ($ftt_tst_status){?>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=right nowrap width="99%" valign="bottom">
                                                    Status: <b><?=$sStatus?></b>
                                        </td>  
                                        <td>&nbsp;&nbsp;</td>
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
                                                                            <input <?=$flag_campo?> style="width: 500px" onblur="validacaoEmail(this);" class="form-control" name="ftt_can_email" id="ftt_can_email" value="<?=$ftt_can_email?>"></input>    
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
                                                                <input <?=$flag_campo?> class="form-control" name="ftt_can_nome" id="ftt_can_nome" value="<?=$ftt_can_nome?>"></input>    
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
                                                                                <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                                                    <tr>
                                                                                        <td align=left>
                                                                                            Selecione a prova que será aplicada: 
                                                                                        </td>
                                                                                    </tr>    
                                                                                    <tr>    
                                                                                        <td align=left>
                                                                                            <div class="form-group">
                                                                                                    <select <?=$flag_campo?> class="form-control" id="ftt_tst_id_prova" value=""  onchange="busca_prova()">
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
                                                                            </td>    
                                                                        </tr>  
                                                                        
                                                                        <tr>
                                                                            <td align=left>    
                                                                                <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                                                    <tr>
                                                                                        <td align=left>
                                                                                            Selecione a área interessada: 
                                                                                        </td>
                                                                                    </tr>    
                                                                                    <tr>    
                                                                                        <td align=left>
                                                                                            <div class="form-group">
                                                                                                    <select <?=$flag_campo?> class="form-control" id="ftt_tst_id_area" value=""  onchange="busca_area()">
                                                                                                            <option value='0'>Selecione</option>
                                                                                                        <?
                                                                                                            $sSql = "
                                                                                                            select 	
                                                                                                                ftt_are_id, 
                                                                                                                ftt_are_desc, 
                                                                                                                ftt_are_responsavel, 
                                                                                                                ftt_are_email
                                                                                                            from ftt_area 
                                                                                                            ";  
                                                //                                    echo $sSql."<BR>";

                                                                                                            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                                                            if ($SqlResult_1->NumRows() > 0) {

                                                                                                                while (!$SqlResult_1->EOF) {

                                                                                                                    $ftt_are_id                = $SqlResult_1->fields["ftt_are_id"];                              
                                                                                                                    $ftt_are_desc              = $SqlResult_1->fields["ftt_are_desc"]; 

                                                                                                                    if ($ftt_tst_id_area == $ftt_are_id) $flag = "selected";
                                                                                                                    else $flag = "";

                                                                                                                    echo "<option value='$ftt_are_id' $flag>$ftt_are_desc</option>";

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
                                                                                            <div id="mostra_dados_area"></div>
                                                                                        </td>    
                                                                                    </tr>   
                                                                                </table>    
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
                                     <? if ($ftt_tst_id && $ftt_tst_status != 1){?>
                                     <tr>
                                        <td align=left>
                                            <? if ($ftt_tst_status == 4){?>
                                            <table cellpadding=0 cellspacing=0 border=0 width=100% align=center>
                                                <tr>
                                                    <td align=left>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <font color="#4F4F4F"><i class="fa  fa-bar-chart-o fa-5x"></i></font>
                                                                            </div>
                                                                            <div class="col-xs-9 text-right">
                                                                                <div class="huge"><font color="#4F4F4F"><?=$iTotalPontos?></font></div>
                                                                                <div><font color="#4F4F4F">TOTAL DE PONTOS</font></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <font color="#4F4F4F"><i class="fa  fa-clock-o fa-5x"></i></font>
                                                                            </div>
                                                                            <div class="col-xs-9 text-right">
                                                                                <div class="huge"><font color="#4F4F4F"><?=$tempo_teste?></font></div>
                                                                                <div><font color="#4F4F4F">TEMPO DO TESTE</font></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="panel panel-green">
                                                                    <div class="panel-heading">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <i class="fa fa-check fa-5x"></i>
                                                                            </div>
                                                                            <div class="col-xs-9 text-right">
                                                                                <?$porc_correto = round(($aResultadoTotalTeste["correto"]/$iTotalPerguntas) * 100)?>
                                                                                <div class="huge"><?=$aResultadoTotalTeste["correto"]?> (<?=$porc_correto?>%)</div>
                                                                                <div>CORRETAS</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                        
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="panel panel-red">
                                                                    <div class="panel-heading">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <i class="fa fa-times fa-5x"></i>
                                                                            </div>
                                                                            <div class="col-xs-9 text-right">
                                                                                <?$porc_errado = round(($aResultadoTotalTeste["errado"]/$iTotalPerguntas) * 100)?>
                                                                                <div class="huge"><?=$aResultadoTotalTeste["errado"]?> (<?=$porc_errado?>%)</div>
                                                                                <div>ERRADAS</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                        
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="panel panel-primary">
                                                                    <div class="panel-heading">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <i class="fa fa-minus-square-o fa-5x"></i>
                                                                            </div>
                                                                            <div class="col-xs-9 text-right">
                                                                                <?$porc_anu_cand = round(($aResultadoTotalTeste["anulado_candidato"]/$iTotalPerguntas) * 100)?>
                                                                                <div class="huge"><?=$aResultadoTotalTeste["anulado_candidato"]?> (<?=$porc_anu_cand?>%)</div>
                                                                                <div>ANULADAS PELO CANDIDATO</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>   
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="panel panel-yellow">
                                                                    <div class="panel-heading">
                                                                        <div class="row">
                                                                            <div class="col-xs-3">
                                                                                <i class="fa fa-minus-square fa-5x"></i>
                                                                            </div>
                                                                            <div class="col-xs-9 text-right">
                                                                                <? $porc_anu_tempo = round(($aResultadoTotalTeste["anulado_tempo"]/$iTotalPerguntas) * 100)?>
                                                                                <div class="huge"><?=$aResultadoTotalTeste["anulado_tempo"]?> (<?=$porc_anu_tempo?>%)</div>
                                                                                <div>ANULADAS POR TEMPO</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                                               
                                                        </div>   
                                                    <td>
                                                </tr>
                                            </table>
                                            <?}?>
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
                                                                <b><?=$iTotalPerguntas?> questões</b> selecionadas, com tempo máximo de <b> <?=$Tempo?> </b>.
                                                            </div>    
                                                            <div class="panel-body" >

                                                                <?
                                                                   
                                                                
                                                                    $sSql = "
                                                                   SELECT 
                                                                   ftt_per_id,
                                                                   ftt_per_tipo,
                                                                   ftt_per_nivel,
                                                                   ftt_tsp_corrigido, 
                                                                   ftt_tsp_id, 
                                                                   ftt_tsp_ordem, 
                                                                   ftt_tsp_resp_dissertativa,
                                                                   ftt_tsp_anulada_tmp_expirado,
                                                                   ftt_tsp_anulada
                                                                   from ftt_teste_perguntas 
                                                                   inner join ftt_pergunta on ftt_per_id = ftt_tsp_id_pergunta
                                                                   where 
                                                                   ftt_tsp_id_teste = $ftt_tst_id 
                                                                   order by ftt_tsp_ordem
                                                                    ";  
                                            //echo $sSql."<BR>";

                                                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                    if ($SqlResult_1->NumRows() > 0) {

                                                                        echo "<table cellpadding=0 cellspacing=0 border=0 width=100% align=center>";
                                                                        
                                                                        while (!$SqlResult_1->EOF) {

                                                                            $ftt_per_id                     = $SqlResult_1->fields["ftt_per_id"];    
                                                                            $ftt_tsp_id                     = $SqlResult_1->fields["ftt_tsp_id"];                              
                                                                            $ftt_tsp_ordem                  = $SqlResult_1->fields["ftt_tsp_ordem"]; 
                                                                            $ftt_tsp_resp_dissertativa      = $SqlResult_1->fields["ftt_tsp_resp_dissertativa"]; 
                                                                            $ftt_per_tipo                   = $SqlResult_1->fields["ftt_per_tipo"]; 
                                                                            $ftt_tsp_corrigido              = $SqlResult_1->fields["ftt_tsp_corrigido"]; 
                                                                            $ftt_per_nivel                  = $SqlResult_1->fields["ftt_per_nivel"]; 
                                                                            $ftt_tsp_anulada_tmp_expirado   = $SqlResult_1->fields["ftt_tsp_anulada_tmp_expirado"]; 
                                                                            $ftt_tsp_anulada                = $SqlResult_1->fields["ftt_tsp_anulada"]; 

                                                                            $aRetornaPontos = fRetornaPeso($ftt_per_nivel);
                                                                            $DescNivel = $aRetornaPontos[0]."(".$aRetornaPontos[1].")";
                                                                            
                                                                            switch ($ftt_per_tipo) {
                                                                                case "1":
                                                                                    $sTipo = "Dissertativa";
                                                                                    break;
                                                                                case "2":
                                                                                    $sTipo = "Escolha única";
                                                                                    break;
                                                                                case "3":
                                                                                    $sTipo = "Multipla escolha";
                                                                                    break;
                                                                            }
                                                                            
                                                                            $sStatus2 = "";
                                                                            if ($ftt_per_tipo == 1 && $ftt_tsp_corrigido == "N" && $ftt_tsp_anulada_tmp_expirado == 0 && $ftt_tsp_anulada == 0){
                                                                                $sTipoBotao = "warning";
                                                                                $sStatus2 = "<font color=#4F4F4F><i class='fa fa-pencil-square'></i>&nbsp; Necessita de correção</font>";
                                                                            }
                                                                            else {
                                                                                $sTipoBotao = "default";
                                                                                
                                                                                //echo $aResultadoFinal[$ftt_tsp_id]."<BR>";
                                                                                switch ($aResultadoFinal[$ftt_tsp_id]) {
                                                                                    case "correto":
                                                                                        $sStatus2 = "<font color=#4F4F4F><i class='fa fa-check'></i> CORRETO </font>";
                                                                                        break;
                                                                                    case "errado":
                                                                                        $sStatus2 = "<font color=#4F4F4F><i class='fa  fa-times'></i> ERRADO </font>";
                                                                                        break;
                                                                                    case "anulado_tempo":
                                                                                        $sStatus2 = "<font color=#4F4F4F><i class='fa  fa-times'></i> ANULADO TEMPO EXCEDIDO </font>";
                                                                                        break;
                                                                                    case "anulado_candidato":
                                                                                        $sStatus2 = "<font color=#4F4F4F><i class='fa  fa-times'></i> ANULADO PELO CANDIDATO </font>";
                                                                                        break;
                                                                                }
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            echo "
                                                                            <tr  style='border-bottom: thin solid #CCCCCC' height=40px>
                                                                                <td width=1%>
                                                                                    <button type=\"button\" class=\"btn btn-$sTipoBotao btn-sm\" data-toggle=\"modal\" data-target=\"#myModal\" onclick=\"busca_questao_correcao($ftt_tsp_id);\"> Questão #$ftt_tsp_ordem</button>
                                                                                </td>
                                                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                                                <td width=1% nowrap>
                                                                                    <h5>$DescNivel</h5>
                                                                                </td>
                                                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                                                <td width=1% nowrap>
                                                                                    <h5>$sTipo</h5>
                                                                                </td>
                                                                                <td>&nbsp;&nbsp;&nbsp;</td>
                                                                                <td width=99% nowrap>
                                                                                    <h5>$sStatus2</h5>
                                                                                </td>
                                                                            </tr>  
                                                                            <tr><td height=5px></td></tr>
                                                                            ";
                                                                            
                                                                            $SqlResult_1->MoveNext();

                                                                         }   
                                                                         
                                                                         echo "</table>";
                                                                    }     
                                                                
                                                                
                                                                ?>        
                                                            </div>
                                                        </div>    
                                                    </td>
                                                </tr>     
                                                
                                                <?if ($ftt_tst_status != 1 && $ftt_tst_status != ""){?>
                                                <tr>
                                                    <td>
                                                        <table cellpadding=0 cellspacing=0 border=0 width=1% align=right>
                                                            <td valign="bottom">
                                                                <button onclick="ResetTeste();" type="button" class="btn btn-danger">RESET</button> 
                                                            </td>
                                                        </table>    
                                                    </td>
                                                </tr>    
                                                <?}?>
                                                
                                                
                                            </table>
                                         </td>
                                     </tr>                                         
                                     <?}?>
                                </table>    
                            </div>
                        </div>   
                </div>
            </div>

     <!----------- DIV QUE MOSTRA AS QUESTÕES A SERAM CORRIGIDAS --->
     
     
            <div class="modal fade" id="myModal" style="width: 100% !important" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" >
                    <div class="modal-content">
                        <div id="mostra_questao"></div>    
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>      
     
     
     <!------------------------------------------------------------->
     
        
        
  </form>    
  </body>
  
  <?fAbreMaximizado();?> 
  
     
</html>

  
  
