<?
require_once('../../../indicadores.ini.php');

    $ftt_prv_id         = $_GET["ftt_prv_id"];
    $ftt_prv_descricao  = "";
    $ftt_prv_tempo      = "0";
    
    if ($ftt_prv_id) {
        $sSql = "
            select 	
                    ftt_prv_id, 
                    ftt_prv_descricao, 
                    ftt_prv_nome, 
                    ftt_prv_tempo, 
                    ftt_prv_nivel, 
                    ftt_prv_data_cadastro, 
                    ftt_prv_data_ultalt
                    from ftt_prova 
                    where ftt_prv_id = $ftt_prv_id
            ";   
       //                                    echo $sSql."<BR>";

       $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


       if ($SqlResult_1->NumRows() > 0) {

               $ftt_prv_id                    = $SqlResult_1->fields["ftt_prv_id"];                              
               $ftt_prv_descricao             = $SqlResult_1->fields["ftt_prv_descricao"]; 
               $ftt_prv_nome                  = $SqlResult_1->fields["ftt_prv_nome"]; 
               $ftt_prv_tempo                 = $SqlResult_1->fields["ftt_prv_tempo"];
       }
       
}
?>

 <html>
  <head>
    <title>CADASTRO DAS PROVAS - <?=$sNomeSistema?></title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/provas/cadastro/js.js" type="text/javascript" ></script>

    
    <script src="../../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../../../dist/js/sb-admin-2.js"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">       
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css">       
    
    <link href="../../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="../../../dist/css/timeline.css" rel="stylesheet">
    <link href="../../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>     

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
      <input type="hidden" value="<?=$ftt_prv_id?>" id="ftt_prv_id" name="ftt_prv_id">
      <input type="hidden" value="" id="ftt_prc_id" name="ftt_prc_id">
      <input type="hidden" value="" id="qtd_questoes" name="qtd_questoes">

    <div class="row">
       <?
       $sTitulo = "CADASTRO DAS PROVAS";
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
                            <div><h1>Cadastro de Provas</h1></div>
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
                                            <button onclick="window.location.href = '<?=$sUrlRaiz?>controle/provas/cadastro/modal.php'" type="button" class="btn btn-warning">NOVO</button> 
                                        </td>    
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left>
                                            <button onclick="registrar_prova();" type="button" class="btn btn-success">SALVAR</button> 
                                        </td>                                         
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left>
                                            <button onclick="window.close();opener.location.reload();" type="button" class="btn btn-default">FECHAR</button></center>
                                        </td>                                                        
                                    </tr>  
                                    <tr><td colspan="20" height="10"></td></td>
                                </table>                                
                        </div>                         
                        <div class='row'>
                            <div class='col-xs-12 text-right'>
                                <div class='huge'>
                                    <center>
                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                        <tr>
                                            <td align=left>
                                                <h4>Coloque um nome para a prova:<h4/> 
                                            </td>
                                        </tr>    
                                        <tr>    
                                            <td align=left>
                                                <input class="form-control" name="ftt_prv_nome" id="ftt_prv_nome" value="<?=$ftt_prv_nome?>"></input>    
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td align=left>
                                                <h4>Escreva uma breve descrição da prova:<h4/> 
                                            </td>
                                        </tr>    
                                        <tr>    
                                            <td align=left>
                                                <div id="ftt_prv_descricao" name="ftt_prv_descricao"><?=$ftt_prv_descricao?></div>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#ftt_prv_descricao').summernote({
                                                            height: 150
                                                        });
                                                    });
                                                </script>                                                              
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align=left>
                                                <h4>Digite o tempo total da prova (em minutos): <h4/> 
                                            </td>
                                        </tr>    
                                        <tr>    
                                            <td align=left>
                                                <table cellpadding=0 cellspacing=5 border=0 width=20%>
                                                    <tr>
                                                        <td align=left>
                                                             <input class="form-control" name="ftt_prv_tempo" id="ftt_prv_tempo" onkeyup="somenteNumeros(this)" value="<?=$ftt_prv_tempo?>"></input>  
                                                        </td>    
                                                        <td align=left nowrap>
                                                            <h4>&nbsp;0 (zero) = indefinido<h4/> 
                                                        </td>                                                        
                                                    </tr>    
                                                </table>    
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td align=left>
                                                                                     
                                            </td>
                                        </tr>
                                        <tr><td height='30'></td></tr>
                                    </table>    
                                    </center>
                                </div>
                            </div>
                        </div>   
                    

                        <? if ($ftt_prv_id){ ?> 
                    
                        <div class='row'>
                            <div class='col-lg-12'>  
                                 <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Definir o grupo de questões da prova
                                    </div>    
                                    <div class="panel-body"> 
                                            <div id="alternativas">                    
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          
                                                        <tr>    
                                                            <td align=left> 
                                                                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>    
                                                                        <td align=left>
                                                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr><td>Especialidade</td></tr>
                                                                                <tr>    
                                                                                  <td align=left>
                                                                                        <div class="form-group">
                                                                                            <select style="width: 200px" class="form-control" id="ftt_prc_id_especialidade" value="" onchange="busca_qde_questoes()">
                                                                                                    <option value='0'>Selecione</option>
                                                                                                <?
                                                                                                    $sSql = "
                                                                                                    select 
                                                                                                    ftt_esp_id, 
                                                                                                    ftt_esp_descricao 
                                                                                                    from 
                                                                                                    ftt_especialidade
                                                                                                    order by ftt_esp_descricao
                                                                                                    ";  
                                        //                                    echo $sSql."<BR>";

                                                                                                    $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                                                    if ($SqlResult_1->NumRows() > 0) {

                                                                                                        while (!$SqlResult_1->EOF) {

                                                                                                            $ftt_esp_id                          = $SqlResult_1->fields["ftt_esp_id"];                              
                                                                                                            $ftt_esp_descricao                   = utf8_encode($SqlResult_1->fields["ftt_esp_descricao"]); 

                                                                                                            if ($ftt_per_id_especialidade == $ftt_esp_id) $flag = "selected";
                                                                                                            else $flag = "";

                                                                                                            echo "<option value='$ftt_esp_id' $flag>$ftt_esp_descricao</option>";

                                                                                                            $SqlResult_1->MoveNext();

                                                                                                         }                                                                    
                                                                                                    }     
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>                   
                                                                                    </td>
                                                                                </tr>  
                                                                              </table>  
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;</td>
                                                                        <td align=left>
                                                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td align=left nowrap>
                                                                                        Nível de dificuldade:
                                                                                    </td>
                                                                                </tr>                                         
                                                                                <tr>    
                                                                                    <td align=left>
                                                                                        <div class="form-group">
                                                                                            <select style="width: 200px" class="form-control" id="ftt_prc_nivel" value="" onchange="busca_qde_questoes()">
                                                                                                <option value='0' selected>Selecione</option>
                                                                                                <option value='1'>INICIANTE</option>
                                                                                                <option value='2'>JÚNIOR</option>
                                                                                                <option value='3'>PLENO</option>
                                                                                                <option value='4'>SENIOR</option>
                                                                                            </select>        
                                                                                        </div>                                       
                                                                                     </td>
                                                                                 </tr>                                             
                                                                              </table>  
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;</td>
                                                                        <td align=left valign='top'>
                                                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td align=left nowrap>
                                                                                        Qtd Questões:
                                                                                    </td>
                                                                                </tr>                                         
                                                                                <tr>    
                                                                                    <td align=left>
                                                                                        <input style="width: 200px" class="form-control" name="ftt_prc_quantidade" id="ftt_prc_quantidade" onkeyup="somenteNumeros(this)" value="0"></input>                             
                                                                                     </td>
                                                                                 </tr>                                             
                                                                              </table>  
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;</td>
                                                                        <td align=left valign='middle'>
                                                                            <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td align=left nowrap>
                                                                                        <button onclick="registrar_conteudo();" type="button" class="btn btn-success">SALVAR</button> 
                                                                                    </td>
                                                                                    <td>&nbsp;&nbsp;</td>
                                                                                    <td align=left nowrap>
                                                                                        <button onclick="limpar();" type="button" class="btn btn-default">LIMPAR</button> 
                                                                                    </td>
                                                                                    <td>&nbsp;&nbsp;</td>
                                                                                    <td align=left nowrap>
                                                                                        <button type="button" class="btn btn-default btn-circle" data-toggle="modal" data-target="#myModal"><i class="fa  fa-list-alt"></i></button> 
                                                                                    </td>
                                                                                </tr>                                         
                                                                              </table>  
                                                                        </td> 
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                          </tr>  
                                                          <tr>    
                                                            <td align=left>
                                                                <div id='mostra_quantidade'></div>
                                                            </td>
                                                          </tr> 
                                                          <tr><td height="10"></td></tr>
                                                          <tr>    
                                                            <td align=left valign='middle'>
                                                                <table width="1%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td align=left nowrap>
                                                                            <b>Total de Questões:</b> 
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;</td>
                                                                        <td align=left nowrap>
                                                                            <div id="tot_questoes"></div>
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                        <td align=left nowrap>
                                                                            <b>Pontuação Máxima:</b> 
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;</td>
                                                                        <td align=left nowrap>
                                                                            <div id="pontuacao_max"></div>
                                                                        </td>
                                                                    </tr>                                         
                                                                  </table>  
                                                            </td>                                                            
                                                          </tr>                                                         
                                                          <tr>
                                                             <td width="1%" nowrap  align="center">
                                                                     <?

                                                                                $sDisplay = "";

                                                                                $sSql = "
                                                                                     select 
                                                                                        ftt_prc_id, 
                                                                                        ftt_prc_id_especialidade, 
                                                                                        ftt_prc_nivel, 
                                                                                        ftt_prc_quantidade, 
                                                                                        ftt_prc_id_prova,	 
                                                                                        UCASE(ftt_esp_descricao) AS ftt_esp_descricao
                                                                                     from ftt_prova_conteudo 
                                                                                     inner join ftt_especialidade on (ftt_prc_id_especialidade = ftt_esp_id)
                                                                                     where ftt_prc_id_prova = $ftt_prv_id
                                                                                    ";  
                                                                                
                                            //                                    echo $sSql."<BR>";

                                                                                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                                $sDisplay .= "    
                                                                                    <table id=\"tabela001$iCount\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                                                                         <thead>
                                                                                            <tr>
                                                                                                <th width=\"1%\"></th>
                                                                                                <th width=\"1%\"></th>
                                                                                                <th width=\"1%\">#</th>
                                                                                                <th width=\"1%\" nowrap>Especialidade</th>
                                                                                                <th width=\"1%\" nowrap>Nível</th>
                                                                                                <th width=\"1%\" nowrap>Qtd Questões</th>
                                                                                                <th width=\"97%\">&nbsp;</th>
                                                                                            </tr>    
                                                                                         </thead>  
                                                                                         <tbody>
                                                                                        ";  

                                                                                if ($SqlResult_1->NumRows() > 0) {

                                                                                    $iCount = 1;
                                                                                    $iCount2 = 1;
                                                                                    $sModal   = "";
                                                                                    $iPontuacao = 0;
                                                                                    $iTotQuestoes = 0;

                                                                                    while (!$SqlResult_1->EOF) {
                                                                                        $ftt_esp_descricao             = utf8_encode($SqlResult_1->fields["ftt_esp_descricao"]);                              
                                                                                        $ftt_prc_nivel                 = $SqlResult_1->fields["ftt_prc_nivel"];
                                                                                        $ftt_prc_quantidade            = $SqlResult_1->fields["ftt_prc_quantidade"];
                                                                                        $ftt_prc_id                    = $SqlResult_1->fields["ftt_prc_id"];
                                                                                        $ftt_prc_id_especialidade      = $SqlResult_1->fields["ftt_prc_id_especialidade"];

                                                                                        
                                                                                        $iTotQuestoes = $iTotQuestoes + $ftt_prc_quantidade;
                                                                                        $iPontuacao = $iPontuacao + ($ftt_prc_nivel * $ftt_prc_quantidade);
                                                                                        
                                                                                        switch ($ftt_prc_nivel) {
                                                                                            case "1":
                                                                                                $nivel = "INICIANTE";
                                                                                                break;
                                                                                            case "2":
                                                                                                $nivel = "JÚNIOR";
                                                                                                break;
                                                                                            case "3":
                                                                                                $nivel = "PLENO";
                                                                                                break;
                                                                                            case "4":
                                                                                                $nivel = "SENIOR";
                                                                                                break;

                                                                                        }

                                                                                        $linkEdit = "onClick=\"editar_conteudo($ftt_prc_id, $ftt_prc_id_especialidade, $ftt_prc_nivel, '$ftt_prc_quantidade');\"";
                                                                                        $linkDel  = "onClick=\"deleta_conteudo($ftt_prc_id);\"";

                                                                                        $sDisplay .= "
                                                                                                   <tr>  
                                                                                                     <td width=1%>
                                                                                                        <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit ><i class=\"fa  fa-edit\"></i></button>
                                                                                                     </td>
                                                                                                     <td width=1%>
                                                                                                        <button type=\"button\" class=\"btn btn-default btn-circle\" $linkDel ><i class=\"fa  fa-times\"></i></button>
                                                                                                     </td>
                                                                                                     <td width=1%>
                                                                                                        $iCount 
                                                                                                     </td>
                                                                                                     <td nowrap>
                                                                                                        $ftt_esp_descricao 
                                                                                                     </td>
                                                                                                     <td>
                                                                                                        $nivel 
                                                                                                     </td>
                                                                                                     <td>
                                                                                                        $ftt_prc_quantidade 
                                                                                                     </td>
                                                                                                     <td>&nbsp;</td>
                                                                                                   </tr>

                                                                                        ";


                                                                                        $iCount++;
                                                                                        $iCount2++;

                                                                                        $SqlResult_1->MoveNext();

                                                                                    }




                                                                                }

                                                                                $sDisplay .= "</tbody></table>";        

                                                                                echo $sDisplay;

                                                                     ?>

   
                                                             </td>
                                                         </tr>
                                                         <tr><td align="right" height="10px"></td></tr>
                                                         <tr><td height="30px"></td></tr>
                                                  </table>
                                            </div> 
                                       </div> 
                                     </div>
                            </div>
                        </div> 
                    
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Especialidade x Quantidade</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?
                                                                                $sDisplay = "";

                                                                                $sSql = "
                                                                                            select 
                                                                                                    ftt_esp_descricao, ftt_per_nivel,
                                                                                                    count(*) as qde
                                                                                                    from ftt_pergunta
                                                                                            inner join ftt_especialidade on ftt_esp_id = ftt_per_id_especialidade
                                                                                            group by ftt_per_id_especialidade, ftt_per_nivel
                                                                                    ";  
                                                                                
                                            //                                    echo $sSql."<BR>";

                                                                                $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:serial_Listen");    


                                                                                $sDisplay .= "    
                                                                                    <table id=\"tabelaPerguntas\" class=\"display\" cellspacing=\"0\" width=\"100%\">
                                                                                         <thead>
                                                                                            <tr>
                                                                                                <th width=\"1%\" nowrap>Especialidade</th>
                                                                                                <th width=\"1%\" nowrap>Nível</th>
                                                                                                <th width=\"1%\" nowrap>Qtd</th>
                                                                                                <th width=\"97%\">&nbsp;</th>
                                                                                            </tr>    
                                                                                         </thead>  
                                                                                         <tbody>
                                                                                        ";  

                                                                                if ($SqlResult_1->NumRows() > 0) {

                                                                                    $iCount = 1;
                                                                                    $iCount2 = 1;
                                                                                    $sModal   = "";

                                                                                    while (!$SqlResult_1->EOF) {
                                                                                        $ftt_esp_descricao             = $SqlResult_1->fields["ftt_esp_descricao"];                              
                                                                                        $ftt_per_nivel                 = $SqlResult_1->fields["ftt_per_nivel"];
                                                                                        $qde            = $SqlResult_1->fields["qde"];

                                                                                        switch ($ftt_per_nivel) {
                                                                                            case "1":
                                                                                                $nivel = "INICIANTE";
                                                                                                break;
                                                                                            case "2":
                                                                                                $nivel = "JÚNIOR";
                                                                                                break;
                                                                                            case "3":
                                                                                                $nivel = "PLENO";
                                                                                                break;
                                                                                            case "4":
                                                                                                $nivel = "SENIOR";
                                                                                                break;

                                                                                        }

                                                                                        $sDisplay .= "
                                                                                                   <tr>  
                                                                                                     <td nowrap>
                                                                                                        $ftt_esp_descricao 
                                                                                                     </td>
                                                                                                     <td>
                                                                                                        $nivel 
                                                                                                     </td>
                                                                                                     <td>
                                                                                                        $qde 
                                                                                                     </td>
                                                                                                     <td>&nbsp;</td>
                                                                                                   </tr>

                                                                                        ";


                                                                                        $iCount++;
                                                                                        $iCount2++;

                                                                                        $SqlResult_1->MoveNext();

                                                                                    }




                                                                                }

                                                                                $sDisplay .= "</tbody></table>";        

                                                                                echo $sDisplay;

                                                                     ?>                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>                    
                    
                    
                        <?}?>
                </div>
            </div>
        </div>
     </div>
  </form>    
  </body>
  
  <?fAbreMaximizado();?> 
  
    <script>
          var table = $('table.display').DataTable({
                             "className": 'details-control',
                             "paging":   false,
                             "ordering": false,
                             "info":     false,
                             "language": {
                                         "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
                                     }                    
                         }   
                     );           
    </script>  
    
    <script>
        if (document.getElementById('tot_questoes')) document.getElementById('tot_questoes').innerHTML  = '<?=$iTotQuestoes?>';
        if (document.getElementById('pontuacao_max')) document.getElementById('pontuacao_max').innerHTML = '<?=$iPontuacao?>';
    </script>     
</html>

  
  
