<?
require_once('../../../indicadores.ini.php');

    $ftt_can_id         = $_GET["ftt_can_id"];
    
    if ($ftt_can_id) {
        //Busca todos os campos da tabela "configuracao"
            $sSql = "SHOW COLUMNS FROM ftt_candidato ";
            $SqlResult_1 = $dbsis_mysql->Execute($sSql) or die("ERRx001:CarregaConfiguracoes");

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

                $sSql .= " FROM ftt_candidato WHERE ftt_candidato.ftt_can_id = $ftt_can_id";

                //echo "SQL: $sSql";
                $SqlResult_2 = $dbsis_mysql->Execute($sSql) or die("ERRx002:CarrrregaConfiguracoes <br>".$sSql);

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
    <title>CADASTRO DAS PROVAS - <?=$sNomeSistema?></title>
      
  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="<?=$sUrlRaiz?>/scripts/css/default.css" type="text/css" />
    
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script language="JavaScript" src="<?=$sUrlRaiz?>controle/candidatos/cadastro/js.js" type="text/javascript" ></script>

    
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
      <input type="hidden" value="<?=$ftt_can_id?>" id="ftt_can_id" name="ftt_can_id">

    <div class="row">
       <?
       $sTitulo = "CADASTRO DOS CANDIDATOS";
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
                            <div><h1>Cadastro de Candidato</h1></div>
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
                                            <button onclick="window.location.href = '<?=$sUrlRaiz?>controle/candidatos/cadastro/modal.php'" type="button" class="btn btn-warning">NOVO</button> 
                                        </td>    
                                        <td>&nbsp;&nbsp;</td>
                                        <td align=left>
                                            <button onclick="registrar_candidato();" type="button" class="btn btn-success">SALVAR</button> 
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
                                                    <input class="form-control" name="ftt_prv_nome" placeholder="Nome" id="ftt_can_nome" value="<?=$ftt_can_nome?>"></input>    
                                                </td>
                                            </tr>
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_email" placeholder="Email" id="ftt_can_email" value="<?=$ftt_can_email?>"></input>    
                                                </td>
                                            </tr>
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left>
                                                                <input class="form-control" name="ftt_can_celular" placeholder="Celular" id="ftt_can_celular" value="<?=$ftt_can_celular?>"></input>    
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left>
                                                                <input class="form-control" name="ftt_can_telefone" placeholder="Telefone Fixo" id="ftt_can_telefone" value="<?=$ftt_can_telefone?>"></input>    
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr>    
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_endereco" placeholder="Endereço" id="ftt_can_endereco" value="<?=$ftt_can_endereco?>"></input>    
                                                </td>
                                            </tr>                                            
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left width=90%>
                                                                <input class="form-control" name="ftt_can_cidade" placeholder="Cidade" id="ftt_can_cidade" value="<?=$ftt_can_cidade?>"></input>    
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left width=10%>
                                                                <input class="form-control" name="ftt_can_uf" placeholder="UF" id="ftt_can_uf" value="<?=$ftt_can_uf?>"></input>    
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr> 
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left width=70%>
                                                                <select class="form-control" id="ftt_can_escolaridade" value="<?=$ftt_can_escolaridade?>">
                                                                    
                                                                    <?
                                                                        if ($ftt_can_escolaridade){
                                                                            switch ($ftt_can_escolaridade) {
                                                                                case 1:
                                                                                    $FlagEscolaridade1 = "Selected";
                                                                                    break;
                                                                                case 2:
                                                                                    $FlagEscolaridade2 = "Selected";
                                                                                    break;
                                                                                case 3:
                                                                                    $FlagEscolaridade3 = "Selected";
                                                                                    break;
                                                                                default:
                                                                                    $FlagEscolaridade0 = "Selected";
                                                                                    break;
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <option value='0' <?=$FlagEscolaridade0?>>-- Escolaridade --</option>
                                                                    <option value='1' <?=$FlagEscolaridade1?>>2º Grau</option>
                                                                    <option value='2' <?=$FlagEscolaridade2?>>Técnico</option>
                                                                    <option value='3' <?=$FlagEscolaridade3?>>Superior</option>
                                                                </select>           
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left width=10% nowrap>
                                                                <?
                                                                    if ($ftt_can_escolaridade_situacao == 1){
                                                                      $FlagSituação = "checked";  
                                                                    }
                                                                    else {
                                                                      $FlagSituação = ""; 
                                                                    }
                                                                ?>
                                                                <input type="checkbox" id="ftt_can_escolaridade_situacao" <?=$FlagSituação?>>Completo   
                                                            </td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td align=left width=20%>
                                                                <input class="form-control" name="ftt_can_escolaridade_ano_conclusao" placeholder="Ano Conclusão" id="ftt_can_escolaridade_ano_conclusao" value="<?=$ftt_can_escolaridade_ano_conclusao?>"></input>    
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr>                                               
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_instuicao_ensino" placeholder="Nome da Instituição de Ensino" id="ftt_can_instuicao_ensino" value="<?=$ftt_can_instuicao_ensino?>"></input>    
                                                </td>
                                            </tr>                                                          
                                            <tr><td height="10px"></td></tr>
                                            <tr>    
                                                <td align=left>
                                                    <input class="form-control" name="ftt_can_curso" placeholder="Curso" id="ftt_can_curso" value="<?=$ftt_can_curso?>"></input>    
                                                </td>
                                            </tr>   
                                            <tr><td height="10px"></td></tr>
                                            <tr>
                                                <td>
                                                    <table cellpadding=0 cellspacing=5 border=0 width=100% align=center>
                                                        <tr>    
                                                            <td align=left width=70%>
                                                                <select class="form-control" id="ftt_can_proc_status" value="<?=$ftt_can_proc_status?>">
                                                                    
                                                                    <?
                                                                        if ($ftt_can_proc_status){
                                                                            switch ($ftt_can_proc_status) {
                                                                                case 1:
                                                                                    $FlagProcStatus1 = "Selected";
                                                                                    break;
                                                                                case 2:
                                                                                    $FlagProcStatus2 = "Selected";
                                                                                    break;
                                                                                default:
                                                                                    $FlagProcStatus0 = "Selected";
                                                                                    break;
                                                                                
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <option value='0' <?=$FlagProcStatus0?>>-- Status Processo --</option>
                                                                    <option value='1' <?=$FlagProcStatus1?>>Entrevistado(a)</option>
                                                                    <option value='2' <?=$FlagProcStatus2?>>Contratado(a)</option>
                                                                </select>           
                                                            </td>
                                                        </tr>                                                        
                                                    </table>
                                                </td>    
                                            </tr>                                             
                                       </table>     
                                    </center>
                                </div>
                            </div>
                        </div> 
                        <br>
                        <div class='row'>
                            <div class='col-lg-12'>  
                                 <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Testes do candidato
                                    </div>    
                                    <div class="panel-body"> 
                                            <?
                         
                                                $sDisplay = "";

                                                $sSql = "
                                                    select 	
                                                    ftt_tst_id, 
                                                    ftt_tst_id_candidato, 
                                                    ftt_tst_tempo_excedido,
                                                    ftt_tst_bloqueado,
                                                    ftt_tst_status, 
                                                    date_format(ftt_tst_data_cadastro, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_cadastro,   
                                                    date_format(ftt_tst_data_inicio, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_inicio, 
                                                    date_format(ftt_tst_data_fim, '%d/%m/%Y %H:%i:%s') as ftt_tst_data_fim,  
                                                    ftt_tst_id_prova,
                                                    ftt_can_nome, 
                                                    ftt_can_email,
                                                    ftt_prv_nome,
                                                    timediff(ftt_tst_data_fim, ftt_tst_data_inicio) as tempo_total
                                                    from ftt_teste                                        
                                                    inner join ftt_candidato on ftt_can_id = ftt_tst_id_candidato
                                                    inner join ftt_prova on ftt_prv_id = ftt_tst_id_prova
                                                    where ftt_can_id = $ftt_can_id
                                                    order by ftt_tst_status asc, ftt_can_nome 
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
                                                                <th width=\"1%\" nowrap>Status</th>
                                                                <th width=\"1%\" nowrap>Prova</th>
                                                                <th width=\"1%\" nowrap>Data Cadastro</th>
                                                                <th width=\"1%\" nowrap>Data Inicio</th>
                                                                <th width=\"1%\" nowrap>Data Fim</th>
                                                                <th width=\"1%\" nowrap>Tempo Total</th>
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
                                                        $tempo_total                 = $SqlResult_1->fields["tempo_total"];
                                                        $ftt_tst_bloqueado           = $SqlResult_1->fields["ftt_tst_bloqueado"];
                                                        $ftt_tst_tempo_excedido      = $SqlResult_1->fields["ftt_tst_tempo_excedido"];



                                                        if (!$ftt_tst_data_inicio)  $ftt_tst_data_inicio = "-";
                                                        if (!$ftt_tst_data_fim)     $ftt_tst_data_fim = "-";
                                                        if (!$tempo_total)          $tempo_total = "-";

                                                        //1-aberto/2-em execução/3-pendente /4-finalizado
                                                        switch ($ftt_tst_status) {
                                                            case 1:
                                                                $sStatus = "<font color='#228B22'>Aberto</font>";
                                                                break;
                                                            case 2:
                                                                $sStatus = "<font color='#0000CD'>Em execução</font>";
                                                                break;
                                                            case 3:
                                                                $sStatus = "<font color='#DAA520'>Pendente</font>"; 
                                                                break;
                                                            case 4:

                                                                $sStatus2 = "";
                                                                if ($ftt_tst_bloqueado == "1"){
                                                                    $sStatus2 = " - Bloqueado pelo adm";
                                                                }
                                                                else if ($ftt_tst_tempo_excedido == "1"){
                                                                    $sStatus2 = " - Tempo expirado";
                                                                }

                                                                $sStatus = "Finalizado";
                                                                break;
                                                        }

                                                        if (strlen($ftt_prv_descricao) > 100){
                                                            $ftt_prv_descricao = substr($ftt_prv_descricao, 0, 100)."...";
                                                        }

                                                        $Tempo = m2h($ftt_prv_tempo);

                                                        $linkEdit = "onClick=\"JavaScript:window.open('".$sUrlRaiz."controle/testes/cadastro/modal1.php?ftt_tst_id=$ftt_tst_id','testecondidato','width=1280,height=550,top=10,left=10,scrollbars=yes,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=yes');\"";
                                                        $linkBlok  = "onClick=\"BloqueiaTeste($ftt_tst_id);\"";

                                                        $sDisplay .= "
                                                                   <tr>  
                                                                     <td width=1%>
                                                                        <button type=\"button\" class=\"btn btn-default btn-circle\" $linkEdit ><i class=\"fa fa-list\"></i></button>
                                                                     </td>
                                                                     <td width=1%>";

                                                                     if ($ftt_tst_status == 2){
                                                                       $sDisplay .= "<button type=\"button\" class=\"btn btn-default btn-circle\" $linkBlok ><i class=\"fa  fa-stop\"></i></button>";
                                                                     }  

                                                        $sDisplay .= "                                                         
                                                                     </td>
                                                                     <td width=1%>
                                                                        $iCount 
                                                                     </td>
                                                                     <td nowrap>
                                                                        $sStatus $sStatus2
                                                                     </td>
                                                                     <td nowrap>
                                                                        $ftt_prv_nome 
                                                                     </td>
                                                                     <td nowrap>
                                                                        $ftt_tst_data_cadastro 
                                                                     </td>
                                                                     <td nowrap>
                                                                        $ftt_tst_data_inicio 
                                                                     </td>
                                                                     <td nowrap>
                                                                        $ftt_tst_data_fim 
                                                                     </td>
                                                                     <td nowrap>
                                                                        $tempo_total 
                                                                     </td>
                                                                     <td>
                                                                         &nbsp;
                                                                     </td>
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
                                 </div> 
                            </div>
                        </div>    
                    
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
</html>

  
  
